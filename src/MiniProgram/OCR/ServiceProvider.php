<?php

namespace EasySwoole\WeChat\MiniProgram\OCR;

use EasySwoole\WeChat\MiniProgram\Application;
use EasySwoole\WeChat\OfficialAccount\OCR\Client;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

/**
 * Class ServiceProvider
 *
 * @author master@kyour.cn
 * @package EasySwoole\WeChat\MiniProgram\OCR
 */
class ServiceProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        $app[Application::OCR] = function ($app) {
            return new Client($app);
        };
    }
}
