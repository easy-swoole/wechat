<?php


namespace EasySwoole\WeChat\OfficialAccount\Server;


use EasySwoole\WeChat\Kernel\Config;
use EasySwoole\WeChat\Kernel\Encryptor;
use EasySwoole\WeChat\Kernel\Messages\Message;
use EasySwoole\WeChat\Kernel\ServiceContainer;
use EasySwoole\WeChat\Kernel\ServiceProviders;
use EasySwoole\WeChat\OfficialAccount\Server\Handlers\EchoStrHandler;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class ServiceProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        if (!isset($app[ServiceProviders::Encryptor])) {
            $app[ServiceProviders::Encryptor] = function (ServiceContainer $app) {
                /** @var Config $config */
                $config = $app[ServiceProviders::Config];
                return new Encryptor(
                    $config->get("appId"),
                    $config->get("token"),
                    $config->get("aesKey")
                );
            };
        }

        if (!isset($app[ServiceProviders::Server])) {
            $app[ServiceProviders::Server] = function (ServiceContainer $app) {
                $guard = new Guard($app);
                $guard->push(new EchoStrHandler(), Message::VALIDATE);
                return $guard;
            };
        }
    }
}