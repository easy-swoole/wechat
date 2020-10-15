<?php


namespace EasySwoole\WeChat\Kernel\Providers;


use EasySwoole\WeChat\Kernel\HttpClient\HttpClientManager;
use EasySwoole\WeChat\Kernel\HttpClient\SwooleClientDriver;
use EasySwoole\WeChat\Kernel\ServiceContainer;
use EasySwoole\WeChat\Kernel\ServiceProviders;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class HttpClientServiceProvider implements ServiceProviderInterface
{
    public function register(Container $pimple)
    {
        if (!isset($pimple[ServiceProviders::HttpClientManager])) {
            $pimple[ServiceProviders::HttpClientManager] = function (ServiceContainer $app) {
                return new HttpClientManager(
                    $app[ServiceProviders::Config]->get('request.httpClientDriver') ?? SwooleClientDriver::class
                );
            };
        }
    }
}