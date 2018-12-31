<?php
/**
 * Created by PhpStorm.
 * User: yf
 * Date: 2018/12/24
 * Time: 4:46 PM
 */

namespace EasySwoole\WeChat;


use EasySwoole\WeChat\MiniProgram\MiniProgram;
use EasySwoole\WeChat\OfficialAccount\OfficialAccount;
use EasySwoole\WeChat\Payment\Payment;


class WeChat
{
    private $globalConfig;
    private $officialAccount;
    private $payment;

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

    /**
     * 微信支付
     * @return Payment
     */
    function payment(): Payment
    {
        if(!isset($this->payment)){
            $this->payment = new Payment($this->globalConfig->officialAccount());
        }
        return $this->payment;
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