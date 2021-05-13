<?php

namespace EasySwoole\WeChat\OpenPlatform\Base;

use EasySwoole\WeChat\OfficialAccount\Application;
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
