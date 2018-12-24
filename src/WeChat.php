<?php
/**
 * Created by PhpStorm.
 * User: yf
 * Date: 2018/12/24
 * Time: 4:46 PM
 */

namespace EasySwoole\WeChat;


use EasySwoole\WeChat\JsApi\JsApi;
use EasySwoole\WeChat\OfficialAccount\OfficialAccount;
use EasySwoole\WeChat\OfficialAccount\OfficialAccountConfig;

class WeChat
{
    private $globalConfig;
    private $officialAccount;

    function __construct(Config $config)
    {
        $this->globalConfig = $config;
    }

    function jsApi():JsApi
    {

    }

    function officialAccount():OfficialAccount
    {
        if(!isset($this->officialAccount)){
            $config = new OfficialAccountConfig();
            $config->setAppId($this->globalConfig->getOfficialAccountAppId());
            $config->setAppSecret($this->globalConfig->getOfficialAccountAppSecret());
            $config->setToken($this->globalConfig->getOfficialAccountToken());
            $config->setEncrypt($this->globalConfig->getOfficialAccountAppSecret());
            $this->officialAccount = new OfficialAccount($config);
        }
        return $this->officialAccount;
    }
}