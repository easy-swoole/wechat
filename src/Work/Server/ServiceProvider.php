<?php

namespace EasySwoole\WeChat\Work\Server;

use EasySwoole\WeChat\Kernel\Encryptor;
use EasySwoole\WeChat\Kernel\Messages\Message;
use EasySwoole\WeChat\Kernel\ServiceContainer;
use EasySwoole\WeChat\Kernel\ServiceProviders;
use EasySwoole\WeChat\Work\Application;
use EasySwoole\WeChat\Work\Server\Handlers\EchoStrHandler;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

/**
 * Class ServiceProvider
 * @package EasySwoole\WeChat\Work\Server
 * @author: XueSi
 * @email: <1592328848@qq.com>
 */
class ServiceProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        if (!isset($app[ServiceProviders::Encryptor])) {
            $app[ServiceProviders::Encryptor] = function (ServiceContainer $app) {
                return new Encryptor();
            };
        }

        if (!isset($app[Application::Server])) {
            $app[Application::Server] = function (ServiceContainer $app) {
                $guard = new Guard($app);
                $guard->push(new EchoStrHandler(), Message::VALIDATE);
                return $guard;
            };
        }
    }
}
