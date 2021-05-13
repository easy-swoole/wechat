<?php

namespace EasySwoole\WeChat\OpenPlatform\Server\Handlers;

use EasySwoole\WeChat\Kernel\Contracts\EventHandlerInterface;
use EasySwoole\WeChat\Kernel\Contracts\RequestMessageInterface;
use EasySwoole\WeChat\Kernel\ServiceContainer;
use EasySwoole\WeChat\OpenPlatform\Application;
use EasySwoole\WeChat\OpenPlatform\Server\Guard;

class VerifyTicketRefreshedHandler implements EventHandlerInterface
{
    protected $app;

    public function __construct(ServiceContainer $app)
    {
        $this->app = $app;
    }

    /**
     * @param null $request
     * @return mixed|void
     */
    public function handle($request = null)
    {
        if ($request instanceof RequestMessageInterface && $request->getType() === Guard::EVENT_COMPONENT_VERIFY_TICKET) {
            $this->app[Application::VerifyTicket]->setTicket($request->transformForJsonRequest()['ComponentVerifyTicket']);
        }
    }
}
