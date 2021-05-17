<?php

namespace EasySwoole\WeChat\OfficialAccount\AutoReplay;

use EasySwoole\WeChat\Kernel\ServiceContainer;
use EasySwoole\WeChat\OfficialAccount\Application;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class ServiceProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        if (!isset($app[Application::AutoReplay])) {
            $app[Application::AutoReplay] = function (ServiceContainer $app) {
                return new Client($app);
            };
        }
    }
}