<?php

namespace EasySwoole\WeChat\MiniProgram\CustomerService;


use EasySwoole\WeChat\MiniProgram\Application;
use EasySwoole\WeChat\OfficialAccount\CustomerService\Client;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

/**
 * Class ServiceProvider
 * @package EasySwoole\WeChat\MiniProgram\CustomerService
 */
class ServiceProvider implements ServiceProviderInterface
{
    public function register(Container $pimple)
    {
        $app[Application::CustomerService] = function ($app) {
            return new Client($app);
        };
    }

}