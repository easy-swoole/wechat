<?php
/**
 * Created by PhpStorm.
 * User: yf
 * Date: 2018/12/24
 * Time: 11:48 PM
 */

namespace EasySwoole\WeChat\OfficialAccount;

use EasySwoole\Component\Event;
use EasySwoole\WeChat\Bean\OfficialAccount\AccessCheck;
use EasySwoole\WeChat\Bean\OfficialAccount\Request;
use EasySwoole\WeChat\Utility\SysConst;


class Server extends ServiceBase
{
    private $onMessage;
    private $preOnMessage;
    private $onEvent;
    private $preOnEvent;
    private $onException;
    private $onDefault;

    function __construct(OfficialAccount $officialAccount)
    {
        parent::__construct($officialAccount);
        $this->onEvent = new Event();
        $this->onMessage = new Event();
    }

    /*
     * 解析raw数据
     */
    public function parserRequest(string $raw,\swoole_server $server = null)
    {
        libxml_disable_entity_loader(true);
        $array = (array)simplexml_load_string($raw, 'SimpleXMLElement', LIBXML_NOCDATA);
        $request = new Request($array);
        $callBack = null;
        $response = null;
        /*
         * 默认实现text 和event类型推送的回调，其余的走onDefault
         */
        if($request->getEvent() == SysConst::OFFICIAL_ACCOUNT_MSG_TYPE_TEXT){
            $callBack = $this->onMessage->get($request->getContent());
            if(!is_callable($callBack)){
                $callBack = $this->onMessage->get(SysConst::OFFICIAL_ACCOUNT_DEFAULT_ON_MESSAGE);
            }
        }else if($request->getEvent() == SysConst::OFFICIAL_ACCOUNT_MSG_TYPE_EVENT){
            $callBack = $this->onMessage->get($request->getEvent());
            if(!is_callable($callBack)){
                $callBack = $this->onMessage->get(SysConst::OFFICIAL_ACCOUNT_DEFAULT_ON_EVENT);
            }
        }
        if(!is_callable($callBack)){
            $callBack = $this->onDefault;
        }
        if(is_callable($callBack)){
            try{
                $response = call_user_func($callBack,$request,$server,$this->getOfficialAccount());
            }catch (\Throwable $throwable){
                if(is_callable($this->onException)){
                    $response = call_user_func($this->onException,$request,$throwable,$server,$this->getOfficialAccount());
                }else{
                    throw $throwable;
                }
            }
        }
    }

    /*
     * GET请求时候接入检查
     */
    public function accessCheck(AccessCheck $accessCheck):bool
    {
        $accessCheck->setToken($this->getOfficialAccount()->getConfig()->getToken());
        $array = $accessCheck->toArray();
        unset($array['signature']);
        unset($array['echostr']);
        $array = array_values($array);
        sort($array, SORT_STRING);
        $tmpStr = implode($array);
        return sha1($tmpStr) == $accessCheck->getSignature();
    }


    /*
     * 注册消息回调
     */
    function onMessage(callable $preOnMessage = null):Event
    {
        if($preOnMessage){
            $this->preOnMessage = $preOnMessage;
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
        return $this->onEvent;
    }

    function onException(callable $onException):Server
    {
        $this->onException = $onException;
        return $this;
    }
}