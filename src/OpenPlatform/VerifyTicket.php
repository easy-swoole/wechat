<?php
/**
 * Created by PhpStorm.
 * User: wwl
 * Date: 2019/082/13
 * Time: 11:39 AM
 */

namespace EasySwoole\WeChat\OpenPlatform;

use EasySwoole\WeChat\Exception\Exception;

/**
 * component_verify_ticket 微信服务器 每隔10分钟会向第三方的消息接收地址推送一次component_verify_ticket，用于获取第三方平台接口调用凭据
 * Class AccessToken
 * @package EasySwoole\WeChat\OpenPlatform
 */

class VerifyTicket extends OpenPlatformBase
{

    /**
     * set component_verify_ticket
     */
    public function setTicket(string $ticket)
    {
        $cacheKey = $this->getCacheKey();
        $this->getOpenPlatform()->getConfig()->getStorage()->set($cacheKey, $ticket, time() + 580);

        if (!$this->getOpenPlatform()->getConfig()->getStorage()->get($this->getCacheKey())) {
            throw new Exception('Failed to cache verify ticket');
        }

        return $this;

    }

    /**
     * get component_verify_ticket
     * @return string
     */
    public function getTicket(): string
    {
        if ($cached = $this->getOpenPlatform()->getConfig()->getStorage()->get($this->getCacheKey())) {
            return $cached;
        }
    }

    /**
     * 获取 cache key
     * @return string
     */
    protected function getCacheKey(): string
    {
        return 'wechat.open_platform.verify_ticket.'.$this->getOpenPlatform()->getConfig()->getAppId();
    }
}