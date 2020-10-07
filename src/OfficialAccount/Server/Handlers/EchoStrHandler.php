<?php


namespace EasySwoole\WeChat\OfficialAccount\Server\Handlers;


use EasySwoole\WeChat\Kernel\Contracts\EventHandlerInterface;
use EasySwoole\WeChat\Kernel\Messages\Raw;
use Psr\Http\Message\ServerRequestInterface;

class EchoStrHandler implements EventHandlerInterface
{

    public function handle($request = null)
    {
        if ($request instanceof ServerRequestInterface) {
            $str = $request->getQueryParams()['echostr'] ?? null;
            var_dump($str);
            if (!is_null($str)) {
                $message = new Raw();
                $message->setContent($str);
                return $message;
            }
        }

        return null;
    }
}