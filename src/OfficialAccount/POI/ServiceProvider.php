<?php

namespace EasySwoole\WeChat\OfficialAccount\POI;

use EasySwoole\WeChat\Kernel\ServiceContainer;
use EasySwoole\WeChat\OfficialAccount\Application;
use Pimple\Container;
use Pimple\ServiceProviderInterface;


class ServiceProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        $app[Application::Poi] = function (ServiceContainer $app) {
            return new Client($app);
        };
    }
}
