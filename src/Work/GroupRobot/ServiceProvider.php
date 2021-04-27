<?php

namespace EasySwoole\WeChat\Work\GroupRobot;


use EasySwoole\WeChat\Work\Application;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class ServiceProvider implements ServiceProviderInterface
{
    /**
     * @param Container $app
     */
    public function register(Container $app)
    {
        $app[Application::GroupRobot] = function ($app) {
            return new Client($app);
        };

        $app[Application::GroupRobotMessenger] = function ($app) {
            return new Messenger($app[Application::GroupRobot]);
        };
    }
}
