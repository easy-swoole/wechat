<?php

namespace EasySwoole\WeChat\MiniProgram\UrlScheme;

use EasySwoole\WeChat\MiniProgram\Application;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

/**
 * Class ServiceProvider
 * @package EasySwoole\WeChat\MiniProgram\UrlScheme
 */
class ServiceProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        $app[Application::UrlScheme] = function ($app) {
            return new Client($app);
        };
    }
}
