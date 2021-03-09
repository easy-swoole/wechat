<?php


namespace EasySwoole\WeChat\MiniProgram\Auth;


use EasySwoole\WeChat\Kernel\ServiceContainer;
use EasySwoole\WeChat\Kernel\ServiceProviders;
use EasySwoole\WeChat\MiniProgram\Application;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class ServiceProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        if (!isset($app[ServiceProviders::AccessToken])) {
            $app[ServiceProviders::AccessToken] = function (ServiceContainer $app) {
                return new AccessToken($app);
            };
        }

        $app[Application::Auth] = function ($app) {
            return new Client($app);
        };
    }
}
