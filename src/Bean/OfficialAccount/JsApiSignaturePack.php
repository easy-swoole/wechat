<?php
/**
 * Created by PhpStorm.
 * User: evalor
 * Date: 2018-12-30
 * Time: 16:34
 */

namespace EasySwoole\WeChat\Bean\OfficialAccount;

use EasySwoole\Spl\SplBean;

/**
 * JsApi签名包
 * Class JsApiSignaturePack
 * @package EasySwoole\WeChat\Bean\OfficialAccount
 */
class JsApiSignaturePack extends SplBean
{
    protected $appId;
    protected $timestamp;
    protected $nonceStr;
    protected $signature;

    /**
     * @return mixed
     */
    public function getAppId()
    {
        return $this->appId;
    }

    /**
     * @param mixed $appId
     */
    public function setAppId($appId): void
    {
        $this->appId = $appId;
    }

    /**
     * @return mixed
     */
    public function getTimestamp()
    {
        return $this->timestamp;
    }

    /**
     * @param mixed $timestamp
     */
    public function setTimestamp($timestamp): void
    {
        $this->timestamp = $timestamp;
    }

    /**
     * @return mixed
     */
    public function getNonceStr()
    {
        return $this->nonceStr;
    }

    /**
     * @param mixed $nonceStr
     */
    public function setNonceStr($nonceStr): void
    {
        $this->nonceStr = $nonceStr;
    }

    /**
     * @return mixed
     */
    public function getSignature()
    {
        return $this->signature;
    }

    /**
     * @param mixed $signature
     */
    public function setSignature($signature): void
    {
        $this->signature = $signature;
    }


}
