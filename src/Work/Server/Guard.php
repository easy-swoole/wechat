<?php

namespace EasySwoole\WeChat\Work\Server;

use EasySwoole\WeChat\Kernel\Contracts\MessageInterface;
use EasySwoole\WeChat\Kernel\Contracts\RequestMessageInterface;
use EasySwoole\WeChat\Kernel\Exceptions\BadRequestException;
use EasySwoole\WeChat\Kernel\Exceptions\InvalidArgumentException;
use EasySwoole\WeChat\Kernel\Exceptions\RuntimeException;
use EasySwoole\WeChat\Kernel\Messages\News;
use EasySwoole\WeChat\Kernel\Messages\NewsItem;
use EasySwoole\WeChat\Kernel\Messages\Raw;
use EasySwoole\WeChat\Kernel\Messages\Text;
use EasySwoole\WeChat\Kernel\Psr\Response;
use EasySwoole\WeChat\Kernel\ServerGuard;
use EasySwoole\WeChat\Kernel\ServiceProviders;
use EasySwoole\WeChat\Kernel\Utility\XML;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use EasySwoole\WeChat\Kernel\Messages\Message;
use Throwable;

/**
 * Class Guard
 * @package EasySwoole\WeChat\Work\Server
 * @author: XueSi
 * @email: <1592328848@qq.com>
 */
class Guard extends ServerGuard
{
    /**
     * @param ServerRequestInterface $request
     * @return bool
     */
    public function isValidateRequest(ServerRequestInterface $request): bool
    {
        return isset($request->getQueryParams()['echostr']);
    }

    /**
     * @param ServerRequestInterface $request
     * @return bool
     */
    public function isSafeMode(ServerRequestInterface $request): bool
    {
        return true;
    }

    /**
     * @param ServerRequestInterface $request
     * @return $this
     * @throws BadRequestException
     */
    public function validate(ServerRequestInterface $request): ServerGuard
    {
        if (!$this->alwaysValidate && !$this->isSafeMode($request)) {
            return $this;
        }

        if (empty($request->getQueryParams()['msg_signature'])
            || empty($request->getQueryParams()['timestamp'])
            || empty($request->getQueryParams()['nonce'])
        ) {
            throw new BadRequestException('Invalid request params.', 400);
        }

        if (!$this->isValidateRequest($request)) {
            $postContent = $request->getBody()->getContents();
            if (0 === stripos($postContent, '<')) {
                $postContent = XML::parse($postContent);
            } else {
                throw new BadRequestException('Invalid request body.', 400);
            }

            if (empty($postContent) || !is_array($postContent)) {
                throw new BadRequestException('No message received.');
            }

            $makeSignature = $this->signature(
                $this->getToken(),
                $request->getQueryParams()['timestamp'] ?? "",
                $request->getQueryParams()['nonce'] ?? "",
                $postContent['Encrypt']
            );
        } else {
            // echostr 签名校验
            $makeSignature = $this->signature(
                $this->getToken(),
                $request->getQueryParams()['timestamp'] ?? "",
                $request->getQueryParams()['nonce'] ?? "",
                $request->getQueryParams()['echostr']
            );
        }

        if (($request->getQueryParams()['msg_signature'] ?? "") !== $makeSignature) {
            throw new BadRequestException('Invalid request signature.', 400);
        }

        return $this;
    }

    /**
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     * @throws Throwable
     */
    protected function resolve(ServerRequestInterface $request): ResponseInterface
    {
        if ($this->isValidateRequest($request)) {
            $replyMessage = $this->dispatch(Message::VALIDATE, $request);
        } else {
            $requestMessage = $this->parseRequest($request);
            $replyMessage = $this->dispatch($requestMessage->getType(), $requestMessage);
        }

        /**
         * "", []
         */
        if ((empty($replyMessage) && ($replyMessage !== 0 && $replyMessage !== "0"))) {
            return new Response(
                200,
                ['Content-Type' => 'application/text'],
                ''
            );
        }

        if ($replyMessage instanceof Raw) {
            $replyString = $replyMessage->__toString();
        } else {
            if (is_string($replyMessage) || is_numeric($replyMessage)) {
                $replyMessage = new Text($replyMessage);
            } elseif (is_array($replyMessage) && reset($replyMessage) instanceof NewsItem) {
                $replyMessage = new News($replyMessage);
            }

            if (!$replyMessage instanceof MessageInterface) {
                throw new InvalidArgumentException(sprintf('Invalid Messages type "%s".', gettype($replyMessage)));
            }

            /** 除非 Message::VALIDATE 出了问题 否则不会走走这里 */
            if (!isset($requestMessage)) {
                throw new RuntimeException("Invalid request message.");
            }
            $replyString = $this->buildReply($requestMessage->getFromUserName(), $requestMessage->getToUserName(), $replyMessage);
        }

        if ($this->isSafeMode($request) && !$this->isValidateRequest($request)) {
            $encrypted = $this->app[ServiceProviders::Encryptor]->encrypt(
                $replyString,
                $this->app[ServiceProviders::Config]->get("aesKey"),
                $this->app[ServiceProviders::Config]->get("corpId")
            );
            $replyString = $this->buildEncryptedReply($encrypted);
        }

        return new Response(
            200,
            ['Content-Type' => 'application/xml'],
            $replyString
        );
    }


    /**
     * @param array $message
     * @return string|null
     */
    protected function decryptMessage(array $message): ?string
    {
        $configs = $this->app->getConfig();
        $appId = $configs['corpId'];
        $aesKey = $configs['aesKey'];

        return $this->app[ServiceProviders::Encryptor]->decrypt(
            $message['Encrypt'],
            $aesKey,
            $appId
        );
    }

    /**
     * @param array $message
     * @return RequestMessageInterface
     */
    protected function buildRequestMessage(array $message): RequestMessageInterface
    {
        return new class($message) extends Message implements RequestMessageInterface
        {
            public function getType(): string
            {
                return $this->get('MsgType');
            }

            public function getId(): ?int
            {
                return $this->get('MsgId');
            }

            public function getToUserName(): ?string
            {
                return $this->get('ToUserName');
            }

            public function getFromUserName(): ?string
            {
                return $this->get('FromUserName');
            }

            public function getCreateTime(): ?int
            {
                return $this->get('CreateTime');
            }

            public function toXmlArray(): array
            {
                return $this->all();
            }
        };
    }
}
