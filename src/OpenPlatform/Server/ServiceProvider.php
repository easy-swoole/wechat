<?php

namespace EasySwoole\WeChat\OpenPlatform\Server;

use EasySwoole\WeChat\Kernel\Encryptor;
use EasySwoole\WeChat\Kernel\ServiceContainer;
use EasySwoole\WeChat\Kernel\ServiceProviders;
use EasySwoole\WeChat\OpenPlatform\Application;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class ServiceProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        if (!isset($app[ServiceProviders::Encryptor])) {
            $app[ServiceProviders::Encryptor] = function (ServiceContainer $app) {
                return new Encryptor();
            };
        }

        if (!isset($app[Application::Server])) {
            $app[Application::Server] = function (ServiceContainer $app) {
                $guard = new Guard($app);
                $guard->registerHandlers();
                return $guard;
            };
        }
    }
}
