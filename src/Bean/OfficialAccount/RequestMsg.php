<?php
/**
 * Created by PhpStorm.
 * User: yf
 * Date: 2018/12/25
 * Time: 12:44 AM
 */

namespace EasySwoole\WeChat\Bean\OfficialAccount;


use EasySwoole\Spl\SplBean;

class RequestMsg extends SplBean
{
    /*
     * map to https://mp.weixin.qq.com/wiki?t=resource/res_main&id=mp1421140453
     */
    protected $ToUserName;
    protected $FromUserName;
    protected $CreateTime;
    protected $MsgType;
    protected $Content;
    protected $MsgId;
    protected $MsgID;
    protected $Event;
    protected $EventKey;
    protected $Ticket;
    protected $Latitude;
    protected $Longitude;
    protected $Title;
    protected $Description;
    protected $Url;
    protected $Location_X;
    protected $Location_Y;
    protected $Scale;
    protected $Label;
    protected $MediaId;
    protected $ThumbMediaId;
    protected $Format;
    protected $Recognition;
    protected $Status; //template msg send call back: success eq 'success' else fail

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
        if (!empty($this->MsgId)) {
            return $this->MsgId;
        }

        if (!empty($this->MsgID)) {
            return $this->MsgID;
        }

        return null;
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
        return $this->Event;
    }

    /**
     * @param mixed $Event
     */
    public function setEvent($Event): void
    {
        $this->Event = $Event;
    }

    /**
     * @return mixed
     */
    public function getEventKey()
    {
        return $this->EventKey;
    }

    /**
     * @param mixed $EventKey
     */
    public function setEventKey($EventKey): void
    {
        $this->EventKey = $EventKey;
    }

    /**
     * @return mixed
     */
    public function getTicket()
    {
        return $this->Ticket;
    }

    /**
     * @param mixed $Ticket
     */
    public function setTicket($Ticket): void
    {
        $this->Ticket = $Ticket;
    }

    /**
     * @return mixed
     */
    public function getLatitude()
    {
        return $this->Latitude;
    }

    /**
     * @param mixed $Latitude
     */
    public function setLatitude($Latitude): void
    {
        $this->Latitude = $Latitude;
    }

    /**
     * @return mixed
     */
    public function getLongitude()
    {
        return $this->Longitude;
    }

    /**
     * @param mixed $Longitude
     */
    public function setLongitude($Longitude): void
    {
        $this->Longitude = $Longitude;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->Title;
    }

    /**
     * @param mixed $Title
     */
    public function setTitle($Title): void
    {
        $this->Title = $Title;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->Description;
    }

    /**
     * @param mixed $Description
     */
    public function setDescription($Description): void
    {
        $this->Description = $Description;
    }

    /**
     * @return mixed
     */
    public function getUrl()
    {
        return $this->Url;
    }

    /**
     * @param mixed $Url
     */
    public function setUrl($Url): void
    {
        $this->Url = $Url;
    }

    /**
     * @return mixed
     */
    public function getLocationX()
    {
        return $this->Location_X;
    }

    /**
     * @param mixed $Location_X
     */
    public function setLocationX($Location_X): void
    {
        $this->Location_X = $Location_X;
    }

    /**
     * @return mixed
     */
    public function getLocationY()
    {
        return $this->Location_Y;
    }

    /**
     * @param mixed $Location_Y
     */
    public function setLocationY($Location_Y): void
    {
        $this->Location_Y = $Location_Y;
    }

    /**
     * @return mixed
     */
    public function getScale()
    {
        return $this->Scale;
    }

    /**
     * @param mixed $Scale
     */
    public function setScale($Scale): void
    {
        $this->Scale = $Scale;
    }

    /**
     * @return mixed
     */
    public function getLabel()
    {
        return $this->Label;
    }

    /**
     * @param mixed $Label
     */
    public function setLabel($Label): void
    {
        $this->Label = $Label;
    }

    /**
     * @return mixed
     */
    public function getMediaId()
    {
        return $this->MediaId;
    }

    /**
     * @param mixed $MediaId
     */
    public function setMediaId($MediaId): void
    {
        $this->MediaId = $MediaId;
    }

    /**
     * @return mixed
     */
    public function getThumbMediaId()
    {
        return $this->ThumbMediaId;
    }

    /**
     * @param mixed $ThumbMediaId
     */
    public function setThumbMediaId($ThumbMediaId): void
    {
        $this->ThumbMediaId = $ThumbMediaId;
    }

    /**
     * @return mixed
     */
    public function getFormat()
    {
        return $this->Format;
    }

    /**
     * @param mixed $Format
     */
    public function setFormat($Format): void
    {
        $this->Format = $Format;
    }

    /**
     * @return mixed
     */
    public function getRecognition()
    {
        return $this->Recognition;
    }

    /**
     * @param mixed $Recognition
     */
    public function setRecognition($Recognition): void
    {
        $this->Recognition = $Recognition;
    }

    /**
     * @return mixed
     */
    public function getStatus()
    {
        return $this->Status;
    }

    /**
     * @param mixed $Status
     */
    public function setStatus($Status): void
    {
        $this->Status = $Status;
    }

}