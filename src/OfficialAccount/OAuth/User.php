<?php

namespace EasySwoole\WeChat\OfficialAccount\OAuth;

use EasySwoole\WeChat\Kernel\Contracts\UserInterface;

class User implements UserInterface
{
    protected $id;
    protected $nickname;
    protected $avatar;
    protected $accessToken;
    protected $refreshToken;
    protected $expiresIn;

    protected $raw;
    protected $tokenResponse;

    public function __construct(array $userData)
    {
        foreach ($userData as $k => $v) {
            if (property_exists($this, $k)) {
                $this->$k = $v;
            }
        }
    }

    /**
     * @param $accessToken
     * @return $this
     */
    public function setAccessToken($accessToken): self
    {
        $this->accessToken = $accessToken;
        return $this;
    }

    /**
     * @param $refreshToken
     * @return $this
     */
    public function setRefreshToken($refreshToken): self
    {
        $this->refreshToken = $refreshToken;
        return $this;
    }

    /**
     * @param mixed $expiresIn
     */
    public function setExpiresIn($expiresIn): void
    {
        $this->expiresIn = $expiresIn;
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

    /**
     * @param $tokenResponse
     * @return $this
     */
    public function setTokenResponse($tokenResponse): self
    {
        $this->tokenResponse = $tokenResponse;
        return $this;
    }

    public function getId(): ?string
    {
        return $this->id;
    }

    public function getName(): ?string
    {
        return $this->getNickname();
    }

    public function getNickname(): ?string
    {
        return $this->nickname;
    }

    public function getAvatar(): ?string
    {
        return $this->avatar;
    }

    public function getRaw(): array
    {
        return $this->raw;
    }

    public function getAccessToken(): ?string
    {
        return $this->accessToken;
    }

    public function getRefreshToken(): ?string
    {
        return $this->refreshToken;
    }

    public function getExpiresIn(): ?int
    {
        return $this->expiresIn;
    }

    public function getTokenResponse(): array
    {
        return $this->tokenResponse;
    }
}