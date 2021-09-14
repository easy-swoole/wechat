<?php
/**
 * User: XueSi
 * Date: 2021/9/14 16:44
 * Author: XueSi <1592328848@qq.com>
 */

namespace EasySwoole\WeChat\OpenPlatform\Authorizer\MiniProgram\BetaMiniProgram;

use EasySwoole\WeChat\OpenPlatform\Authorizer\MiniProgram\Application;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class ServiceProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        $app[Application::BetaMiniProgram] = function ($app) {
            return new Client($app);
        };
    }
}
