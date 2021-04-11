<?php

namespace EasySwoole\WeChat\Work\Schedule;

use EasySwoole\WeChat\Work\Application;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

/**
 * Class ServiceProvider
 * @package EasySwoole\WeChat\Work\Schedule
 * @author: XueSi
 * @email: <1592328848@qq.com>
 */
class ServiceProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        $app[Application::Schedule] = function ($app) {
            return new Client($app);
        };
    }
}