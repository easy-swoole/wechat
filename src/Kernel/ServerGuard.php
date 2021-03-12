<?php


namespace EasySwoole\WeChat\Kernel;


use EasySwoole\WeChat\Kernel\Contracts\MessageInterface;
use EasySwoole\WeChat\Kernel\Contracts\RequestMessageInterface;
use EasySwoole\WeChat\Kernel\Exceptions\BadRequestException;
use EasySwoole\WeChat\Kernel\Exceptions\InvalidArgumentException;
use EasySwoole\WeChat\Kernel\Exceptions\RuntimeException;
use EasySwoole\WeChat\Kernel\Messages\Message;
use EasySwoole\WeChat\Kernel\Messages\News;
use EasySwoole\WeChat\Kernel\Messages\NewsItem;
use EasySwoole\WeChat\Kernel\Messages\Raw;
use EasySwoole\WeChat\Kernel\Messages\Text;
use EasySwoole\WeChat\Kernel\Psr\Response;
use EasySwoole\WeChat\Kernel\Traits\Observable;
use EasySwoole\WeChat\Kernel\Utility\Random;
use EasySwoole\WeChat\Kernel\Utility\XML;
use Exception;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Throwable;

abstract class ServerGuard
{
    /** @var string */
    const SUCCESS_EMPTY_RESPONSE = 'success';

    use Observable;

    /** @var ServiceContainer */
    protected $app;
    /** @var bool */
    protected $alwaysValidate = false;

    public function __construct(ServiceContainer $app)
    {
        $this->app = $app;
    }

    /**
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     * @throws BadRequestException
     * @throws Throwable
     */
    public function serve(ServerRequestInterface $request): ResponseInterface
    {
        $response = $this->validate($request)->resolve($request);
        $this->app[ServiceProviders::Logger]->debug('Server response created:', ['content' => $response->getBody()]);
        return $response;
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

        if (empty($request->getQueryParams()['signature'])
            || empty($request->getQueryParams()['timestamp'])
            || empty($request->getQueryParams()['nonce'])
        ) {
            throw new BadRequestException('Invalid request params.', 400);
        }

        if (($request->getQueryParams()['signature'] ?? "") !== $this->signature(
                $this->getToken(),
                $request->getQueryParams()['timestamp'] ?? "",
                $request->getQueryParams()['nonce'] ?? ""
            )) {
            throw new BadRequestException('Invalid request signature.', 400);
        }

        return $this;
    }

    /**
     * @return $this
     */
    public function forceValidate()
    {
        $this->alwaysValidate = true;

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
         * "success", "", []
         */
        if (self::SUCCESS_EMPTY_RESPONSE === $replyMessage || (empty($replyMessage) && ($replyMessage !== 0 && $replyMessage !== "0"))) {
            return new Response(
                200,
                ['Content-Type' => 'application/text'],
                static::SUCCESS_EMPTY_RESPONSE
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

        if ($this->isSafeMode($request)) {
            $encrypted = $this->app[ServiceProviders::Encryptor]->encrypt(
                $replyString,
                $this->app[ServiceProviders::Config]->get("aesKey"),
                $this->app[ServiceProviders::Config]->get("appId")
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
     * @param ServerRequestInterface $request
     * @return RequestMessageInterface
     * @throws BadRequestException
     */
    public function parseRequest(ServerRequestInterface $request): RequestMessageInterface
    {
        $message = $this->parseMessage($request->getBody()->__toString());

        if ($this->isSafeMode($request) && !empty($message['Encrypt'])) {
            $messageString = $this->decryptMessage($message);

            $message = json_decode($messageString, true);
            if (!$message || (JSON_ERROR_NONE === json_last_error())) {
                $message = XML::parse($messageString);
            }
        }

        return $this->buildRequestMessage($message);
    }

    /**
     * @param ServerRequestInterface $request
     * @return bool
     */
    public function isSafeMode(ServerRequestInterface $request): bool
    {
        return ($request->getQueryParams()['signature'] ?? false)
            && 'aes' === ($request->getQueryParams()['encrypt_type'] ?? null);
    }

    /**
     * @param $event
     * @param $payload
     * @return MessageInterface|null|array|string|bool
     * @throws Throwable
     */
    public function dispatch($event, $payload)
    {
        return $this->notify($event, $payload);
    }

    /**
     * @param string $content
     * @return array
     * @throws BadRequestException
     */
    protected function parseMessage(string $content): array
    {
        try {
            if (0 === stripos($content, '<')) {
                $content = XML::parse($content);
            } else {
                $dataSet = json_decode($content, true);
                if ($dataSet && (JSON_ERROR_NONE === json_last_error())) {
                    $content = (array)$dataSet;
                }
            }

            if (empty($content) || !is_array($content)) {
                throw new BadRequestException('No message received.');
            }

            return $content;
        } catch (BadRequestException $badRequestException) {
            throw $badRequestException;
        } catch (Exception $e) {
            throw new BadRequestException(sprintf('Invalid message content:(%s) %s', $e->getCode(), $e->getMessage()), $e->getCode());
        }
    }

    /**
     * @return string|null
     */
    protected function getToken(): ?string
    {
        return $this->app[ServiceProviders::Config]->get("token");
    }

    /**
     * @param string ...$params
     * @return string
     */
    protected function signature(string ...$params)
    {
        sort($params, SORT_STRING);

        return sha1(implode($params));
    }

    protected function buildReply(string $to, string $from, MessageInterface $message): string
    {
        $prepends = [
            'ToUserName' => $to,
            'FromUserName' => $from,
            'CreateTime' => time(),
            'MsgType' => $message->getType(),
        ];

        return $message->transformToXml($prepends);
    }

    /**
     * @param string $encrypted
     * @return string
     */
    protected function buildEncryptedReply(string $encrypted): string
    {
        $timestamp = time();
        $nonce = Random::character(9, "0123456789");
        return XML::build([
            'Encrypt' => $encrypted,
            'MsgSignature' => $this->signature($this->getToken(), $timestamp, $nonce, $encrypted),
            'TimeStamp' => $timestamp,
            'Nonce' => $nonce,
        ]);
    }

    /**
     * @param array $message
     * @return string|null
     */
    protected function decryptMessage(array $message): ?string
    {
        return $this->app[ServiceProviders::Encryptor]->decrypt(
            $message['Encrypt'],
            $this->app[ServiceProviders::Config]->get("aesKey"),
            $this->app[ServiceProviders::Config]->get("appId")
        );
    }

    /**
     * @param ServerRequestInterface $request
     * @return bool
     */
    public function isValidateRequest(ServerRequestInterface $request): bool
    {
        return false;
    }

    /**
     * @param array $message
     * @return RequestMessageInterface
     */
    abstract protected function buildRequestMessage(array $message): RequestMessageInterface;
}
