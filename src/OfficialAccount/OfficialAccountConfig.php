<?php
/**
 * Created by PhpStorm.
 * User: yf
 * Date: 2018/12/24
 * Time: 5:00 PM
 */

namespace EasySwoole\WeChat\OfficialAccount;


use EasySwoole\WeChat\AbstractInterface\StorageInterface;
use EasySwoole\WeChat\Utility\FileStorage;

class OfficialAccountConfig
{
    private $token;
    private $aesKey;
    private $appId;
    private $appSecret;
    private $encrypt = false;
    private $storage;
    private $tempDir;

    /**
     * @return mixed
     */
    public function getToken()
    {
        return $this->token;
    }


    public function setToken($token): OfficialAccountConfig
    {
        $this->token = $token;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAesKey()
    {
        return $this->aesKey;
    }


    public function setAesKey($aesKey): OfficialAccountConfig
    {
        $this->aesKey = $aesKey;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAppId()
    {
        return $this->appId;
    }


    public function setAppId($appId): OfficialAccountConfig
    {
        $this->appId = $appId;
        return $this;
    }

    /**
     * @return bool
     */
    public function isEncrypt(): bool
    {
        return $this->encrypt;
    }


    public function setEncrypt(bool $encrypt): OfficialAccountConfig
    {
        $this->encrypt = $encrypt;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAppSecret()
    {
        return $this->appSecret;
    }

    public function setAppSecret($appSecret): OfficialAccountConfig
    {
        $this->appSecret = $appSecret;
        return $this;
    }

    public function getStorage():StorageInterface
    {
        if(!isset($this->storage)){
            $this->storage = new FileStorage($this->tempDir,$this->getAppId());
        }
        return $this->storage;
    }


    public function setStorage(StorageInterface $storage): OfficialAccountConfig
    {
        $this->storage = $storage;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getTempDir()
    {
        return $this->tempDir;
    }

    public function setTempDir($tempDir): OfficialAccountConfig
    {
        $this->tempDir = $tempDir;
        return $this;
    }
}