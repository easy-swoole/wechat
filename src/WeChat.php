<?php
/**
 * Created by PhpStorm.
 * User: yf
 * Date: 2018/12/24
 * Time: 4:46 PM
 */

namespace EasySwoole\WeChat;


use EasySwoole\WeChat\JsApi\JsApi;
use EasySwoole\WeChat\MiniProgram\MiniProgram;
use EasySwoole\WeChat\OfficialAccount\OfficialAccount;


class WeChat
{
    private $globalConfig;
    private $officialAccount;

    function __construct(Config $config = null)
    {
        if($config == null){
            $config = new Config();
        }
        $this->globalConfig = $config;
    }

    function config():Config
    {
        return $this->globalConfig;
    }

    function jsApi():JsApi
    {

    }

    function miniProgram():MiniProgram
    {

    }

    function officialAccount():OfficialAccount
    {
        if(!isset($this->officialAccount)){
            $this->officialAccount = new OfficialAccount($this->globalConfig->officialAccount());
        }
        return $this->officialAccount;
    }
}