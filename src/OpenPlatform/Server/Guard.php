<?php

namespace EasySwoole\WeChat\OpenPlatform\Server;

use EasySwoole\WeChat\Kernel\Contracts\RequestMessageInterface;
use EasySwoole\WeChat\Kernel\Exceptions\BadRequestException;
use EasySwoole\WeChat\Kernel\Exceptions\InvalidArgumentException;
use EasySwoole\WeChat\Kernel\Messages\Message;
use EasySwoole\WeChat\Kernel\Psr\Response;
use EasySwoole\WeChat\Kernel\ServerGuard;
use EasySwoole\WeChat\OpenPlatform\Server\Handlers\AuthorizedHandler;
use EasySwoole\WeChat\OpenPlatform\Server\Handlers\UnauthorizedHandler;
use EasySwoole\WeChat\OpenPlatform\Server\Handlers\UpdateAuthorizedHandler;
use EasySwoole\WeChat\OpenPlatform\Server\Handlers\VerifyTicketRefreshedHandler;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;
use Throwable;

class Guard extends ServerGuard
{
    public const EVENT_AUTHORIZED = 'authorized';
    public const EVENT_UNAUTHORIZED = 'unauthorized';
    public const EVENT_UPDATE_AUTHORIZED = 'updateauthorized';
    public const EVENT_COMPONENT_VERIFY_TICKET = 'component_verify_ticket';
    public const EVENT_THIRD_FAST_REGISTERED = 'notify_third_fasteregister';

    /**
     * @param ServerRequestInterface $request
     * @return ResponseInterface
     * @throws BadRequestException
     * @throws Throwable
     */
    protected function resolve(ServerRequestInterface $request): ResponseInterface
    {
        $message = $this->parseRequest($request);

        $this->dispatch($message->getType(), $message);

        return new Response(
            200,
            ['Content-Type' => 'application/text'],
            static::SUCCESS_EMPTY_RESPONSE
        );
    }

    /**
     * @param ServerRequestInterface $request
     * @return bool
     */
    public function isValidateRequest(ServerRequestInterface $request): bool
    {
        return isset($request->getQueryParams()['echostr']);
    }

    /**
     * @param array $message
     * @return RequestMessageInterface
     */
    protected function buildRequestMessage(array $message): RequestMessageInterface
    {
        return new class($message) extends Message implements RequestMessageInterface {
            public function getType(): string
            {
                return $this->get('InfoType');
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
        };
    }

    /**
     * @throws InvalidArgumentException
     */
    public function registerHandlers()
    {
        $this->push(new AuthorizedHandler(), self::EVENT_AUTHORIZED);
        $this->push(new UnauthorizedHandler(), self::EVENT_UNAUTHORIZED);
        $this->push(new UpdateAuthorizedHandler(), self::EVENT_UPDATE_AUTHORIZED);
        $this->push(new VerifyTicketRefreshedHandler($this->app), self::EVENT_COMPONENT_VERIFY_TICKET);
    }
}
