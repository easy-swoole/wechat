<?php

namespace EasySwoole\WeChat\Work\Server\Handlers;

use EasySwoole\WeChat\Kernel\Contracts\EventHandlerInterface;
use EasySwoole\WeChat\Kernel\Encryptor;
use EasySwoole\WeChat\Kernel\Messages\Raw;
use EasySwoole\WeChat\Kernel\ServiceProviders;
use Pimple\Container;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Class EchoStrHandler
 * @package EasySwoole\WeChat\Work\Server\Handlers
 * @author: XueSi
 * @email: <1592328848@qq.com>
 */
class EchoStrHandler implements EventHandlerInterface
{
    /**
     * @var Container
     */
    protected $app;

    /**
     * EchoStrHandler constructor.
     * @param Container $app
     */
    public function __construct(Container $app)
    {
        $this->app = $app;
    }

    public function handle($request = null)
    {
        if ($request instanceof ServerRequestInterface) {
            $echoStr = $request->getQueryParams()['echostr'] ?? null;
            /** @var Encryptor $encryptor */
            $encryptor = $this->app[ServiceProviders::Encryptor];
            $str = $encryptor->decrypt(
                $echoStr,
                $this->app[ServiceProviders::Config]->get('aesKey'),
                $this->app[ServiceProviders::Config]->get('corpId')
            );
            if (!is_null($str)) {
                return new Raw($str);
            }
        }

        return null;
    }
}
