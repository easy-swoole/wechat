<?php


namespace EasySwoole\WeChat\OfficialAccount\WiFi;


use EasySwoole\WeChat\Kernel\ServiceContainer;
use EasySwoole\WeChat\OfficialAccount\Application;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class ServiceProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        $app[Application::Wifi] = function (ServiceContainer $app) {
            return new Client($app);
        };

        $app[Application::WifiCard] = function (ServiceContainer $app) {
            return new CardClient($app);
        };

        $app[Application::WifiDevice] = function (ServiceContainer $app) {
            return new DeviceClient($app);
        };

        $app[Application::WifiShop] = function (ServiceContainer $app) {
            return new ShopClient($app);
        };
    }
}