<?php


namespace EasySwoole\WeChat\Kernel\Providers;


use EasySwoole\WeChat\Kernel\Config;
use EasySwoole\WeChat\Kernel\ServiceContainer;
use EasySwoole\WeChat\Kernel\ServiceProviders;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class ConfigServiceProvider implements ServiceProviderInterface
{
    public function register(Container $pimple)
    {
        if (!isset($pimple[ServiceProviders::Config])) {
            $pimple[ServiceProviders::Config] = function (ServiceContainer $app) {
                return new Config($app->getConfig());
            };
        }
    }
}