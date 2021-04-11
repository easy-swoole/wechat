<?php

namespace EasySwoole\WeChat\Work\Chat;

use EasySwoole\WeChat\Work\Application;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

/**
 * Class ServiceProvider
 * @package EasySwoole\WeChat\Work\Chat
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
        $app[Application::Chat] = function ($app) {
            return new Client($app);
        };
    }
}