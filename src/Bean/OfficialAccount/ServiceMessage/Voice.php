<?php
/**
 * Created by PhpStorm.
 * User: EZ
 * Date: 2020/4/2
 * Time: 21:15
 */

namespace EasySwoole\WeChat\Bean\OfficialAccount\ServiceMessage;


use EasySwoole\Spl\SplArray;
use EasySwoole\WeChat\Bean\OfficialAccount\RequestConst;

class Voice extends RequestedReplyMsg
{
    protected $voice   = [];
    protected $msgtype = RequestConst::MSG_TYPE_VOICE;

    /**
     * @return SplArray
     */
    public function buildMessage() : SplArray
    {
        $data = $this->toArray(null, Voice::FILTER_NOT_NULL);

        return new SplArray($data);
    }

    /**
     * @param string $mediaId
     *
     * @return Voice
     */
    public function setMediaId(string $mediaId) : Voice
    {
        $this->voice['media_id'] = $mediaId;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getMediaId() : ?string
    {
        return $this->voice['media_id'] ?? null;
    }
}