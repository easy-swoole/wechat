<?php

namespace EasySwoole\WeChat\Work\Server\Handlers;

use EasySwoole\WeChat\Kernel\Contracts\EventHandlerInterface;
use EasySwoole\WeChat\Kernel\Messages\Raw;
use Psr\Http\Message\ServerRequestInterface;

/**
 * Class EchoStrHandler
 * @package EasySwoole\WeChat\Work\Server\Handlers
 * @author: XueSi
 * @email: <1592328848@qq.com>
 */
class EchoStrHandler implements EventHandlerInterface
{
    public function handle($request = null)
    {
        if ($request instanceof ServerRequestInterface) {
            $str = $request->getQueryParams()['echostr'] ?? null;
            if (!is_null($str)) {
                return new Raw($str);
            }
        }

        return null;
    }
}