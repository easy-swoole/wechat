<?php
declare(strict_types=1);

/**
 ***********作者信息**********
 * Author: ysongyang
 * Email: 49271743@qq.com
 * Desc: 违规和申诉管理
 * Date: 2022/9/19 13:24
 *****************************
 */

namespace EasySwoole\WeChat\OpenPlatform\Authorizer\MiniProgram\Record;

use EasySwoole\WeChat\OpenPlatform\Authorizer\MiniProgram\Application;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class ServiceProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        $app[Application::Record] = function ($app) {
            return new Client($app);
        };
    }
}