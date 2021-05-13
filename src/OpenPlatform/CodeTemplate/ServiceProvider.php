<?php

namespace EasySwoole\WeChat\OpenPlatform\CodeTemplate;

use EasySwoole\WeChat\OpenPlatform\Application;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class ServiceProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        $app[Application::CodeTemplate] = function ($app) {
            return new Client($app);
        };
    }
}
