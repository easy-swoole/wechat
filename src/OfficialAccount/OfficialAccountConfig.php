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

    /**
     * @param mixed $token
     */
    public function setToken($token): void
    {
        $this->token = $token;
    }

    /**
     * @return mixed
     */
    public function getAesKey()
    {
        return $this->aesKey;
    }

    /**
     * @param mixed $aesKey
     */
    public function setAesKey($aesKey): void
    {
        $this->aesKey = $aesKey;
    }

    /**
     * @return mixed
     */
    public function getAppId()
    {
        return $this->appId;
    }

    /**
     * @param mixed $appId
     */
    public function setAppId($appId): void
    {
        $this->appId = $appId;
    }

    /**
     * @return bool
     */
    public function isEncrypt(): bool
    {
        return $this->encrypt;
    }

    /**
     * @param bool $encrypt
     */
    public function setEncrypt(bool $encrypt): void
    {
        $this->encrypt = $encrypt;
    }

    /**
     * @return mixed
     */
    public function getAppSecret()
    {
        return $this->appSecret;
    }

    /**
     * @param mixed $appSecret
     */
    public function setAppSecret($appSecret): void
    {
        $this->appSecret = $appSecret;
    }

    public function getStorage():StorageInterface
    {
        if(!isset($this->storage)){
            $this->storage = new FileStorage($this->tempDir,$this->getAppId());
        }
        return $this->storage;
    }

    /**
     * @param StorageInterface $storage
     */
    public function setStorage(StorageInterface $storage): void
    {
        $this->storage = $storage;
    }

    /**
     * @return mixed
     */
    public function getTempDir()
    {
        return $this->tempDir;
    }

    /**
     * @param mixed $tempDir
     */
    public function setTempDir($tempDir): void
    {
        $this->tempDir = $tempDir;
    }
}