<?php

namespace EasySwoole\WeChat\Work\Mobile;

use EasySwoole\WeChat\Work\Application;
use EasySwoole\WeChat\Work\Mobile\Auth\Client;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

/**
 * Class ServiceProvider
 * @package EasySwoole\WeChat\Work\Mobile
 * @author: XueSi
 * @email: <1592328848@qq.com>
 */
class ServiceProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        $app[Application::Mobile] = function ($app) {
            return new Client($app);
        };
    }
}