<?php


namespace EasySwoole\WeChat\OfficialAccount\User;


use EasySwoole\WeChat\Kernel\ServiceContainer;
use EasySwoole\WeChat\OfficialAccount\Application;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class ServiceProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        $app[Application::User] = function (ServiceContainer $app) {
            return new UserClient($app);
        };

        $app[Application::UserTag] = function (ServiceContainer $app) {
            return new TagClient($app);
        };
    }
}