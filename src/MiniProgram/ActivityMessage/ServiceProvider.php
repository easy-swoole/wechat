<?php

namespace EasySwoole\WeChat\MiniProgram\ActivityMessage;


use EasySwoole\WeChat\MiniProgram\Application;
use EasySwoole\WeChat\MiniProgram\BaseClient;
use Pimple\Container;

/**
 * Class ServiceProvider
 * @package EasySwoole\WeChat\MiniProgram\ActivityMessage
 */
class ServiceProvider extends BaseClient
{
    public function register(Container $app)
    {
        $app[Application::ActivityMessage] = function ($app) {
            return new Client($app);
        };
    }
}