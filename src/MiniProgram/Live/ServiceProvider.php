<?php

namespace EasySwoole\WeChat\MiniProgram\Live;

use EasySwoole\WeChat\MiniProgram\Application;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

/**
 * Class ServiceProvider
 *
 * @author master@kyour.cn
 * @package EasySwoole\WeChat\MiniProgram\Live
 */
class ServiceProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        $app[Application::Live] = function ($app) {
            return new Client($app);
        };
    }
}
