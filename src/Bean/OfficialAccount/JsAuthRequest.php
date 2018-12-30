<?php
/**
 * Created by PhpStorm.
 * User: yf
 * Date: 2018-12-30
 * Time: 15:00
 */

namespace EasySwoole\WeChat\Bean\OfficialAccount;


class JsAuthRequest
{
    const TYPE_BASE = 'snsapi_base';
    const TYPE_USER_INFO = 'snsapi_userinfo';
    protected $redirect_uri;
    protected $state = '';
    protected $type = self::TYPE_BASE;

    /**
     * @return mixed
     */
    public function getRedirectUri()
    {
        return $this->redirect_uri;
    }

    /**
     * @param mixed $redirect_uri
     */
    public function setRedirectUri($redirect_uri): void
    {
        $this->redirect_uri = $redirect_uri;
    }

    /**
     * @return string
     */
    public function getState(): string
    {
        return $this->state;
    }

    /**
     * @param string $state
     */
    public function setState(string $state): void
    {
        $this->state = $state;
    }

    /**
     * @return string
     */
    public function getType(): string
    {
        return $this->type;
    }

    /**
     * @param string $type
     */
    public function setType(string $type): void
    {
        $this->type = $type;
    }
}