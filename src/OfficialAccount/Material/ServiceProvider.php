<?php

namespace EasySwoole\WeChat\OfficialAccount\Material;

use EasySwoole\WeChat\OfficialAccount\Application;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class ServiceProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        $app[Application::Material] = function ($app) {
            return new Client($app);
        };
    }
}