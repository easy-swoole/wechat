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
use EasySwoole\WeChat\OpenPlatform\OpenPlatform;


class WeChat
{
    private $globalConfig;
    private $officialAccount;
    private $miniProgram;
    private $openPlatform;

    public function __construct(Config $config = null)
    {
        if ($config == null) {
            $config = new Config();
        }
        $this->globalConfig = $config;
    }

    public function config(): Config
    {
        return $this->globalConfig;
    }

    public function miniProgram(): MiniProgram
    {
        if (!isset($this->miniProgram)) {
            $this->miniProgram = new MiniProgram($this->globalConfig->miniProgram());
        }
        return $this->miniProgram;
    }

    public function officialAccount(): OfficialAccount
    {
        if (!isset($this->officialAccount)) {
            $this->officialAccount = new OfficialAccount($this->globalConfig->officialAccount());
        }
        return $this->officialAccount;
    }

    public function openPlatform(): OpenPlatform
    {
        if (!isset($this->openPlatform)) {
            $this->openPlatform = new OpenPlatform($this->globalConfig->openPlatform());
        }
        return $this->openPlatform;
    }
}