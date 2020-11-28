<?php
/**
 * Created by PhpStorm.
 * User: 67066
 * Date: 2020/11/25
 * Time: 11:21
 */

namespace EasySwoole\WeChat\OfficialAccount\Menu;


use EasySwoole\WeChat\OfficialAccount\Application;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class ServiceProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        $app[Application::Menu] = function ($app) {
            return new Client($app);
        };
    }
}