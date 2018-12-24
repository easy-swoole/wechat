<?php
/**
 * Created by PhpStorm.
 * User: yf
 * Date: 2018/12/24
 * Time: 4:58 PM
 */

namespace EasySwoole\WeChat\OfficialAccount;


use EasySwoole\Component\Event;
use EasySwoole\WeChat\Bean\Response;

class OfficialAccount
{
    private $onMessage;
    private $preOnMessage;
    private $onEvent;
    private $preOnEvent;

    private $config;

    function __construct(OfficialAccountConfig $config)
    {
        $this->config = $config;
    }

    /*
     * 解析raw数据
     */
    public function parserRequest(string $raw)
    {

    }

    public function accessCheck($signature,$timestamp,$nonceStr)
    {

    }


    /*
     * 注册消息回调
     */
    function onMessage(callable $preOnMessage = null):Event
    {
        if($preOnMessage){
            $this->preOnMessage = $preOnMessage;
        }
        if(!isset($this->onMessage)){
            $this->onMessage = new Event();
        }
        return $this->onMessage;
    }

    /*
     *注册事件回调
     */
    function onEvent(callable $preOnEvent = null):Event
    {
        if($preOnEvent){
            $this->preOnEvent = $preOnEvent;
        }
        if(!isset($this->onEvent)){
            $this->onEvent = new Event();
        }
        return $this->onEvent;
    }
}