<?php
/**
 * Created by PhpStorm.
 * User: EZ
 * Date: 2020/4/2
 * Time: 21:33
 */

namespace EasySwoole\WeChat\Bean\OfficialAccount\ServiceMessage;


use EasySwoole\Spl\SplArray;
use EasySwoole\WeChat\Bean\OfficialAccount\RequestConst;

class Music extends RequestedReplyMsg
{
    protected $music   = [];
    protected $msgtype = RequestConst::MSG_TYPE_MUSIC;

    /**
     * @return SplArray
     */
    public function buildMessage() : SplArray
    {
        $data = $this->toArray(null, Music::FILTER_NOT_NULL);

        return new SplArray($data);
    }

    /**
     * @return string
     */
    public function getTitle() : ?string
    {
        return $this->music['title'] ?? null;
    }

    /**
     * @param string $title
     *
     * @return Music
     */
    public function setTitle(string $title) : Music
    {
        $this->music['title'] = $title;

        return $this;
    }

    /**
     * @return string
     */
    public function getDescription() : string
    {
        return $this->music['description'] ?? null;
    }

    /**
     * @param string $description
     *
     * @return Music
     */
    public function setDescription(string $description) : Music
    {
        $this->music['description'] = $description;

        return $this;
    }

    /**
     * @return string
     */
    public function getMusicUrl() : ?string
    {
        return $this->music['musicurl'] ?? null;
    }

    /**
     * @param string $musicUrl
     *
     * @return Music
     */
    public function setMusicUrl(string $musicUrl) : Music
    {
        $this->music['musicurl'] = $musicUrl;

        return $this;
    }

    /**
     * @return string
     */
    public function getHqMusicUrl() : ?string
    {
        return $this->music['hqmusicurl'] ?? null;
    }

    /**
     * @param string $hqMusicUrl
     *
     * @return Music
     */
    public function setHqMusicUrl(string $hqMusicUrl) : Music
    {
        $this->music['hqmusicurl'] = $hqMusicUrl;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getThumbMediaId() : ?string
    {
        return $this->music['thumb_media_id'] ?? null;
    }

    /**
     * @param string $thumbMediaId
     *
     * @return Music
     */
    public function setThumbMediaId(string $thumbMediaId) : Music
    {
        $this->music['thumb_media_id'] = $thumbMediaId;

        return $this;
    }
}