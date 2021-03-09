<?php


namespace EasySwoole\WeChat\BasicService\QrCode;


use EasySwoole\WeChat\BasicService\Application;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

/**
 * Class ServiceProvider
 * @package EasySwoole\WeChat\BasicService\QrCode
 */
class ServiceProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        $app[Application::QrCode] = function ($app) {
            return new Client($app);
        };
    }
}
