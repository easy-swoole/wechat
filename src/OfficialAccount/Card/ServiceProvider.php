<?php


namespace EasySwoole\WeChat\OfficialAccount\Card;


use EasySwoole\WeChat\Kernel\ServiceContainer;
use EasySwoole\WeChat\OfficialAccount\Application;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class ServiceProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        $app[Application::Card] = function (ServiceContainer $app) {
            return new Card($app);
        };

        $app[Card::BoardingPass] = function (ServiceContainer $app) {
            return new BoardingPassClient($app);
        };
    }
}