<?php


namespace EasySwoole\WeChat\Bean\OpenPlatform;


use EasySwoole\Spl\SplBean;

class RequestMsg extends SplBean
{
    protected $AppId;
    protected $CreateTime;
    protected $InfoType;
    protected $AuthorizerAppid;
    protected $AuthorizationCode;
    protected $AuthorizationCodeExpiredTime;
    protected $PreAuthCode;
    protected $ComponentVerifyTicket;
    protected $ToUserName;
    protected $Encrypt;

    /**
     * @return mixed
     */
    public function getAppId()
    {
        return $this->AppId;
    }

    /**
     * @param mixed $AppId
     */
    public function setAppId($AppId): void
    {
        $this->AppId = $AppId;
    }

    /**
     * @return mixed
     */
    public function getCreateTime()
    {
        return $this->CreateTime;
    }

    /**
     * @param mixed $CreateTime
     */
    public function setCreateTime($CreateTime): void
    {
        $this->CreateTime = $CreateTime;
    }

    /**
     * @return mixed
     */
    public function getInfoType()
    {
        return $this->InfoType;
    }

    /**
     * @param mixed $InfoType
     */
    public function setInfoType($InfoType): void
    {
        $this->InfoType = $InfoType;
    }

    /**
     * @return mixed
     */
    public function getAuthorizerAppid()
    {
        return $this->AuthorizerAppid;
    }

    /**
     * @param mixed $AuthorizerAppid
     */
    public function setAuthorizerAppid($AuthorizerAppid): void
    {
        $this->AuthorizerAppid = $AuthorizerAppid;
    }

    /**
     * @return mixed
     */
    public function getAuthorizationCode()
    {
        return $this->AuthorizationCode;
    }

    /**
     * @param mixed $AuthorizationCode
     */
    public function setAuthorizationCode($AuthorizationCode): void
    {
        $this->AuthorizationCode = $AuthorizationCode;
    }

    /**
     * @return mixed
     */
    public function getAuthorizationCodeExpiredTime()
    {
        return $this->AuthorizationCodeExpiredTime;
    }

    /**
     * @param mixed $AuthorizationCodeExpiredTime
     */
    public function setAuthorizationCodeExpiredTime($AuthorizationCodeExpiredTime): void
    {
        $this->AuthorizationCodeExpiredTime = $AuthorizationCodeExpiredTime;
    }

    /**
     * @return mixed
     */
    public function getPreAuthCode()
    {
        return $this->PreAuthCode;
    }

    /**
     * @param mixed $PreAuthCode
     */
    public function setPreAuthCode($PreAuthCode): void
    {
        $this->PreAuthCode = $PreAuthCode;
    }

    /**
     * @return mixed
     */
    public function getComponentVerifyTicket()
    {
        return $this->ComponentVerifyTicket;
    }

    /**
     * @param mixed $ComponentVerifyTicket
     */
    public function setComponentVerifyTicket($ComponentVerifyTicket): void
    {
        $this->ComponentVerifyTicket = $ComponentVerifyTicket;
    }

    /**
     * @return mixed
     */
    public function getToUserName()
    {
        return $this->ToUserName;
    }

    /**
     * @param mixed $ToUserName
     */
    public function setToUserName($ToUserName): void
    {
        $this->ToUserName = $ToUserName;
    }

    /**
     * @return mixed
     */
    public function getEncrypt()
    {
        return $this->Encrypt;
    }

    /**
     * @param mixed $Encrypt
     */
    public function setEncrypt($Encrypt): void
    {
        $this->Encrypt = $Encrypt;
    }

    public function isOfficialAccountMessage(): bool
    {
        return !empty($this->getToUserName());
    }
}