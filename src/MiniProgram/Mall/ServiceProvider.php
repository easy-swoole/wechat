<?php

namespace EasySwoole\WeChat\MiniProgram\Mall;


use EasySwoole\WeChat\MiniProgram\Application;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class ServiceProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        $app[Application::Mall] = function ($app) {
            return new Mall($app);
        };

        $app[Mall::MallOrder] = function ($app) {
            return new OrderClient($app);
        };

        $app[Mall::MallCart] = function ($app) {
            return new CartClient($app);
        };

        $app[Mall::MallProduct] = function ($app) {
            return new ProductClient($app);
        };

        $app[Mall::MallMedia] = function ($app) {
            return new MediaClient($app);
        };
    }

}