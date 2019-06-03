<?php
/**
 * Created by PhpStorm.
 * User: yf
 * Date: 2018/12/24
 * Time: 9:32 PM
 */

namespace EasySwoole\WeChat\MiniProgram;


use EasySwoole\WeChat\AbstractInterface\StorageInterface;
use EasySwoole\WeChat\Utility\FileStorage;

class MiniProgramConfig
{
    private $appId;
    private $appSecret;
    private $storage;
    private $tempDir;

    /**
     * @return mixed
     */
    public function getAppId()
    {
        return $this->appId;
    }

    /**
     * setAppId
     *
     * @param $appId
     * @return MiniProgramConfig
     */
    public function setAppId($appId): MiniProgramConfig
    {
        $this->appId = $appId;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAppSecret()
    {
        return $this->appSecret;
    }

    /**
     * setAppSecret
     *
     * @param $appSecret
     * @return MiniProgramConfig
     */
    public function setAppSecret($appSecret): MiniProgramConfig
    {
        $this->appSecret = $appSecret;
        return $this;
    }

    /**
     * getStorage
     *
     * @return StorageInterface
     */
    public function getStorage():StorageInterface
    {
        if(!isset($this->storage)){
            $this->storage = new FileStorage($this->tempDir,$this->getAppId());
        }
        return $this->storage;
    }

    /**
     * setStorage
     *
     * @param StorageInterface $storage
     * @return MiniProgramConfig
     */
    public function setStorage(StorageInterface $storage): MiniProgramConfig
    {
        $this->storage = $storage;
        return $this;
    }
}