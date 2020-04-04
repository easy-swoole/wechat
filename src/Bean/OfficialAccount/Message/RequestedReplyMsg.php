<?php


namespace EasySwoole\WeChat\Bean\OfficialAccount\Message;


use EasySwoole\Spl\SplArray;
use EasySwoole\Spl\SplBean;

abstract class RequestedReplyMsg extends SplBean
{
    protected $ToUserName;
    protected $FromUserName;
    protected $CreateTime;
    protected $MsgType;
    protected $Touser;

    /**
     * buildMessage
     *
     * @return SplArray
     */
    abstract public function buildMessage(): SplArray;

    protected function initialize(): void
    {
        if (empty($this->CreateTime)) {
            $this->CreateTime = time();
        }
    }

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
    public function getTouser()
    {
        return $this->Touser;
    }

    /**
     * @param $touser
     */
    public function setTouser($touser): void
    {
        $this->Touser = $touser;
    }
}