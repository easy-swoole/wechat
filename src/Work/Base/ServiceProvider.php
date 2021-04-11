<?php

namespace EasySwoole\WeChat\Work\Base;

use EasySwoole\WeChat\Work\Application;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

/**
 * Class ServiceProvider
 * @package EasySwoole\WeChat\Work\Base
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
        $app[Application::Base] = function ($app) {
            return new Client($app);
        };
    }
}