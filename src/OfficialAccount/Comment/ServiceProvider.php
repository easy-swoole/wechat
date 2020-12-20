<?php


namespace EasySwoole\WeChat\OfficialAccount\Comment;


use EasySwoole\WeChat\Kernel\ServiceContainer;
use EasySwoole\WeChat\OfficialAccount\Application;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class ServiceProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        $app[Application::Comment] = function (ServiceContainer $app) {
            return new Client($app);
        };
    }
}