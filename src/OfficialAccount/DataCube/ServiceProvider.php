<?php
/**
 * Created by PhpStorm.
 * User: 67066
 * Date: 2020/11/29
 * Time: 18:01
 */

namespace EasySwoole\WeChat\OfficialAccount\DataCube;

use EasySwoole\WeChat\OfficialAccount\Application;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class ServiceProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        $app[Application::DataCube] = function ($app) {
            return new Client($app);
        };
        $app[Application::DataCubePublisher] = function($app){
            return new PublisherClient($app);
        };
    }
}