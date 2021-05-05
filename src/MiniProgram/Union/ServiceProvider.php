<?php

namespace EasySwoole\WeChat\MiniProgram\Union;

use EasySwoole\WeChat\MiniProgram\Application;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

/**
 * Class ServiceProvider
 * @package EasySwoole\WeChat\MiniProgram\Union
 * @author: XueSi
 * @email: <1592328848@qq.com>
 */
class ServiceProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        $app[Application::Union] = function ($app) {
            return new Client($app);
        };
    }
}