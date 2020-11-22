<?php


namespace EasySwoole\WeChat\OfficialAccount\ShakeAround;


use EasySwoole\WeChat\Kernel\ServiceContainer;
use EasySwoole\WeChat\OfficialAccount\Application;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class ServiceProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        $app[Application::ShakeAround] = function (ServiceContainer $app) {
            return new ShakeAround($app);
        };

        $app[ShakeAround::Device] = function (ServiceContainer $app) {
            return new DeviceClient($app);
        };

        $app[ShakeAround::Group] = function (ServiceContainer $app) {
            return new GroupClient($app);
        };

        $app[ShakeAround::Material] = function (ServiceContainer $app) {
            return new MaterialClient($app);
        };

        $app[ShakeAround::Page] = function (ServiceContainer $app) {
            return new PageClient($app);
        };

        $app[ShakeAround::Relation] = function (ServiceContainer $app) {
            return new RelationClient($app);
        };

        $app[ShakeAround::Stats] = function (ServiceContainer $app) {
            return new StatsClient($app);
        };

    }
}