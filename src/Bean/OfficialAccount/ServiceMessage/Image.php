<?php
/**
 * Created by PhpStorm.
 * User: EZ
 * Date: 2020/4/2
 * Time: 22:56
 */

namespace EasySwoole\WeChat\Bean\OfficialAccount\ServiceMessage;


use EasySwoole\Spl\SplArray;
use EasySwoole\WeChat\Bean\OfficialAccount\RequestConst;

class Image extends RequestedReplyMsg
{
    protected $image   = [];
    protected $msgtype = RequestConst::MSG_TYPE_IMAGE;

    /**
     * @return SplArray
     */
    public function buildMessage() : SplArray
    {
        $data = $this->toArray(null, Image::FILTER_NOT_NULL);

        return new SplArray($data);
    }

    /**
     * @return mixed
     */
    public function getMediaId() : ?string
    {
        return $this->image['media_id'] ?? null;
    }

    /**
     * @param string $image
     */
    public function setMediaId(string $image) : void
    {
        $this->image['media_id'] = $image;
    }
}