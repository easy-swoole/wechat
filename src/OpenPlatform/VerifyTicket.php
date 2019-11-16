<?php
/**
 * Created by PhpStorm.
 * User: wwl
 * Date: 2019/082/13
 * Time: 11:39 AM
 */

namespace EasySwoole\WeChat\OpenPlatform;

use EasySwoole\WeChat\Exception\OpenPlatformError;

/**
 * component_verify_ticket 微信服务器 每隔10分钟会向第三方的消息接收地址推送一次component_verify_ticket，用于获取第三方平台接口调用凭据
 * Class AccessToken
 *
 * @package EasySwoole\WeChat\OpenPlatform
 */
class VerifyTicket extends OpenPlatformBase
{

    /**
     * setTicket
     *
     * @param string   $ticket
     * @param int|null $createTime
     * @return $this
     * @throws OpenPlatformError
     */
    public function setTicket(string $ticket, int $createTime = null)
    {
        $cacheKey = $this->getCacheKey();
        $this->getOpenPlatform()->getConfig()->getStorage()->set($cacheKey, $ticket, ($createTime ?? time()) + 600);

        if (empty($this->getOpenPlatform()->getConfig()->getStorage()->get($this->getCacheKey()))) {
            throw new OpenPlatformError('Failed to cache verify ticket.');
        }

        return $this;
    }

    /**
     * getTicket
     *
     * @return string
     */
    public function getTicket(): ?string
    {
        if ($cached = $this->getOpenPlatform()->getConfig()->getStorage()->get($this->getCacheKey())) {
            return $cached;
        }
        return null;
    }

    /**
     * getCacheKey
     * 获取 cache key
     *
     * @return string
     */
    protected function getCacheKey(): string
    {
        return 'wechat.open_platform.verify_ticket.' . $this->getOpenPlatform()->getConfig()->getComponentAppId();
    }
}