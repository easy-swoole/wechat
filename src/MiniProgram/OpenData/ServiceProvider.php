<?php

namespace EasySwoole\WeChat\MiniProgram\OpenData;

use EasySwoole\WeChat\MiniProgram\Application;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

/**
 * Class ServiceProvider
 * @author master@kyour.cn
 * @package EasySwoole\WeChat\MiniProgram\OpenData
 */
class ServiceProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        $app[Application::OpenData] = function ($app) {
            return new Client($app);
        };
    }
}
