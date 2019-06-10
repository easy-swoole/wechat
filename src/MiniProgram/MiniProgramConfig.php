<?php
/**
 * Created by PhpStorm.
 * User: yf
 * Date: 2018/12/24
 * Time: 9:32 PM
 */

namespace EasySwoole\WeChat\MiniProgram;

use EasySwoole\Spl\SplBean;
use EasySwoole\WeChat\AbstractInterface\StorageInterface;
use EasySwoole\WeChat\Utility\FileStorage;

/**
 * 小程序配置文件
 * Class MiniProgramConfig
 * @package EasySwoole\WeChat\MiniProgram
 */
class MiniProgramConfig extends SplBean
{
    protected $appId;
    protected $appSecret;
    protected $storage;
    protected $tempDir;

    /**
     * 初始化小程序配置
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
     * @param $appId
     * @return MiniProgramConfig
     */
    public function setAppId($appId): MiniProgramConfig
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
     * @param $appSecret
     * @return MiniProgramConfig
     */
    public function setAppSecret($appSecret): MiniProgramConfig
    {
        $this->appSecret = $appSecret;
        return $this;
    }

    /**
     * 获取储存器
     * @return StorageInterface
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
     * @param StorageInterface $storage
     * @return MiniProgramConfig
     */
    public function setStorage(StorageInterface $storage): MiniProgramConfig
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
     */
    public function setTempDir($tempDir): void
    {
        $this->tempDir = $tempDir;
    }

}