<?php


namespace EasySwoole\WeChat\Kernel\Providers;


use EasySwoole\WeChat\Kernel\Cache\FileCacheDriver;
use EasySwoole\WeChat\Kernel\ServiceContainer;
use EasySwoole\WeChat\Kernel\ServiceProviders;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class CacheServiceProvider implements ServiceProviderInterface
{
    public function register(Container $pimple)
    {
        if (!isset($pimple[ServiceProviders::Cache])) {
            $pimple[ServiceProviders::Cache] = function (ServiceContainer $app) {
                return new FileCacheDriver(
                    $app[ServiceProviders::Config]->get('cache.tempDir') ?? sys_get_temp_dir()
                );
            };
        }
    }
}