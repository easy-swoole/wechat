<?php

namespace EasySwoole\WeChat\MiniProgram\NearbyPoi;

use EasySwoole\WeChat\MiniProgram\Application;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class ServiceProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        $app[Application::NearbyPoi] = function ($app) {
            return new Client($app);
        };
    }
}