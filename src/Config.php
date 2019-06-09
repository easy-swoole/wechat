<?php
/**
 * Created by PhpStorm.
 * User: yf
 * Date: 2018/12/24
 * Time: 4:46 PM
 */

namespace EasySwoole\WeChat;

use EasySwoole\Spl\SplBean;
use EasySwoole\WeChat\MiniProgram\MiniProgramConfig;
use EasySwoole\WeChat\OpenPlatform\OpenPlatformConfig;
use EasySwoole\WeChat\OfficialAccount\OfficialAccountConfig;

/**
 * 全局配置定义
 * Class Config
 * @package EasySwoole\WeChat
 */
class Config extends SplBean
{
    protected $tempDir;

    /**
     * 小程序配置
     * @var MiniProgramConfig|null
     */
    private $miniProgram;

    /**
     * 开放平台配置
     * @var OpenPlatformConfig|null
     */
    private $openPlatform;

    /**
     * 公众号配置
     * @var OfficialAccountConfig|null
     */
    private $officialAccount;

    /**
     * 初始化全局配置
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
     * 获取公众号配置
     * @param array $config
     * @return OfficialAccountConfig
     */
    public function officialAccount($config = []): OfficialAccountConfig
    {
        if (!isset($this->officialAccount)) {
            $this->officialAccount = new OfficialAccountConfig($config);
            $this->officialAccount->setTempDir($this->getTempDir());
        }
        return $this->officialAccount;
    }

    /**
     * 获取小程序配置
     * @param array $config
     * @return MiniProgramConfig
     */
    public function miniProgram($config = []): MiniProgramConfig
    {
        if (!isset($this->miniProgram)) {
            $this->miniProgram = new MiniProgramConfig($config);
            $this->miniProgram->setTempDir($this->getTempDir());
        }
        return $this->miniProgram;
    }

    /**
     * 获取开放平台配置
     * @param array $config
     * @return OpenPlatformConfig
     */
    public function openPlatform($config = []): OpenPlatformConfig
    {
        if (!isset($this->openPlatform)) {
            $this->openPlatform = new OpenPlatformConfig($config);
            $this->openPlatform->setTempDir($this->getTempDir());
        }
        return $this->openPlatform;
    }

    /**
     * 获取全局缓存目录
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
     * 设置全局缓存目录
     * @param mixed $tempDir
     * @return Config
     */
    public function setTempDir($tempDir): Config
    {
        $this->tempDir = $tempDir;
        return $this;
    }

}