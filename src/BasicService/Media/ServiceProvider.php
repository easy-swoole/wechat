<?php


namespace EasySwoole\WeChat\BasicService\Media;


use EasySwoole\WeChat\BasicService\Application;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class ServiceProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        $app[Application::Media] = function ($app) {
            return new Client($app);
        };
    }
}