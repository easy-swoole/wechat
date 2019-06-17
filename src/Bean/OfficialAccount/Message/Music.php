<?php


namespace EasySwoole\WeChat\Bean\OfficialAccount\Message;


use EasySwoole\Spl\SplArray;
use EasySwoole\WeChat\Bean\OfficialAccount\RequestConst;

class Music extends RequestedReplyMsg
{
    protected $Music = [];
    protected $MsgType = RequestConst::MSG_TYPE_MUSIC;

    /**
     * buildMessage
     *
     * @return SplArray
     */
    public function buildMessage(): SplArray
    {
        $data = $this->toArray(null, Music::FILTER_NOT_NULL);
        return new SplArray($data);
    }

    /**
     * setMusicData
     *
     * @param array $musicData
     * @return Music
     */
    public function setMusicData(array $musicData) : Music
    {
        $this->Music = $musicData;
        return $this;
    }

    /**
     * getMusicData
     *
     * @return array
     */
    public function getMusicData() : array
    {
        return $this->Music;
    }

    /**
     * @return string
     */
    public function getTitle(): ?string
    {
        return $this->Music['Title'] ?? null;
    }

    /**
     * setTitle
     *
     * @param string $Title
     * @return Music
     */
    public function setTitle(string $Title): Music
    {
        $this->Music['Title'] = $Title;
        return $this;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->Music['Description'] ?? null;
    }

    /**
     * setDescription
     *
     * @param string $Description
     * @return Music
     */
    public function setDescription(string $Description): Music
    {
        $this->Music['Description'] = $Description;
        return $this;
    }

    /**
     * @return string
     */
    public function getMusicURL(): ?string
    {
        return $this->Music['MusicURL'] ?? null;
    }

    /**
     * setMusicURL
     *
     * @param string $MusicURL
     * @return Music
     */
    public function setMusicURL(string $MusicURL): Music
    {
        $this->Music['MusicURL'] = $MusicURL;
        return $this;
    }

    /**
     * @return string
     */
    public function getHQMusicUrl(): ?string
    {
        return $this->Music['HQMusicUrl'] ?? null;
    }

    /**
     * setHQMusicUrl
     *
     * @param string $HQMusicUrl
     * @return Music
     */
    public function setHQMusicUrl(string $HQMusicUrl): Music
    {
        $this->Music['HQMusicUrl'] = $HQMusicUrl;
        return $this;
    }

    /**
     * @return string
     */
    public function getThumbMediaId(): ?string
    {
        return $this->Music['ThumbMediaId'] ?? null;
    }

    /**
     * setThumbMediaId
     *
     * @param string $ThumbMediaId
     * @return Music
     */
    public function setThumbMediaId(string $ThumbMediaId): Music
    {
        $this->Music['ThumbMediaId'] = $ThumbMediaId;
        return $this;
    }
}