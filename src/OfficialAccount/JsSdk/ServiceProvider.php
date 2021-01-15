<?php


namespace EasySwoole\WeChat\OfficialAccount\JsSdk;


use EasySwoole\WeChat\Kernel\ServiceContainer;
use EasySwoole\WeChat\Kernel\ServiceProviders;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class ServiceProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        if (!isset($app[ServiceProviders::JsSdk])) {
            $app[ServiceProviders::JsSdk] = function (ServiceContainer $app) {
                return new JsSdk($app);
            };
        }
    }
}