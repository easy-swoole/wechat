<?php


namespace EasySwoole\WeChat\Bean\OfficialAccount\Message;


use EasySwoole\Spl\SplArray;
use EasySwoole\WeChat\Bean\OfficialAccount\RequestConst;

class Video extends RequestedReplyMsg
{
    protected $Video = [];
    protected $MsgType = RequestConst::MSG_TYPE_VIDEO;

    /**
     * buildMessage
     *
     * @return SplArray
     */
    public function buildMessage(): SplArray
    {
        $data = $this->toArray(null, Video::FILTER_NOT_NULL);
        return new SplArray($data);
    }

    /**
     * getVideoData
     *
     * @return array
     */
    public function getVideoData(): array
    {
        return $this->Video;
    }

    /**
     * setVideoData
     *
     * @param array $data
     * @return Video
     */
    public function setVideoData(array $data): Video
    {
        $this->Video = $data;
        return $this;
    }

    /**
     * setMediaId
     *
     * @param string $mediaId
     * @return Video
     */
    public function setMediaId(string $mediaId): Video
    {
        $this->Video['MediaId'] = $mediaId;
        return $this;
    }

    /**
     * getMediaId
     *
     * @return string|null
     */
    public function getMediaId(): ?string
    {
        return $this->Video['MediaId'] ?? null;
    }

    /**
     * setTitle
     *
     * @param string $title
     * @return Video
     */
    public function setTitle(string $title): Video
    {
        $this->Video['Title'] = $title;
        return $this;
    }

    /**
     * getTitle
     *
     * @return string|null
     */
    public function getTitle(): ?string
    {
        return $this->Video['Title'] ?? null;
    }

    /**
     * setDescription
     *
     * @param string $description
     * @return Video
     */
    public function setDescription(string $description): Video
    {
        $this->Video['Description'] = $description;
        return $this;
    }

    /**
     * getDescription
     *
     * @return string|null
     */
    public function getDescription(): ?string
    {
        return $this->Video['Description'] ?? null;
    }
}