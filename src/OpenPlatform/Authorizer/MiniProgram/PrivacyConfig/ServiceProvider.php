<?php
/**
 * Created by PhpStorm.
 * User: XueSi <1592328848@qq.com>
 * Date: 2022/5/16
 * Time: 11:56 下午
 */
declare(strict_types=1);

namespace EasySwoole\WeChat\OpenPlatform\Authorizer\MiniProgram\PrivacyConfig;

use EasySwoole\WeChat\OpenPlatform\Authorizer\MiniProgram\Application;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class ServiceProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        $app[Application::PrivacyConfig] = function ($app) {
            return new Client($app);
        };
    }
}