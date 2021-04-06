<?php

namespace EasySwoole\WeChat\MiniProgram\DataCube;

use EasySwoole\WeChat\MiniProgram\Application;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

/**
 * Class ServiceProvider
 * @author master@kyour.cn
 * @package EasySwoole\WeChat\MiniProgram\DataCube
 */
class ServiceProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        $app[Application::DataCube] = function ($app) {
            return new Client($app);
        };
    }
}
