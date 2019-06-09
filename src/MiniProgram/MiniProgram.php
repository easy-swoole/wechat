<?php
/**
 * Created by PhpStorm.
 * User: yf
 * Date: 2018/12/24
 * Time: 9:32 PM
 */

namespace EasySwoole\WeChat\MiniProgram;


class MiniProgram
{
    private $config;
    private $auth;
    private $accessToken;
    private $qrCode;

    public function __construct(MiniProgramConfig $config = null)
    {
        if (is_null($config)) {
            $config = new MiniProgramConfig;
        }
        $this->config = $config;
    }

    /**
     * getConfig
     *
     * @return MiniProgramConfig
     */
    public function getConfig(): MiniProgramConfig
    {
        return $this->config;
    }

    /**
     * auth
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

    /**
     * accessToken
     *
     * @return AccessToken
     */
    public function accessToken(): AccessToken
    {
        if (!isset($this->accessToken)) {
            $this->accessToken = new AccessToken($this);
        }

        return $this->accessToken;
    }

    /**
     * qrCode
     *
     * @return QrCode
     */
    public function qrCode(): QrCode
    {
        if (!isset($this->qrCode)) {
            $this->qrCode = new QrCode($this);
        }

        return $this->qrCode;
    }
}