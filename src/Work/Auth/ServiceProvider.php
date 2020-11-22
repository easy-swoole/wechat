<?php


namespace EasySwoole\WeChat\Work\Auth;


use EasySwoole\WeChat\Kernel\ServiceContainer;
use EasySwoole\WeChat\Kernel\ServiceProviders;
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
    }
}