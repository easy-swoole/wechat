<?php


namespace EasySwoole\WeChat\Bean\OfficialAccount\ServiceMessage;


use EasySwoole\Spl\SplArray;
use EasySwoole\Spl\SplBean;

abstract class RequestedReplyMsg extends SplBean
{
    protected $msgtype;
    protected $touser;

    /**
     * buildMessage
     * @return SplArray
     */
    abstract public function buildMessage() : SplArray;

    /**
     * @return mixed
     */
    public function getMsgType()
    {
        return $this->msgtype;
    }

    /**
     * @param $msgtype
     */
    public function setMsgType($msgtype) : void
    {
        $this->msgtype = $msgtype;
    }

    /**
     * @return mixed
     */
    public function getTouser()
    {
        return $this->touser;
    }

    /**
     * @param $touser
     */
    public function setTouser($touser) : void
    {
        $this->touser = $touser;
    }
}