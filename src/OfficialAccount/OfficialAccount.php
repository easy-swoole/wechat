<?php
/**
 * Created by PhpStorm.
 * User: yf
 * Date: 2018/12/24
 * Time: 4:58 PM
 */

namespace EasySwoole\WeChat\OfficialAccount;

use EasySwoole\WeChat\Bean\OfficialAccount\NetCheckRequest;
use EasySwoole\WeChat\Exception\OfficialAccountError;
use EasySwoole\WeChat\Utility\HttpClient;

class OfficialAccount
{
    private $config;
    private $server;
    private $jsApi;
    private $qrCode;
    private $menu;
    private $media;
    private $material;
    private $user;
    private $accessToken;
    private $onError;
    private $customerService;
    private $templateMsg;

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

    function templateMsg():TemplateMsg
    {
        if(!isset($this->templateMsg)){
            $this->templateMsg = new TemplateMsg($this);
        }
        return $this->templateMsg;
    }

    /*
     * 客服消息
     */
    function customerService()
    {
        if(!isset($this->customerService)){
            $this->customerService = new CustomerService($this);
        }
        return $this->customerService;
    }

    function qrCode():QrCode
    {
        if(!isset($this->qrCode))
        {
            $this->qrCode = new QrCode($this);
        }
        return $this->qrCode;
    }

    function menu():Menu
    {
        if(!isset($this->menu))
        {
            $this->menu = new Menu($this);
        }
        return $this->menu;
    }

    function media():Media
    {
        if(!isset($this->media))
        {
            $this->media = new Media($this);
        }
        return $this->media;
    }

    function material():Material
    {
        if(!isset($this->material))
        {
            $this->material = new Material($this);
        }
        return $this->material;
    }

    function user():User
    {
        if(!isset($this->user))
        {
            $this->user = new User($this);
        }
        return $this->user;
    }

    function getConfig():OfficialAccountConfig
    {
        return $this->config;
    }

    function getOnError()
    {
        return $this->onError;
    }

    /**
     * @return array
     * @throws OfficialAccountError
     * @throws \EasySwoole\WeChat\Exception\RequestError
     */
    function ipList():array
    {
        $url = ApiUrl::generateURL(ApiUrl::IP_LIST,[
            'ACCESS_TOKEN'=>$this->accessToken()->getToken()
        ]);

        $json = HttpClient::getForJson($url);
        $ex = OfficialAccountError::hasException($json);
        if($ex){
            throw $ex;
        }
        return $json['ip_list'];
    }

    /**
     * @param NetCheckRequest $request
     * @return array
     * @throws OfficialAccountError
     * @throws \EasySwoole\WeChat\Exception\RequestError
     */
    function netCheck(NetCheckRequest $request):array
    {
        $url = ApiUrl::generateURL(ApiUrl::NET_CHECK,[
            'ACCESS_TOKEN'=>$this->accessToken()->getToken()
        ]);

        $json = HttpClient::postJsonForJson($url,$request->toArray());
        $ex = OfficialAccountError::hasException($json);
        if($ex){
            throw $ex;
        }
        return $json;
    }
}