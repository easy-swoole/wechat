<?php

namespace EasySwoole\WeChat\OfficialAccount\Broadcasting;

use EasySwoole\WeChat\OfficialAccount\Application;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class ServiceProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        $app[Application::Broadcasting] = function ($app) {
            return new Client($app);
        };
    }
}