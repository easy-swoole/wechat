<?php


namespace EasySwoole\WeChat\OpenPlatform\Authorizer\MiniProgram\Account;

use EasySwoole\WeChat\OpenPlatform\Application;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class ServiceProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        $app[Application::Account] = function ($app) {
            return new Client($app);
        };
    }
}
