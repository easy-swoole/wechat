<?php
/**
 * Created by PhpStorm.
 * User: yf
 * Date: 2018/12/24
 * Time: 4:46 PM
 */

namespace EasySwoole\WeChat;


use EasySwoole\Spl\SplBean;
use EasySwoole\WeChat\AbstractInterface\AbstractStorage;

class Config extends SplBean
{
    protected $officialAccountToken;
    protected $officialAccountAesKey;
    protected $officialAccountAppId;
    protected $officialAccountAppSecret;
    protected $officialAccountEncrypt = false;
    protected $officialAccountStorage;

    /**
     * @return mixed
     */
    public function getOfficialAccountToken()
    {
        return $this->officialAccountToken;
    }

    /**
     * @param mixed $officialAccountToken
     */
    public function setOfficialAccountToken($officialAccountToken): void
    {
        $this->officialAccountToken = $officialAccountToken;
    }

    /**
     * @return mixed
     */
    public function getOfficialAccountAesKey()
    {
        return $this->officialAccountAesKey;
    }

    /**
     * @param mixed $officialAccountAesKey
     */
    public function setOfficialAccountAesKey($officialAccountAesKey): void
    {
        $this->officialAccountAesKey = $officialAccountAesKey;
    }

    /**
     * @return mixed
     */
    public function getOfficialAccountAppId()
    {
        return $this->officialAccountAppId;
    }

    /**
     * @param mixed $officialAccountAppId
     */
    public function setOfficialAccountAppId($officialAccountAppId): void
    {
        $this->officialAccountAppId = $officialAccountAppId;
    }

    /**
     * @return mixed
     */
    public function getOfficialAccountAppSecret()
    {
        return $this->officialAccountAppSecret;
    }

    /**
     * @param mixed $officialAccountAppSecret
     */
    public function setOfficialAccountAppSecret($officialAccountAppSecret): void
    {
        $this->officialAccountAppSecret = $officialAccountAppSecret;
    }

    /**
     * @return bool
     */
    public function isOfficialAccountEncrypt(): bool
    {
        return $this->officialAccountEncrypt;
    }

    /**
     * @param bool $officialAccountEncrypt
     */
    public function setOfficialAccountEncrypt(bool $officialAccountEncrypt): void
    {
        $this->officialAccountEncrypt = $officialAccountEncrypt;
    }

    /**
     * @return mixed
     */
    public function getOfficialAccountStorage()
    {
        return $this->officialAccountStorage;
    }

    /**
     * @param AbstractStorage $officialAccountStorage
     */
    public function setOfficialAccountStorage(AbstractStorage $officialAccountStorage): void
    {
        $this->officialAccountStorage = $officialAccountStorage;
    }
}