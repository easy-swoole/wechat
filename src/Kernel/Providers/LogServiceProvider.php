<?php


namespace EasySwoole\WeChat\Kernel\Providers;


use EasySwoole\WeChat\Kernel\Log\FileLogDriver;
use EasySwoole\WeChat\Kernel\ServiceContainer;
use EasySwoole\WeChat\Kernel\ServiceProviders;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class LogServiceProvider implements ServiceProviderInterface
{
    public function register(Container $pimple)
    {
        if (!isset($pimple[ServiceProviders::Logger])) {
            $pimple[ServiceProviders::Logger] = function (ServiceContainer $app) {
                return new FileLogDriver($app[ServiceProviders::Config]->get('log.tempDir') ?? sys_get_temp_dir());
            };
        }
    }
}