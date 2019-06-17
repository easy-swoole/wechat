<?php


namespace EasySwoole\WeChat\Bean\OfficialAccount\Message;


use EasySwoole\Spl\SplArray;
use EasySwoole\WeChat\Bean\OfficialAccount\RequestConst;

class Voice extends RequestedReplyMsg
{
    protected $Voice = [];
    protected $MsgType = RequestConst::MSG_TYPE_VOICE;

    public function buildMessage(): SplArray
    {
        $data = $this->toArray(null, self::FILTER_NOT_NULL);
        return new SplArray($data);
    }

    /**
     * setMediaId
     *
     * @param string $mediaId
     * @return Voice
     */
    public function setMediaId(string $mediaId): Voice
    {
        $this->Voice['MediaId'] = $mediaId;
        return $this;
    }

    /**
     * getMediaId
     *
     * @return string|null
     */
    public function getMediaId(): ?string
    {
        return $this->Voice['MediaId'] ?? null;
    }
}