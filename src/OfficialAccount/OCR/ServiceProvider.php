<?php


namespace EasySwoole\WeChat\OfficialAccount\OCR;


use EasySwoole\WeChat\Kernel\ServiceContainer;
use EasySwoole\WeChat\OfficialAccount\Application;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class ServiceProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        $app[Application::Ocr] = function (ServiceContainer $app) {
            return new Client($app);
        };
    }
}