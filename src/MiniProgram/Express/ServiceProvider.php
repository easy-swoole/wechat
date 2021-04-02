<?php

namespace EasyWeChat\MiniProgram\Express;

use EasySwoole\WeChat\MiniProgram\Application;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

/**
 * Class ServiceProvider.
 * @authar master@kyour.cn
 * @package EasySwoole\WeChat\MiniProgram\Express
 */
class ServiceProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        $app[Application::Express] = function ($app) {
            return new Client($app);
        };
    }
}
