<?php

namespace EasySwoole\WeChat\OpenPlatform\Authorizer\MiniProgram\PrivacyConfig;

use EasySwoole\WeChat\OpenPlatform\Authorizer\MiniProgram\Application;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class ServiceProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        $app[Application::PrivacyConfig] = function ($app) {
            return new Client($app);
        };
    }
}