<?php
/**
 * Created by PhpStorm.
 * User: eValor
 * Date: 2019-03-18
 * Time: 09:35
 */

namespace EasySwoole\WeChat\OpenPlatform;

use EasySwoole\WeChat\AbstractInterface\StorageInterface;
use EasySwoole\WeChat\Utility\FileStorage;

class OpenPlatformConfig
{
    private $appId;
    private $appSecret;
    private $storage;
    private $tempDir;

    /**
     * AppIdGetter
     * @return mixed
     */
    public function getAppId()
    {
        return $this->appId;
    }

    /**
     * AppIdSetter
     * @param mixed $appId
     * @return OpenPlatformConfig
     */
    public function setAppId($appId): OpenPlatformConfig
    {
        $this->appId = $appId;
        return $this;
    }

    /**
     * AppSecretGetter
     * @return mixed
     */
    public function getAppSecret()
    {
        return $this->appSecret;
    }

    /**
     * AppSecretSetter
     * @param mixed $appSecret
     * @return OpenPlatformConfig
     */
    public function setAppSecret($appSecret): OpenPlatformConfig
    {
        $this->appSecret = $appSecret;
        return $this;
    }

    /**
     * StorageGetter
     * @return mixed
     */
    public function getStorage(): StorageInterface
    {
        if (!isset($this->storage)) {
            $this->storage = new FileStorage($this->tempDir, $this->getAppId());
        }
        return $this->storage;
    }

    /**
     * StorageSetter
     * @param mixed $storage
     * @return OpenPlatformConfig
     */
    public function setStorage($storage): OpenPlatformConfig
    {
        $this->storage = $storage;
        return $this;
    }

    /**
     * TempDirGetter
     * @return mixed
     */
    public function getTempDir()
    {
        return $this->tempDir;
    }

    /**
     * TempDirSetter
     * @param mixed $tempDir
     * @return OpenPlatformConfig
     */
    public function setTempDir($tempDir): OpenPlatformConfig
    {
        $this->tempDir = $tempDir;
        return $this;
    }
}