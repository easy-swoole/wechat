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
 *
 * @package EasySwoole\WeChat\OpenPlatform
 */
class OpenPlatformConfig extends SplBean
{
    protected $storage;
    protected $token;
    protected $aesKey;
    protected $tempDir;
    protected $componentAppId;
    protected $componentAppSecret;

    /**
     * 初始化开放平台配置
     *
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
     * 获取储存器
     *
     * @return mixed
     */
    public function getStorage(): StorageInterface
    {
        if (!isset($this->storage)) {
            $this->storage = new FileStorage($this->getTempDir(), $this->getComponentAppId());
        }
        return $this->storage;
    }

    /**
     * 设置储存器
     *
     * @param mixed $storage
     * @return OpenPlatformConfig
     */
    public function setStorage($storage): OpenPlatformConfig
    {
        $this->storage = $storage;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getAesKey()
    {
        return $this->aesKey;
    }

    /**
     * setAesKey
     *
     * @param $aesKey
     * @return OpenPlatformConfig
     */
    public function setAesKey($aesKey): OpenPlatformConfig
    {
        $this->aesKey = $aesKey;
        return $this;
    }

    /**
     * @return mixed
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * setToken
     *
     * @param $token
     * @return OpenPlatformConfig
     */
    public function setToken($token): OpenPlatformConfig
    {
        $this->token = $token;
        return $this;
    }

    /**
     * 获取临时目录
     *
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
     *
     * @param mixed $tempDir
     * @return OpenPlatformConfig
     */
    public function setTempDir($tempDir): OpenPlatformConfig
    {
        $this->tempDir = $tempDir;
        return $this;
    }

    /**
     * 获取第三方平台appid
     * @return mixed
     */
    public function getComponentAppId()
    {
        return $this->componentAppId;
    }

    /**
     * 设置第三方平台appid
     * @param mixed 
     * @return OpenPlatformConfig
     */
    public function setComponentAppId($componentAppId): OpenPlatformConfig
    {
        $this->componentAppId = $componentAppId;
        return $this;
    }

    /**
     * 获取第三方平台appsecret
     * @return mixed
     */
    public function getComponentAppSecret()
    {
        return $this->componentAppSecret;
    }

    /**
     * 设置第三方平台appsecret
     * @param mixed 
     * @return OpenPlatformConfig
     */
    public function setComponentAppSecret($componentAppSecret): OpenPlatformConfig
    {
        $this->componentAppSecret = $componentAppSecret;
        return $this;
    }
}