<?php


namespace EasySwoole\WeChat\Kernel\Providers;


use EasySwoole\WeChat\Kernel\HttpClient\RequestManage;
use EasySwoole\WeChat\Kernel\HttpClient\SwooleClientDriver;
use EasySwoole\WeChat\Kernel\ServiceContainer;
use EasySwoole\WeChat\Kernel\ServiceProviders;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class HttpClientServiceProvider implements ServiceProviderInterface
{
    public function register(Container $pimple)
    {
        if (!isset($pimple[ServiceProviders::HttpClient])) {
            $pimple[ServiceProviders::HttpClient] = function (ServiceContainer $app) {
                return new RequestManage(
                    $app[ServiceProviders::Config]->get('request.httpClientDriver') ?? SwooleClientDriver::class
                );
            };
        }
    }
}