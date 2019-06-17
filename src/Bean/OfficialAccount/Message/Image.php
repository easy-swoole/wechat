<?php


namespace EasySwoole\WeChat\Bean\OfficialAccount\Message;


use EasySwoole\Spl\SplArray;
use EasySwoole\WeChat\Bean\OfficialAccount\RequestConst;

class Image extends RequestedReplyMsg
{
    protected $Image = [];
    protected $MsgType = RequestConst::MSG_TYPE_IMAGE;

    public function buildMessage(): SplArray
    {
        $data = $this->toArray(null, self::FILTER_NOT_NULL);
        return new SplArray($data);
    }

    /**
     * setMediaId
     *
     * @param string $mediaId
     * @return Image
     */
    public function setMediaId(string $mediaId): Image
    {
        $this->Image['MediaId'] = $mediaId;
        return $this;
    }

    /**
     * getMediaId
     *
     * @return string|null
     */
    public function getMediaId(): ?string
    {
        return $this->Image['MediaId'] ?? null;
    }
}