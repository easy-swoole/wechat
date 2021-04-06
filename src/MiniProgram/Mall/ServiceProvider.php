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
            return new ForwardsMall($app);
        };

        $app[Application::MallOrder] = function ($app) {
            return new OrderClient($app);
        };

        $app[Application::MallCart] = function ($app) {
            return new CartClient($app);
        };

        $app[Application::MallProduct] = function ($app) {
            return new ProductClient($app);
        };

        $app[Application::MallMedia] = function ($app) {
            return new MediaClient($app);
        };
    }

}