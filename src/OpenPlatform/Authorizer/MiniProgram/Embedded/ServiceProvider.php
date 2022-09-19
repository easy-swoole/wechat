<?php
declare(strict_types=1);

/**
 ***********作者信息**********
 * Author: ysongyang
 * Email: 49271743@qq.com
 * Desc: 半屏小程序管理
 * Date: 2022/9/19 13:11
 *****************************
 */

namespace EasySwoole\WeChat\OpenPlatform\Authorizer\MiniProgram\Embedded;

use EasySwoole\WeChat\OpenPlatform\Authorizer\MiniProgram\Application;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class ServiceProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        $app[Application::Embedded] = function ($app) {
            return new Client($app);
        };
    }
}