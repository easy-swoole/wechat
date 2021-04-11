<?php

namespace EasySwoole\WeChat\Work\Calendar;

use EasySwoole\WeChat\Work\Application;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

/**
 * Class ServiceProvider
 * @package EasySwoole\WeChat\Work\Calendar
 * @date: 2021/4/10 21:47
 * @author: XueSi
 * @email: <1592328848@qq.com>
 */
class ServiceProvider implements ServiceProviderInterface
{
    /**
     * @param Container $app
     */
    public function register(Container $app)
    {
        $app[Application::Calendar] = function ($app) {
            return new Client($app);
        };
    }
}