<?php
/**
 * Created by PhpStorm.
 * User: yf
 * Date: 2018/12/24
 * Time: 4:58 PM
 */

namespace EasySwoole\WeChat\OfficialAccount;

use EasySwoole\WeChat\AbstractInterface\AccessTokenInterface;
use EasySwoole\WeChat\Bean\OfficialAccount\NetCheckRequest;
use EasySwoole\WeChat\Exception\OfficialAccountError;
use EasySwoole\WeChat\Utility\NetWork;

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
    private $service;
    private $groupSending;
    private $comment;
    private $dataCube;

    public function onError(callable $onError)
    {
        $this->onError = $onError;
    }

    public function __construct(OfficialAccountConfig $config = null, AccessTokenInterface $accessToken = null)
    {
        if (is_null($config)) {
            $config = new OfficialAccountConfig;
        }

        if (!is_null($accessToken)) {
            $this->accessToken = $accessToken;
        }

        $this->config = $config;
    }

    public function server(): Server
    {
        if (!isset($this->server)) {
            $this->server = new Server($this);
        }
        return $this->server;
    }

    public function jsApi(): JsApi
    {
        if (!isset($this->jsApi)) {
            $this->jsApi = new JsApi($this);
        }
        return $this->jsApi;
    }

    public function accessToken(): AccessTokenInterface
    {
        if (!isset($this->accessToken)) {
            $this->accessToken = new AccessToken($this);
        }
        return $this->accessToken;
    }

    public function setAccessTokenManager(AccessTokenInterface $accessToken):OfficialAccount
    {
        $this->accessToken = $accessToken;
        return $this;
    }

    public function templateMsg(): TemplateMsg
    {
        if (!isset($this->templateMsg)) {
            $this->templateMsg = new TemplateMsg($this);
        }
        return $this->templateMsg;
    }

    public function service(): Service
    {
        if (!isset($this->service)) {
            $this->service = new Service($this);
        }
        return $this->service;
    }

    public function groupSending(): GroupSending
    {
        if (!isset($this->groupSending)) {
            $this->groupSending = new GroupSending($this);
        }
        return $this->groupSending;
    }

    /*
     * 客服消息
     */
    public function customerService()
    {
        if (!isset($this->customerService)) {
            $this->customerService = new CustomerService($this);
        }
        return $this->customerService;
    }

    public function qrCode(): QrCode
    {
        if (!isset($this->qrCode)) {
            $this->qrCode = new QrCode($this);
        }
        return $this->qrCode;
    }

    public function menu(): Menu
    {
        if (!isset($this->menu)) {
            $this->menu = new Menu($this);
        }
        return $this->menu;
    }

    public function media(): Media
    {
        if (!isset($this->media)) {
            $this->media = new Media($this);
        }
        return $this->media;
    }

    public function material(): Material
    {
        if (!isset($this->material)) {
            $this->material = new Material($this);
        }
        return $this->material;
    }

    public function user(): User
    {
        if (!isset($this->user)) {
            $this->user = new User($this);
        }
        return $this->user;
    }

    public function comment(): Comment
    {
        if (!isset($this->comment)) {
            $this->comment = new Comment($this);
        }
        return $this->comment;
    }

    public function dataCube(): DataCube
    {
        if (!isset($this->dataCube)) {
            $this->dataCube = new DataCube($this);
        }
        return $this->dataCube;
    }

    public function getConfig(): OfficialAccountConfig
    {
        return $this->config;
    }

    public function getOnError()
    {
        return $this->onError;
    }

    /**
     * ipList
     *
     * @return array
     * @throws OfficialAccountError
     * @throws \EasySwoole\HttpClient\Exception\InvalidUrl
     * @throws \EasySwoole\WeChat\Exception\RequestError
     */
    public function ipList(): array
    {
        $url = ApiUrl::generateURL(ApiUrl::IP_LIST, [
            'ACCESS_TOKEN' => $this->accessToken()->getToken()
        ]);

        $json = NetWork::getForJson($url);
        $ex = OfficialAccountError::hasException($json);
        if ($ex) {
            throw $ex;
        }
        return $json['ip_list'];
    }

    /**
     * netCheck
     *
     * @param NetCheckRequest $request
     * @return array
     * @throws OfficialAccountError
     * @throws \EasySwoole\HttpClient\Exception\InvalidUrl
     * @throws \EasySwoole\WeChat\Exception\RequestError
     */
    public function netCheck(NetCheckRequest $request): array
    {
        $url = ApiUrl::generateURL(ApiUrl::NET_CHECK, [
            'ACCESS_TOKEN' => $this->accessToken()->getToken()
        ]);

        $json = NetWork::postJsonForJson($url, $request->toArray());
        $ex = OfficialAccountError::hasException($json);
        if ($ex) {
            throw $ex;
        }
        return $json;
    }
}