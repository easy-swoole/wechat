<?php

namespace EasySwoole\WeChat\MiniProgram\RiskControl;

use EasySwoole\WeChat\MiniProgram\Application;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

/**
 * 安全风控
 * Class ServiceProvider
 * @package EasySwoole\WeChat\MiniProgram\RiskControl
 * @author: XueSi
 * @email: <1592328848@qq.com>
 */
class ServiceProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        $app[Application::RiskControl] = function ($app) {
            return new Client($app);
        };
    }
}