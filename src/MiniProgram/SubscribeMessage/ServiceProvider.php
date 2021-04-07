<?php
/**
 * Created by PhpStorm.
 * User: XueSi
 * Email: <1592328848@qq.com>
 * Date: 2021/4/7
 * Time: 21:56
 */

namespace EasySwoole\WeChat\MiniProgram\SubscribeMessage;

use EasySwoole\WeChat\MiniProgram\Application;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class ServiceProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        $app[Application::SubscribeMessage] = function ($app) {
            return new Client($app);
        };
    }
}