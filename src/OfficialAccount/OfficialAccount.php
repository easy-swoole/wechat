<?php
/**
 * Created by PhpStorm.
 * User: yf
 * Date: 2018/12/24
 * Time: 4:58 PM
 */

namespace EasySwoole\WeChat\OfficialAccount;

use EasySwoole\WeChat\JsApi\JsApi;

class OfficialAccount
{
    private $config;

    private $server;
    private $jsApi;
    private $qrCode;

    private $accessToken;
    private $onError;

    function onError(callable $onError)
    {
        $this->onError = $onError;
    }

    function __construct(OfficialAccountConfig $config)
    {
        $this->config = $config;
    }

    function server():Server
    {
        if(!isset($this->server))
        {
            $this->server = new Server($this);
        }
        return $this->server;
    }

    function jsApi():JsApi
    {
        if(!isset($this->jsApi)){
            $this->jsApi = new JsApi($this);
        }
        return $this->jsApi;
    }

    function accessToken():AccessToken
    {
        if(!isset($this->accessToken)){
            $this->accessToken = new AccessToken($this);
        }
        return $this->accessToken;
    }

    function qrCode():QrCode
    {
        if(!isset($this->qrCode))
        {
            $this->qrCode = new QrCode($this);
        }
        return $this->qrCode;
    }

    function getConfig():OfficialAccountConfig
    {
        return $this->config;
    }

    function getOnError()
    {
        return $this->onError;
    }
}