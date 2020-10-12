<?php


namespace EasySwoole\WeChat\OfficialAccount\Base;


use EasySwoole\WeChat\OfficialAccount\Application as BaseApplication;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class Application implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        $app[BaseApplication::BASE] = function ($app) {
            return new Client($app);
        };
    }
}