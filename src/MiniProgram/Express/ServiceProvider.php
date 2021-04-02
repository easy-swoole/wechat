<?php

namespace EasySwoole\WeChat\MiniProgram\Express;

use EasySwoole\WeChat\MiniProgram\Application;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

/**
 * Class ServiceProvider.
 * @author master@kyour.cn
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
