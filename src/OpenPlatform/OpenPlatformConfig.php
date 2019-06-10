<?php
/**
 * Created by PhpStorm.
 * User: eValor
 * Date: 2019-03-18
 * Time: 09:35
 */

namespace EasySwoole\WeChat\OpenPlatform;

use EasySwoole\Spl\SplBean;
use EasySwoole\WeChat\AbstractInterface\StorageInterface;
use EasySwoole\WeChat\Utility\FileStorage;

/**
 * 开放平台配置
 * Class OpenPlatformConfig
 * @package EasySwoole\WeChat\OpenPlatform
 */
class OpenPlatformConfig extends SplBean
{
    protected $appId;
    protected $appSecret;
    protected $storage;
    protected $tempDir;

    /**
     * 初始化开放平台配置
     * @return void
     */
    protected function initialize(): void
    {
        // 如果没有设置临时目录则设置为系统临时目录
        if (empty($this->tempDir)) {
            $this->tempDir = sys_get_temp_dir();
        }
    }


    /**
     * 获取AppId
     * @return mixed
     */
    public function getAppId()
    {
        return $this->appId;
    }

    /**
     * 设置AppId
     * @param mixed $appId
     * @return OpenPlatformConfig
     */
    public function setAppId($appId): OpenPlatformConfig
    {
        $this->appId = $appId;
        return $this;
    }

    /**
     * 获取AppSecret
     * @return mixed
     */
    public function getAppSecret()
    {
        return $this->appSecret;
    }

    /**
     * 设置AppSecret
     * @param mixed $appSecret
     * @return OpenPlatformConfig
     */
    public function setAppSecret($appSecret): OpenPlatformConfig
    {
        $this->appSecret = $appSecret;
        return $this;
    }

    /**
     * 获取储存器
     * @return mixed
     */
    public function getStorage(): StorageInterface
    {
        if (!isset($this->storage)) {
            $this->storage = new FileStorage($this->getTempDir(), $this->getAppId());
        }
        return $this->storage;
    }

    /**
     * 设置储存器
     * @param mixed $storage
     * @return OpenPlatformConfig
     */
    public function setStorage($storage): OpenPlatformConfig
    {
        $this->storage = $storage;
        return $this;
    }

    /**
     * 获取临时目录
     * @return mixed
     */
    public function getTempDir()
    {
        if (empty($this->tempDir)) {
            $this->tempDir = sys_get_temp_dir();
        }
        return $this->tempDir;
    }

    /**
     * 设置临时目录
     * @param mixed $tempDir
     * @return OpenPlatformConfig
     */
    public function setTempDir($tempDir): OpenPlatformConfig
    {
        $this->tempDir = $tempDir;
        return $this;
    }
}