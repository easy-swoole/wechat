<?php
/**
 * Created by PhpStorm.
 * User: yf
 * Date: 2018-12-30
 * Time: 14:58
 */

namespace EasySwoole\WeChat\OfficialAccount\JsSdk;

use EasySwoole\WeChat\AbstractInterface\JsTicketInterface;
use EasySwoole\WeChat\Bean\OfficialAccount\JsApiSignaturePack;
use EasySwoole\WeChat\Exception\OfficialAccountError;

class JsSdk extends JsApiBase
{
    private $ticket;

    function jsTicket():JsTicketInterface
    {
        if(!isset($this->ticket)){
            $this->ticket = new JsTicket($this->getOfficialAccount());
        }
        return $this->ticket;
    }

    /**
     * 自定义Ticket实现
     *
     * @param JsTicketInterface $jsTicket
     *
     * @return JsSdk
     */
    public function setTicketnManager(JsTicketInterface $jsTicket):JsSdk
    {
        $this->ticket = $jsTicket;
        return $this;
    }

    /**
     * 获取前端注册wx.config使用的签名包
     * @param string $url
     * @return JsApiSignaturePack
     * @throws OfficialAccountError
     * @throws \EasySwoole\WeChat\Exception\RequestError
     */
    function signature(string $url)
    {
        $officialAccountConfig = $this->getOfficialAccount()->getConfig();
        // 组装签名参数包
        $pack = [
            'noncestr' => $this->generateNonce(16),
            'jsapi_ticket' => $this->jsTicket()->getTicket(),
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
        // 返回签名包
        return new JsApiSignaturePack([
            'appId' => $officialAccountConfig->getAppId(),
            'timestamp' => $pack['timestamp'],
            'nonceStr' => $pack['noncestr'],
            'signature' => $signature,
        ]);
    }

    /**
     * generateNonce
     * @param int $length
     * @param string $alphabet
     * @return bool|string
     */
    private function generateNonce($length = 6, $alphabet = 'AaBbCcDdEeFfGgHhIiJjKkLlMmNnOoPpQqRrSsTtUuVvWwXxYyZz0123456789')
    {
        mt_srand();
        // 重复字母表以防止生成长度溢出字母表长度
        if ($length >= strlen($alphabet)) {
            $rate = intval($length / strlen($alphabet)) + 1;
            $alphabet = str_repeat($alphabet, $rate);
        }
        // 打乱顺序返回
        return substr(str_shuffle($alphabet), 0, $length);
    }
}