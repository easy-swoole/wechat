<?php

namespace EasySwoole\WeChat\Work\QrConnect\User;

/**
 * 非企业用户
 *
 * Class ExternalUser
 * @package EasySwoole\WeChat\Work\QrConnect\User
 * @Date: 2021/4/27 19:49
 * @author XueSi <1592328848@qq.com>
 */
class ExternalUser
{
    protected $openId;

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
