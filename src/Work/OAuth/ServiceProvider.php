<?php
namespace EasySwoole\WeChat\Work\OAuth;


use EasySwoole\WeChat\Work\Application;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class ServiceProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        $app[Application::OAuth] = function ($app) {
            return new Client($app);
        };
    }
}
