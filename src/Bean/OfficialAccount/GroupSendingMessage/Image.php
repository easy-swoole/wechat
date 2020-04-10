<?php
/**
 * Created by PhpStorm.
 * User: EZ
 * Date: 2020/4/8
 * Time: 02:45
 */

namespace EasySwoole\WeChat\Bean\OfficialAccount\GroupSendingMessage;


use EasySwoole\Spl\SplArray;
use EasySwoole\WeChat\Bean\OfficialAccount\RequestConst;

class Image extends RequestedReplyMsg
{
    protected $filter  = [];
    protected $images  = [];
    protected $msgtype = RequestConst::MSG_TYPE_IMAGE;

    public function buildMessage() : SplArray
    {
        $data = $this->toArray(null, Image::FILTER_NOT_NULL);

        return new SplArray($data);
    }

    /**
     * @param array $mediaId
     *
     * @return Image
     */
    public function setMediaIds(array $mediaId) : Image
    {
        $this->images['media_ids'] = $mediaId;

        return $this;
    }

    /**
     * @return null|array
     */
    public function getMediaIds() : ?array
    {
        return $this->images['media_ids'] ?? null;
    }

    /**
     * @param string $recommend
     *
     * @return Image
     */
    public function setRecommend(string $recommend) : Image
    {
        $this->images['recommend'] = $recommend;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getRecommend() : ?string
    {
        return $this->images['recommend'] ?? null;
    }

    /**
     * @param int $needOpenComment
     *
     * @return Image
     */
    public function setNeedOpenComment(int $needOpenComment) : Image
    {
        $this->images['need_open_comment'] = $needOpenComment;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getNeedOpenComment() : ?int
    {
        return $this->images['need_open_comment'] ?? null;
    }

    /**
     * @param int $onlyFansCanComment
     *
     * @return Image
     */
    public function setOnlyFansCanComment(int $onlyFansCanComment) : Image
    {
        $this->images['only_fans_can_comment'] = $onlyFansCanComment;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getOnlyFansCanComment() : ?int
    {
        return $this->images['only_fans_can_comment'] ?? null;
    }

}