<?php
/**
 * Created by PhpStorm.
 * User: yf
 * Date: 2018-12-29
 * Time: 21:11
 */

namespace EasySwoole\WeChat\OfficialAccount;


use EasySwoole\Component\Event;
use EasySwoole\WeChat\Bean\OfficialAccount\RequestConst;

class EventContainer extends Event
{
    const EVENT_ENCRYPTOR_DECRYPT = 'event_encryptor_decrypt';
    const EVENT_ENCRYPTOR_ENCRYPT = 'event_encryptor_encrypt';

    function onSubscribe(callable $call): EventContainer
    {
        $this->set(RequestConst::EVENT_SUBSCRIBE, $call);
        return $this;
    }

    function onUnSubscribe(callable $call): EventContainer
    {
        $this->set(RequestConst::EVENT_UNSUBSCRIBE, $call);
        return $this;
    }

    function onScan(callable $call): EventContainer
    {
        $this->set(RequestConst::EVENT_SCAN, $call);
        return $this;
    }

    function onLocation(callable $call): EventContainer
    {
        $this->set(RequestConst::EVENT_LOCATION, $call);
        return $this;
    }

    function onClick(callable $call): EventContainer
    {
        $this->set(RequestConst::EVENT_CLICK, $call);
        return $this;
    }

    function onView(callable $call): EventContainer
    {
        $this->set(RequestConst::EVENT_VIEW, $call);
        return $this;
    }

    function onEncryptorDecrypt(callable $call): EventContainer
    {
        $this->set(self::EVENT_ENCRYPTOR_DECRYPT, $call);
        return $this;
    }

    function onEncryptorEncrypt(callable $call): EventContainer
    {
        $this->set(self::EVENT_ENCRYPTOR_ENCRYPT, $call);
        return $this;
    }

    function onMassSendJobFinish(callable  $call): EventContainer
    {
        $this->set(RequestConst::EVENT_MASS_SEND_JOB_FINISH, $call);
        return $this;
    }

    function onTemplateSendJobFinish(callable  $call): EventContainer
    {
        $this->set(RequestConst::EVENT_TEMPLATE_SEND_JOB_FINISH, $call);
        return $this;
    }
}