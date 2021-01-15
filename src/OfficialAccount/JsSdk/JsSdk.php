<?php


namespace EasySwoole\WeChat\OfficialAccount\JsSdk;


use EasySwoole\WeChat\Kernel\Contracts\JsSdkTicketInterface;
use EasySwoole\WeChat\Kernel\ServiceContainer;
use EasySwoole\WeChat\Kernel\ServiceProviders;
use EasySwoole\WeChat\Kernel\Utility\Random;

class JsSdk
{
    /** @var ServiceContainer  */
    protected $app;

    protected $ticket;

    public function __construct(ServiceContainer $app)
    {
        $this->app = $app;
        $this->ticket = new Ticket($app);
    }

    public function ticket():JsSdkTicketInterface
    {
        return $this->ticket;
    }

    function signature(string $url)
    {
        //组装签名参数包
        $pack = [
            'noncestr' => Random::character(16),
            'jsapi_ticket' => $this->ticket()->getToken(),
            'timestamp' => time(),
            'url' => $url
        ];
        // 按键名升序
        ksort($pack);
        // 拼接待签名串
        $signatureStr = '';
        foreach ($pack as $name => $value) {
            $signatureStr .= "{$name}={$value}&";
        }
        // 去除最后多拼接的&
        $signatureStr = substr($signatureStr, 0, -1);
        $signature = sha1($signatureStr);
        return [
            'appId' => $this->app[ServiceProviders::Config]->get('appId'),
            'timestamp' => $pack['timestamp'],
            'nonceStr' => $pack['noncestr'],
            'signature' => $signature,
        ];
    }
}