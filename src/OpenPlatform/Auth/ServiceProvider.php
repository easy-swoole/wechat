<?php

namespace EasySwoole\WeChat\OpenPlatform\Auth;

use EasySwoole\WeChat\Kernel\ServiceProviders;
use EasySwoole\WeChat\OpenPlatform\Application;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class ServiceProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        if (!isset($app[ServiceProviders::AccessToken])) {
            $app[ServiceProviders::AccessToken] = function (Application $app) {
                return new AccessToken($app);
            };

            $app[Application::VerifyTicket] = function (Application $app) {
                return new VerifyTicket($app);
            };
        }
    }
}
