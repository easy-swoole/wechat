<?php


namespace EasySwoole\WeChat\Bean\OpenPlatform;


use EasySwoole\Spl\SplBean;

class AuthorizerInfo extends SplBean
{
    protected $authorizer_appid;
    protected $authorizer_access_token;
    protected $expires_in;
    protected $authorizer_refresh_token;
    protected $func_info;

    /**
     * @return mixed
     */
    public function getAuthorizerAppid()
    {
        return $this->authorizer_appid;
    }

    /**
     * @param mixed $authorizer_appid
     */
    public function setAuthorizerAppid($authorizer_appid): void
    {
        $this->authorizer_appid = $authorizer_appid;
    }

    /**
     * @return mixed
     */
    public function getAuthorizerAccessToken()
    {
        return $this->authorizer_access_token;
    }

    /**
     * @param mixed $authorizer_access_token
     */
    public function setAuthorizerAccessToken($authorizer_access_token): void
    {
        $this->authorizer_access_token = $authorizer_access_token;
    }

    /**
     * @return mixed
     */
    public function getExpiresIn()
    {
        return $this->expires_in;
    }

    /**
     * @param mixed $expires_in
     */
    public function setExpiresIn($expires_in): void
    {
        $this->expires_in = $expires_in;
    }

    /**
     * @return mixed
     */
    public function getAuthorizerRefreshToken()
    {
        return $this->authorizer_refresh_token;
    }

    /**
     * @param mixed $authorizer_refresh_token
     */
    public function setAuthorizerRefreshToken($authorizer_refresh_token): void
    {
        $this->authorizer_refresh_token = $authorizer_refresh_token;
    }

    /**
     * @return mixed
     */
    public function getFuncInfo()
    {
        return $this->func_info;
    }

    /**
     * @param mixed $func_info
     */
    public function setFuncInfo($func_info): void
    {
        $this->func_info = $func_info;
    }
}