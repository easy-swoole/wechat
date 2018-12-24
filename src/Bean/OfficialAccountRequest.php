<?php
/**
 * Created by PhpStorm.
 * User: yf
 * Date: 2018/12/24
 * Time: 9:09 PM
 */

namespace EasySwoole\WeChat\Bean;


use EasySwoole\Spl\SplBean;

class OfficialAccountRequest extends SplBean
{
    protected $ToUserName;
    protected $FromUserName;
    protected $CreateTime;
    protected $MsgType;
    protected $Content;
    protected $MsgId;
    protected $Event;
    protected $EventKey;
    protected $Ticket;
    protected $Latitude;
    protected $Longitude;

    /**
     * @return mixed
     */
    public function getToUserName()
    {
        return $this->ToUserName;
    }

    /**
     * @param mixed $ToUserName
     */
    public function setToUserName($ToUserName): void
    {
        $this->ToUserName = $ToUserName;
    }

    /**
     * @return mixed
     */
    public function getFromUserName()
    {
        return $this->FromUserName;
    }

    /**
     * @param mixed $FromUserName
     */
    public function setFromUserName($FromUserName): void
    {
        $this->FromUserName = $FromUserName;
    }

    /**
     * @return mixed
     */
    public function getCreateTime()
    {
        return $this->CreateTime;
    }

    /**
     * @param mixed $CreateTime
     */
    public function setCreateTime($CreateTime): void
    {
        $this->CreateTime = $CreateTime;
    }

    /**
     * @return mixed
     */
    public function getMsgType()
    {
        return $this->MsgType;
    }

    /**
     * @param mixed $MsgType
     */
    public function setMsgType($MsgType): void
    {
        $this->MsgType = $MsgType;
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->Content;
    }

    /**
     * @param mixed $Content
     */
    public function setContent($Content): void
    {
        $this->Content = $Content;
    }

    /**
     * @return mixed
     */
    public function getMsgId()
    {
        return $this->MsgId;
    }

    /**
     * @param mixed $MsgId
     */
    public function setMsgId($MsgId): void
    {
        $this->MsgId = $MsgId;
    }

    /**
     * @return mixed
     */
    public function getEvent()
    {
        return $this->event;
    }

    /**
     * @param mixed $event
     */
    public function setEvent($event): void
    {
        $this->event = $event;
    }

}