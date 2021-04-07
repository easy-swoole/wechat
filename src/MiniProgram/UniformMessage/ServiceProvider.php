<?php

namespace EasySwoole\WeChat\MiniProgram\UniformMessage;

use EasySwoole\WeChat\MiniProgram\Application;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class ServiceProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        $app[Application::UniformMessage] = function ($app) {
            return new Client($app);
        };
    }
}