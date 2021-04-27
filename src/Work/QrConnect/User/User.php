<?php

namespace EasySwoole\WeChat\Work\QrConnect\User;

/**
 * 企业用户
 *
 * Class User
 * @package EasySwoole\WeChat\Work\QrConnect\User
 * @Date: 2021/4/27 19:49
 * @author XueSi <1592328848@qq.com>
 */
class User
{
    protected $userId;

    protected $raw;

    public function __construct(array $userData)
    {
        foreach ($userData as $k => $v) {
            if (property_exists($this, $k)) {
                $this->$k = $v;
            }
        }
    }

    /**
     * @param $userId
     * @return $this
     */
    public function setUserId($userId): self
    {
        $this->userId = $userId;
        return $this;
    }

    /**
     * @return string|null
     */
    public function getUserId(): ?string
    {
        return $this->userId;
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
