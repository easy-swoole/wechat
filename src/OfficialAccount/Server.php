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
use EasySwoole\WeChat\Bean\OfficialAccount\Message\RequestedReplyMsg;
use EasySwoole\WeChat\Bean\OfficialAccount\RequestConst;
use EasySwoole\WeChat\Bean\OfficialAccount\RequestMsg;


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

    /**
     * 解析raw数据
     *
     * @param string $raw
     * @return string|null
     * @throws \EasySwoole\WeChat\Exception\EncryptorError
     * @throws \Throwable
     */
    public function parserRequest(string $raw): ?string
    {
        $appId = $this->getOfficialAccount()->getConfig()->getAppId();

        // 解析xml
        libxml_disable_entity_loader(true);
        $array = (array)simplexml_load_string($raw, 'SimpleXMLElement', LIBXML_NOCDATA);

        // 需要解密
        $isEncrypt = !empty($array['Encrypt']);
        if ($isEncrypt) {
            $callBack = $this->onEvent->get(EventContainer::EVENT_ENCRYPTOR_DECRYPT);
            if (is_callable($callBack)) {
                $decryptRaw = call_user_func($callBack, $array['Encrypt']);
            } else {
                $decryptRaw = Encryptor::decrypt($appId, $array['Encrypt'], $this->getOfficialAccount()->getConfig()->getAesKey());
            }
            $array = (array)simplexml_load_string($decryptRaw, 'SimpleXMLElement', LIBXML_NOCDATA);
        }

        $request = new RequestMsg($array);
        $response = null;
        if (is_callable($this->preCall)) {
            //返回false 表示拦截,return 数据表示直接相应，不返回表示预处理并继续往下
            try {
                $response = call_user_func($this->preCall, $request, $this->getOfficialAccount());
            } catch (\Throwable $throwable) {
                if (is_callable($this->onException)) {
                    $response = call_user_func($this->onException, $request, $throwable, $this->getOfficialAccount());
                } else {
                    throw $throwable;
                }
            }
            if ($response === false) {
                return null;
            } else if ($response !== null) {
                goto responsePack;
            }
        }

        $callBack = null;
        /*
         * 默认实现text 和event类型推送的回调，其余的走onDefault
         */
        if ($request->getMsgType() == RequestConst::MSG_TYPE_EVENT) {
            $callBack = $this->onEvent->get($request->getEvent());
            if (!is_callable($callBack)) {
                $callBack = $this->onMessage->get(RequestConst::DEFAULT_ON_EVENT);
            }
        } else {
            $callBack = $this->onMessage->get($request->getMsgType());
            if (!is_callable($callBack) && $request->getMsgType() == RequestConst::MSG_TYPE_TEXT) {
                $callBack = $this->onMessage->get(RequestConst::DEFAULT_ON_MESSAGE);
            }
        }

        if (!is_callable($callBack)) {
            $callBack = $this->onDefault;
        }
        if (is_callable($callBack)) {
            try {
                $response = call_user_func($callBack, $request, $this->getOfficialAccount());
            } catch (\Throwable $throwable) {
                if (is_callable($this->onException)) {
                    $response = call_user_func($this->onException, $request, $throwable, $this->getOfficialAccount());
                } else {
                    throw $throwable;
                }
            }
        }
        responsePack:{
        if ($response == null) {
            $response = 'success';
        } else if ($response instanceof RequestedReplyMsg) {
            $response->setFromUserName($request->getToUserName());
            $response->setToUserName($request->getFromUserName());
            $data = $response->buildMessage();
            $response = $data->toXML();
        }

        // 需要加密
        if ($isEncrypt) {
            $callBack = $this->onEvent->get(EventContainer::EVENT_ENCRYPTOR_ENCRYPT);
            if (is_callable($callBack)) {
                $encrypt = call_user_func($callBack, $response);
            } else {
                $encrypt = Encryptor::encrypt($appId, $response, $this->getOfficialAccount()->getConfig()->getAesKey());
            }
            $tmpArr = [];
            $tmpArr['Encrypt'] = $encrypt;
            $tmpArr['TimeStamp'] = time();
            $tmpArr['Nonce'] = Encryptor::character(9, '0123456789');
            $tmpArr['Token'] = $this->getOfficialAccount()->getConfig()->getToken();
            $tmpArr['MsgSignature'] = $this->signature($tmpArr);
            unset($tmpArr['Token']);
            $response = (new SplArray($tmpArr))->toXML();
        }
    }
        return $response;
    }

    /*
     * GET请求时候接入检查
     */
    public function accessCheck(AccessCheck $accessCheck): bool
    {
        $accessCheck->setToken($this->getOfficialAccount()->getConfig()->getToken());
        $array = $accessCheck->toArray();
        unset($array['signature']);
        unset($array['echostr']);

        return $this->signature($array) == $accessCheck->getSignature();
    }

    /*
     * 注册消息回调
     */
    public function onMessage(): Event
    {
        return $this->onMessage;
    }

    /*
     *注册事件回调
     */
    public function onEvent(): EventContainer
    {
        if (!isset($this->onEvent)) {
            $this->onEvent = new EventContainer();
        }
        return $this->onEvent;
    }

    public function preCall(callable $call): Server
    {
        $this->preCall = $call;
        return $this;
    }

    public function onException(callable $onException): Server
    {
        $this->onException = $onException;
        return $this;
    }

    private function signature(array $payload)
    {
        $payload = array_values($payload);
        sort($payload, SORT_STRING);
        $tmpStr = implode($payload);
        return sha1($tmpStr);
    }
}