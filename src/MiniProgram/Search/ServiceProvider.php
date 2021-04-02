<?php

namespace EasySwoole\WeChat\MiniProgram\Search;

use EasySwoole\WeChat\MiniProgram\Application;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

/**
 * Class ServiceProvider
 *
 * @author master@kyour.cn
 * @package EasySwoole\WeChat\MiniProgram\Search
 */
class ServiceProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        $app[Application::Search] = function ($app) {
            return new Client($app);
        };
    }
}
