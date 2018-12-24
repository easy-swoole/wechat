<?php
/**
 * Created by PhpStorm.
 * User: yf
 * Date: 2018/12/25
 * Time: 12:43 AM
 */

namespace EasySwoole\WeChat\Bean\OfficialAccount;


use EasySwoole\Spl\SplBean;

class QrCode extends SplBean
{
    protected $ticket;
    protected $expire_seconds;
    protected $url;

    /**
     * @return mixed
     */
    public function getTicket()
    {
        return $this->ticket;
    }

    /**
     * @param mixed $ticket
     */
    public function setTicket($ticket): void
    {
        $this->ticket = $ticket;
    }

    /**
     * @return mixed
     */
    public function getExpireSeconds()
    {
        return $this->expire_seconds;
    }

    /**
     * @param mixed $expire_seconds
     */
    public function setExpireSeconds($expire_seconds): void
    {
        $this->expire_seconds = $expire_seconds;
    }

    /**
     * @return mixed
     */
    public function getUrl()
    {
        return $this->url;
    }

    /**
     * @param mixed $url
     */
    public function setUrl($url): void
    {
        $this->url = $url;
    }
}