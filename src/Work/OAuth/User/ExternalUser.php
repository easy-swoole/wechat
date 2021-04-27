<?php

namespace EasySwoole\WeChat\Work\OAuth\User;

/**
 * 非企业用户
 *
 * Class ExternalUser
 * @package EasySwoole\WeChat\Work\OAuth\User
 * @Date: 2021/4/27 19:05
 * @author XueSi <1592328848@qq.com>
 */
class ExternalUser
{
    protected $openId;
    protected $deviceId;
    protected $externalUserId;

    protected $raw;

    public function __construct(array $userData)
    {
        foreach ($userData as $k => $v) {
            if (property_exists($this, $k)) {
                $this->$k = $v;
            }
        }
    }

    public function setOpenId($openId): self
    {
        $this->openId = $openId;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getOpenId(): ?string
    {
        return $this->openId;
    }

    /**
     * @param $deviceId
     * @return $this
     */
    public function setDeviceId($deviceId): self
    {
        $this->deviceId = $deviceId;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getDeviceId(): ?string
    {
        return $this->deviceId;
    }

    /**
     * @param $externalUserId
     * @return $this
     */
    public function setExternalUserId($externalUserId): self
    {
        $this->externalUserId = $externalUserId;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getExternalUserId(): ?string
    {
        return $this->externalUserId;
    }

    /**
     * @param $raw
     * @return $this
     */
    public function setRaw($raw): self
    {
        $this->raw = $raw;
        return $this;
    }

    public function getRaw(): array
    {
        return $this->raw;
    }
}
