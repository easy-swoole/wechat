<?php


namespace EasySwoole\WeChat\Work\Agent;


use EasySwoole\WeChat\Work\Application;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class ServiceProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        $app[Application::Agent] = function ($app) {
            return new Client($app);
        };

        $app[Application::AgentWorkbench] = function ($app) {
            return new WorkbenchClient($app);
        };
    }
}