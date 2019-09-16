<?php
/**
 * Created by PhpStorm.
 * User: eValor
 * Date: 2019-03-18
 * Time: 10:18
 */

namespace EasySwoole\WeChat\OpenPlatform;

use EasySwoole\WeChat\MiniProgram\MiniProgram;
use EasySwoole\WeChat\MiniProgram\MiniProgramConfig;
use EasySwoole\WeChat\OfficialAccount\OfficialAccount;
use EasySwoole\WeChat\OfficialAccount\OfficialAccountConfig;

class OpenPlatform
{
    private $config;
    private $verifyTicket;
    private $server;
    private $auth;
    private $officialAccounts = [];
    private $miniPrograms = [];

    public function __construct(OpenPlatformConfig $config = null)
    {
        if (is_null($config)) {
            $config = new OpenPlatformConfig;
        }
        $this->config = $config;
    }

    /**
     * authorization
     *
     * @return Auth
     */
    public function auth(): Auth
    {
        if (!isset($this->auth)) {
            $this->auth = new Auth($this);
        }
        return $this->auth;
    }

    public function server(): Server
    {
        if (!isset($this->server)) {
            $this->server = new Server($this);
        }
        return $this->server;
    }

    public function officialAccount(string $appId): OfficialAccount
    {
        if (!isset($this->officialAccounts[$appId])) {
            $config = new OfficialAccountConfig();
            $config->setAppId($appId);
            $this->officialAccounts[$appId] = new OfficialAccount($config);
        }
        return $this->officialAccounts[$appId];
    }

    public function miniProgram(string $appId): MiniProgram
    {
        if (!isset($this->miniPrograms[$appId])) {
            $config = new MiniProgramConfig();
            $config->setAppId($appId);
            $this->miniPrograms[$appId] = new MiniProgram($config);
        }
        return $this->miniPrograms[$appId];
    }

    /**
     * ConfigGetter
     *
     * @return OpenPlatformConfig
     */
    public function getConfig(): OpenPlatformConfig
    {
        return $this->config;
    }

    /**
     * accessToken
     *
     * @return ComponentAccessToken
     */
    public function componentAccessToken(): ComponentAccessToken
    {
        if (!isset($this->accessToken)) {
            $this->accessToken = new ComponentAccessToken($this);
        }

        return $this->accessToken;
    }

    /**
     * VerifyTicket
     *
     * @return VerifyTicket
     */
    public function verifyTicket(): VerifyTicket
    {
        if (!isset($this->verifyTicket)) {
            $this->verifyTicket = new VerifyTicket($this);
        }

        return $this->verifyTicket;
    }
}