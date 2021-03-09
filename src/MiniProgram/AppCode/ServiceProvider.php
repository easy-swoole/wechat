<?php

namespace EasySwoole\WeChat\MiniProgram\AppCode;

use EasySwoole\WeChat\MiniProgram\Application;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

/**
 * Class ServiceProvider
 * @package EasySwoole\WeChat\MiniProgram\AppCode
 */
class ServiceProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        $app[Application::AppCode] = function ($app) {
            return new Client($app);
        };
    }
}
