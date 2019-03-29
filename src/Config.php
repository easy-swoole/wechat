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
use EasySwoole\WeChat\OfficialAccount\OfficialAccountConfig;
use EasySwoole\WeChat\OpenPlatform\OpenPlatformConfig;


class Config extends SplBean
{
    /*
     * 全局临时目录
     */
    protected $tempDir;
    /*
     * 公众号配置
     */
    private $officialAccount;

    public function officialAccount(): OfficialAccountConfig
    {
        if (!isset($this->officialAccount)) {
            $this->officialAccount = new OfficialAccountConfig();
            $this->officialAccount->setTempDir($this->tempDir);
        }
        return $this->officialAccount;
    }

    public function miniProgram(): MiniProgramConfig
    {
        if (!isset($this->miniProgram)) {
            $this->miniProgram = new MiniProgramConfig();
        }
        return $this->miniProgram;
    }

    public function openPlatform():OpenPlatformConfig
    {
        if (!isset($this->openPlatform)) {
            $this->openPlatform = new OpenPlatformConfig();
            $this->openPlatform->setTempDir($this->tempDir);
        }
        return $this->openPlatform;
    }

    /**
     * @param mixed $tempDir
     */
    public function setTempDir($tempDir): void
    {
        $this->tempDir = $tempDir;
    }

    protected function initialize(): void
    {
        if (empty($this->tempDir)) {
            $this->tempDir = getcwd();
        }
    }
}