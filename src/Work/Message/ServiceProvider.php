<?php

namespace EasySwoole\WeChat\Work\Message;

use EasySwoole\WeChat\Kernel\ServiceProviders;
use EasySwoole\WeChat\Work\Application;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

/**
 * Class ServiceProvider
 * @package EasySwoole\WeChat\Work\Message
 * @author: XueSi
 * @email: <1592328848@qq.com>
 */
class ServiceProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        $app[Application::Message] = function ($app) {
            return new Client($app);
        };

        $app[Application::Messenger] = function ($app) {
            $messenger = new Messenger($app[Application::Message]);

            if (is_int($app[ServiceProviders::Config]->get('agentId'))) {
                $messenger->ofAgent($app[ServiceProviders::Config]->get('agentId'));
            }

            return $messenger;
        };
    }
}
