<?php

namespace EasySwoole\WeChat\MiniProgram\ActivityMessage;


use EasySwoole\WeChat\MiniProgram\Application;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

/**
 * Class ServiceProvider
 * @package EasySwoole\WeChat\MiniProgram\ActivityMessage
 */
class ServiceProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        $app[Application::ActivityMessage] = function ($app) {
            return new Client($app);
        };
    }
}