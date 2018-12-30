<?php
/**
 * Created by PhpStorm.
 * User: yf
 * Date: 2018/12/24
 * Time: 11:48 PM
 */

namespace EasySwoole\WeChat\OfficialAccount;

use EasySwoole\Component\Event;
use EasySwoole\Spl\SplArray;
use EasySwoole\WeChat\Bean\OfficialAccount\AccessCheck;
use EasySwoole\WeChat\Bean\OfficialAccount\RequestConst;
use EasySwoole\WeChat\Bean\OfficialAccount\RequestMsg;
use EasySwoole\WeChat\Bean\OfficialAccount\RequestedReplyMsg;


class Server extends OfficialAccountBase
{
    private $onMessage;
    private $preCall;
    private $onEvent;
    private $onException;
    private $onDefault;

    function __construct(OfficialAccount $officialAccount)
    {
        parent::__construct($officialAccount);
        $this->onEvent = new EventContainer();
        $this->onMessage = new Event();
    }

    /*
     * 解析raw数据
     */
    public function parserRequest(string $raw):?string
    {
        libxml_disable_entity_loader(true);
        $array = (array)simplexml_load_string($raw, 'SimpleXMLElement', LIBXML_NOCDATA);
        $request = new RequestMsg($array);
        $response = null;
        if(is_callable($this->preCall)){
            //返回false 表示拦截,return 数据表示直接相应，不返回表示预处理并继续往下
            try{
                $response = call_user_func($this->preCall,$request,$this->getOfficialAccount());
            }catch (\Throwable $throwable){
                if(is_callable($this->onException)){
                    $response = call_user_func($this->onException,$request,$throwable,$this->getOfficialAccount());
                }else{
                    throw $throwable;
                }
            }
            if($response === false){
                return null;
            }else if($response !== null){
                goto responsePack;
            }
        }

        $callBack = null;
        /*
         * 默认实现text 和event类型推送的回调，其余的走onDefault
         */
        if($request->getMsgType() == RequestConst::MSG_TYPE_TEXT){
            $callBack = $this->onMessage->get($request->getContent());
            if(!is_callable($callBack)){
                $callBack = $this->onMessage->get(RequestConst::DEFAULT_ON_MESSAGE);
            }
        }else if($request->getMsgType() == RequestConst::MSG_TYPE_EVENT){
            $callBack = $this->onEvent->get($request->getEvent());
            if(!is_callable($callBack)){
                $callBack = $this->onMessage->get(RequestConst::DEFAULT_ON_EVENT);
            }
        }
        if(!is_callable($callBack)){
            $callBack = $this->onDefault;
        }
        if(is_callable($callBack)){
            try{
                $response = call_user_func($callBack,$request,$this->getOfficialAccount());
            }catch (\Throwable $throwable){
                if(is_callable($this->onException)){
                    $response = call_user_func($this->onException,$request,$throwable,$this->getOfficialAccount());
                }else{
                    throw $throwable;
                }
            }
        }
        responsePack:{
            if($response == null){
                $response = 'success';
            }else if($response instanceof RequestedReplyMsg){
                $response->setFromUserName($request->getToUserName());
                $response->setToUserName($request->getFromUserName());
                $data = $response->toArray(null,$response::FILTER_NOT_NULL);
                $response = (new SplArray($data))->toXML();
            }
        }
        return $response;
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
    function onMessage():Event
    {
        return $this->onMessage;
    }

    /*
     *注册事件回调
     */
    function onEvent():EventContainer
    {
        if(!isset($this->onEvent)){
            $this->onEvent = new EventContainer();
        }
        return $this->onEvent;
    }

    public function preCall(callable $call):Server
    {
        $this->preCall = $call;
        return $this;
    }

    function onException(callable $onException):Server
    {
        $this->onException = $onException;
        return $this;
    }

}