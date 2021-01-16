<?php


namespace EasySwoole\WeChat\BasicService\Jssdk;


use EasySwoole\WeChat\BasicService\Application;
use EasySwoole\WeChat\Kernel\ServiceContainer;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class ServiceProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        if (!isset($app[Application::Jssdk])) {
            $app[Application::Jssdk] = function (ServiceContainer $app) {
                return new Client($app);
            };
        }

        if (!isset($app[Application::Ticket])) {
            $app[Application::Ticket] = function (ServiceContainer $app) {
                return new Ticket($app);
            };
        }
    }
}