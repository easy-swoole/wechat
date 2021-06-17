<?php

namespace EasySwoole\WeChat\MiniProgram\UrlLink;

use EasySwoole\WeChat\MiniProgram\Application;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

/**
 * Class ServiceProvider
 * @package EasySwoole\WeChat\MiniProgram\UrlLink
 */
class ServiceProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        $app[Application::UrlLink] = function ($app) {
            return new Client($app);
        };
    }
}
