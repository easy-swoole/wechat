<?php
/**
 * Created by PhpStorm.
 * User: EZ
 * Date: 2020/4/2
 * Time: 21:16
 */

namespace EasySwoole\WeChat\Bean\OfficialAccount\ServiceMessage;


use EasySwoole\Spl\SplArray;
use EasySwoole\WeChat\Bean\OfficialAccount\RequestConst;

class Video extends RequestedReplyMsg
{
    protected $video   = [];
    protected $msgtype = RequestConst::MSG_TYPE_VIDEO;

    /**
     * @return SplArray
     */
    public function buildMessage() : SplArray
    {
        $data = $this->toArray(null, Video::FILTER_NOT_NULL);

        return new SplArray($data);
    }

    /**
     * @param string $mediaId
     *
     * @return Video
     */
    public function setMediaId(string $mediaId) : Video
    {
        $this->video['media_id'] = $mediaId;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getMediaId() : ?string
    {
        return $this->video['media_id'] ?? null;
    }

    /**
     * @param string $title
     *
     * @return Video
     */
    public function setTitle(string $title) : Video
    {
        $this->video['title'] = $title;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getTitle() : ?string
    {
        return $this->video['title'] ?? null;
    }

    /**
     * @param string $title
     *
     * @return Video
     */
    public function setThumbMediaId(string $thumbMediaId) : Video
    {
        $this->video['thumb_media_id'] = $thumbMediaId;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getThumbMediaId() : ?string
    {
        return $this->video['thumb_media_id'] ?? null;
    }

    /**
     * @param string $description
     *
     * @return Video
     */
    public function setDescription(string $description) : Video
    {
        $this->video['description'] = $description;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getDescription() : ?string
    {
        return $this->video['description'] ?? null;
    }
}