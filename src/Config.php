<?php
/**
 * Created by PhpStorm.
 * User: yf
 * Date: 2018/12/24
 * Time: 4:46 PM
 */

namespace EasySwoole\WeChat;


use EasySwoole\Spl\SplBean;

class Config extends SplBean
{
    protected $OfficialAccountToken;
    protected $OfficialAccountAesKey;
    protected $OfficialAccountAppId;
    protected $OfficialAccountAppSecret;
    protected $OfficialAccountEncrypt = false;

    /**
     * @return mixed
     */
    public function getOfficialAccountToken()
    {
        return $this->OfficialAccountToken;
    }

    /**
     * @param mixed $OfficialAccountToken
     */
    public function setOfficialAccountToken($OfficialAccountToken): void
    {
        $this->OfficialAccountToken = $OfficialAccountToken;
    }

    /**
     * @return mixed
     */
    public function getOfficialAccountAesKey()
    {
        return $this->OfficialAccountAesKey;
    }

    /**
     * @param mixed $OfficialAccountAesKey
     */
    public function setOfficialAccountAesKey($OfficialAccountAesKey): void
    {
        $this->OfficialAccountAesKey = $OfficialAccountAesKey;
    }

    /**
     * @return mixed
     */
    public function getOfficialAccountAppId()
    {
        return $this->OfficialAccountAppId;
    }

    /**
     * @param mixed $OfficialAccountAppId
     */
    public function setOfficialAccountAppId($OfficialAccountAppId): void
    {
        $this->OfficialAccountAppId = $OfficialAccountAppId;
    }

    /**
     * @return mixed
     */
    public function getOfficialAccountAppSecret()
    {
        return $this->OfficialAccountAppSecret;
    }

    /**
     * @param mixed $OfficialAccountAppSecret
     */
    public function setOfficialAccountAppSecret($OfficialAccountAppSecret): void
    {
        $this->OfficialAccountAppSecret = $OfficialAccountAppSecret;
    }

    /**
     * @return bool
     */
    public function isOfficialAccountEncrypt(): bool
    {
        return $this->OfficialAccountEncrypt;
    }

    /**
     * @param bool $OfficialAccountEncrypt
     */
    public function setOfficialAccountEncrypt(bool $OfficialAccountEncrypt): void
    {
        $this->OfficialAccountEncrypt = $OfficialAccountEncrypt;
    }

}