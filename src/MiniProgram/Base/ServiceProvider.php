<?php

namespace EasySwoole\WeChat\MiniProgram\Base;

use EasySwoole\WeChat\MiniProgram\Application;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class ServiceProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        $app[Application::Base] = function ($app) {
            return new Client($app);
        };
    }
}