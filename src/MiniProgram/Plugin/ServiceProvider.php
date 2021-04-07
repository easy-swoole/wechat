<?php

namespace EasySwoole\WeChat\MiniProgram\Plugin;

use EasySwoole\WeChat\MiniProgram\Application;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

/**
 * Class ServiceProvider.
 *
 * @author master@kyour.cn
 * @package EasySwoole\WeChat\MiniProgram\Plugin
 */
class ServiceProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        $app[Application::Plugin] = function ($app) {
            return new Client($app);
        };
        $app[Application::PluginDev] = function ($app) {
            return new DevClient($app);
        };
    }
}
