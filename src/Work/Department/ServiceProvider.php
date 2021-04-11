<?php

namespace EasySwoole\WeChat\Work\Department;

use EasySwoole\WeChat\Work\Application;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

/**
 * Class ServiceProvider
 * @package EasySwoole\WeChat\Work\Department
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
        $app[Application::Department] = function ($app) {
            return new Client($app);
        };
    }
}