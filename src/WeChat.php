<?php
/**
 * Created by PhpStorm.
 * User: yf
 * Date: 2018/12/24
 * Time: 4:46 PM
 */

namespace EasySwoole\WeChat;

use EasySwoole\Component\Singleton;
use EasySwoole\WeChat\MiniProgram\MiniProgram;
use EasySwoole\WeChat\OfficialAccount\OfficialAccount;
use EasySwoole\WeChat\OpenPlatform\OpenPlatform;

/**
 * 微信SDK入口类
 * Class WeChat
 * @package EasySwoole\WeChat
 */
class WeChat
{
    /**
     * SDK全局配置
     * @var Config
     */
    private $globalConfig;

    /**
     * 微信小程序实例
     * @var MiniProgram
     */
    private $miniProgram;

    /**
     * 微信开放平台实例
     * @var OpenPlatform
     */
    private $openPlatform;

    /**
     * 微信公众号实例
     * @var OfficialAccount
     */
    private $officialAccount;

    /**
     * WeChat constructor.
     * @param Config|null $config
     */
    public function __construct(Config $config = null)
    {
        if ($config == null) {
            $config = new Config();
        }
        $this->globalConfig = $config;
    }

    /**
     * 获取全局配置
     * @return Config
     */
    public function config(): Config
    {
        return $this->globalConfig;
    }

    /**
     * 获取小程序实例
     * @return MiniProgram
     */
    public function miniProgram(): MiniProgram
    {
        if (!isset($this->miniProgram)) {
            $this->miniProgram = new MiniProgram($this->globalConfig->miniProgram());
        }
        return $this->miniProgram;
    }

    /**
     * 获取公众号实例
     * @return OfficialAccount
     */
    public function officialAccount(): OfficialAccount
    {
        if (!isset($this->officialAccount)) {
            $this->officialAccount = new OfficialAccount($this->globalConfig->officialAccount());
        }
        return $this->officialAccount;
    }

    /**
     * 获取开放平台实例
     * @return OpenPlatform
     */
    public function openPlatform(): OpenPlatform
    {
        if (!isset($this->openPlatform)) {
            $this->openPlatform = new OpenPlatform($this->globalConfig->openPlatform());
        }
        return $this->openPlatform;
    }
}