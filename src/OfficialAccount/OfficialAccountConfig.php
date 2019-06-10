<?php
/**
 * Created by PhpStorm.
 * User: yf
 * Date: 2018/12/24
 * Time: 5:00 PM
 */

namespace EasySwoole\WeChat\OfficialAccount;

use EasySwoole\Spl\SplBean;
use EasySwoole\WeChat\AbstractInterface\StorageInterface;
use EasySwoole\WeChat\Utility\FileStorage;

/**
 * 公众号配置文件
 * Class OfficialAccountConfig
 * @package EasySwoole\WeChat\OfficialAccount
 */
class OfficialAccountConfig extends SplBean
{
    protected $token;
    protected $aesKey;
    protected $appId;
    protected $appSecret;
    protected $encrypt = false;
    protected $storage;
    protected $tempDir;

    /**
     * 初始化公众号配置
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
     * 获取Token
     * @return mixed
     */
    public function getToken()
    {
        return $this->token;
    }

    /**
     * 设置Token
     * @param $token
     * @return OfficialAccountConfig
     */
    public function setToken($token): OfficialAccountConfig
    {
        $this->token = $token;
        return $this;
    }

    /**
     * 获取AesKey
     * @return mixed
     */
    public function getAesKey()
    {
        return $this->aesKey;
    }

    /**
     * 设置AesKey
     * @param $aesKey
     * @return OfficialAccountConfig
     */
    public function setAesKey($aesKey): OfficialAccountConfig
    {
        $this->aesKey = $aesKey;
        return $this;
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
     * @return OfficialAccountConfig
     */
    public function setAppId($appId): OfficialAccountConfig
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
     * @return OfficialAccountConfig
     */
    public function setAppSecret($appSecret): OfficialAccountConfig
    {
        $this->appSecret = $appSecret;
        return $this;
    }

    /**
     * 加密模式
     * @return bool
     */
    public function isEncrypt(): bool
    {
        return $this->encrypt;
    }

    /**
     * 设置加密模式
     * @param bool $encrypt
     * @return OfficialAccountConfig
     */
    public function setEncrypt(bool $encrypt): OfficialAccountConfig
    {
        $this->encrypt = $encrypt;
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
     * @return OfficialAccountConfig
     */
    public function setStorage(StorageInterface $storage): OfficialAccountConfig
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
     * @param $tempDir
     * @return OfficialAccountConfig
     */
    public function setTempDir($tempDir): OfficialAccountConfig
    {
        $this->tempDir = $tempDir;
        return $this;
    }
}