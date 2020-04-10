<?php


namespace EasySwoole\WeChat\Bean\OfficialAccount\GroupSendingMessage;


use EasySwoole\Spl\SplArray;
use EasySwoole\Spl\SplBean;

abstract class  RequestedReplyMsg extends SplBean
{
    protected $filter = [];
    protected $msgtype;
    protected $touser;
    protected $isTemporary;
    protected $clientmsgid;
    protected $towxname;

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
        unset($this->filter);
        unset($this->towxname);
        $this->touser = $touser;
    }

    /**
     * @return mixed
     */
    public function getToWxName()
    {
        return $this->towxname;
    }

    /**
     * @param string $toWxName
     */
    public function setToWxName(string $toWxName) : void
    {
        unset($this->filter);
        unset($this->touser);
        $this->towxname = $toWxName;
    }


    /**
     * @param bool $isToAll
     */
    public function setIsToAll(bool $isToAll)
    {
        unset($this->touser);
        $this->filter['is_to_all'] = $isToAll;
    }

    /**
     * @return int|null
     */
    public function getIsToAll() : ?int
    {
        return $this->filter['is_to_all'] ?? null;
    }


    /**
     * @param int $tagId
     */
    public function setTagId(int $tagId)
    {
        unset($this->touser);
        unset($this->towxname);
        $this->filter['tag_id'] = $tagId;
    }

    /**
     * @return int|null
     */
    public function getTagId() : ?int
    {
        return $this->filter['tag_id'] ?? null;
    }

    /**
     * @param string $mediaId
     */
    public function setMediaId(string $mediaId)
    {
        $this->{$this->msgtype}['media_id'] = $mediaId;
    }

    /**
     * @return null|string
     */
    public function getMediaId() : ?string
    {
        return $this->{$this->msgtype}['media_id'] ?? null;
    }

    /**
     * 群发视频内容的时候，如果视频是临时素材，需要设置该值为true转换视频素材的media_id，永久素材请忽略
     *
     * @param bool $temporary
     */
    public function setIsTemporary(bool $temporary)
    {
        $this->isTemporary = $temporary;
    }

    /**
     * @return bool|null
     */
    public function getIsTemporary() : ?bool
    {
        return $this->isTemporary ?? false;
    }

    /**
     * @param string $clientMsgId
     */
    public function setClientMsgID(string $clientMsgId)
    {
        $this->clientmsgid= $clientMsgId;
    }

    /**
     * @return null|string
     */
    public function getClientMsgID() : ?string
    {
        return $this->clientmsgid ?? '';
    }

}