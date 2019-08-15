<?php
/**
 * Created by PhpStorm.
 * User: eValor
 * Date: 2019-03-18
 * Time: 10:18
 */

namespace EasySwoole\WeChat\OpenPlatform;

class OpenPlatform
{
    private $config;

    private $auth;

    function __construct(OpenPlatformConfig $config = null)
    {
        if (is_null($config)) {
            $config = new OpenPlatformConfig;
        }
        $this->config = $config;
    }

    /**
     * authorization
     * @return Auth
     */
    function auth()
    {
        if (!isset($this->auth)) {
            $this->auth = new Auth($this);
        }
        return $this->auth;
    }

    /**
     * ConfigGetter
     * @return OpenPlatformConfig
     */
    public function getConfig(): OpenPlatformConfig
    {
        return $this->config;
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

    /**
     * encryptor
     *
     * @return Encryptor
     */
    public function encryptor(): Encryptor
    {
        if (!isset($this->encryptor)) {
            $this->encryptor = new Encryptor($this);
        }

        return $this->encryptor;
    }
}