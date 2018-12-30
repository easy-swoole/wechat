<?php
/**
 * Created by PhpStorm.
 * User: yf
 * Date: 2018-12-30
 * Time: 00:17
 */

namespace EasySwoole\WeChat\Bean\OfficialAccount;


use EasySwoole\Spl\SplBean;

class RequestedReplyMsg extends SplBean
{
    /*
     * 被动消息
     */

    protected $ToUserName;
    protected $FromUserName;
    protected $CreateTime;
    protected $MsgType;
    protected $Content;
    protected $MediaId;
    protected $Title;
    protected $Description;
    protected $MusicURL;
    protected $HQMusicUrl;
    protected $ThumbMediaId;
    protected $ArticleCount;
    protected $Articles;
    protected $PicUrl;
    protected $Url;

    /**
     * @return mixed
     */
    public function getToUserName()
    {
        return $this->ToUserName;
    }

    /**
     * @param mixed $ToUserName
     */
    public function setToUserName($ToUserName): void
    {
        $this->ToUserName = $ToUserName;
    }

    /**
     * @return mixed
     */
    public function getFromUserName()
    {
        return $this->FromUserName;
    }

    /**
     * @param mixed $FromUserName
     */
    public function setFromUserName($FromUserName): void
    {
        $this->FromUserName = $FromUserName;
    }

    /**
     * @return mixed
     */
    public function getCreateTime()
    {
        return $this->CreateTime;
    }

    /**
     * @param mixed $CreateTime
     */
    public function setCreateTime($CreateTime): void
    {
        $this->CreateTime = $CreateTime;
    }

    /**
     * @return mixed
     */
    public function getMsgType()
    {
        return $this->MsgType;
    }

    /**
     * @param mixed $MsgType
     */
    public function setMsgType($MsgType): void
    {
        $this->MsgType = $MsgType;
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->Content;
    }

    /**
     * @param mixed $Content
     */
    public function setContent($Content): void
    {
        $this->Content = $Content;
    }

    /**
     * @return mixed
     */
    public function getMediaId()
    {
        return $this->MediaId;
    }

    /**
     * @param mixed $MediaId
     */
    public function setMediaId($MediaId): void
    {
        $this->MediaId = $MediaId;
    }

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->Title;
    }

    /**
     * @param mixed $Title
     */
    public function setTitle($Title): void
    {
        $this->Title = $Title;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->Description;
    }

    /**
     * @param mixed $Description
     */
    public function setDescription($Description): void
    {
        $this->Description = $Description;
    }

    /**
     * @return mixed
     */
    public function getMusicURL()
    {
        return $this->MusicURL;
    }

    /**
     * @param mixed $MusicURL
     */
    public function setMusicURL($MusicURL): void
    {
        $this->MusicURL = $MusicURL;
    }

    /**
     * @return mixed
     */
    public function getHQMusicUrl()
    {
        return $this->HQMusicUrl;
    }

    /**
     * @param mixed $HQMusicUrl
     */
    public function setHQMusicUrl($HQMusicUrl): void
    {
        $this->HQMusicUrl = $HQMusicUrl;
    }

    /**
     * @return mixed
     */
    public function getThumbMediaId()
    {
        return $this->ThumbMediaId;
    }

    /**
     * @param mixed $ThumbMediaId
     */
    public function setThumbMediaId($ThumbMediaId): void
    {
        $this->ThumbMediaId = $ThumbMediaId;
    }

    /**
     * @return mixed
     */
    public function getArticleCount()
    {
        return $this->ArticleCount;
    }

    /**
     * @param mixed $ArticleCount
     */
    public function setArticleCount($ArticleCount): void
    {
        $this->ArticleCount = $ArticleCount;
    }

    /**
     * @return mixed
     */
    public function getArticles()
    {
        return $this->Articles;
    }

    /**
     * @param mixed $Articles
     */
    public function setArticles($Articles): void
    {
        $this->Articles = $Articles;
    }

    /**
     * @return mixed
     */
    public function getPicUrl()
    {
        return $this->PicUrl;
    }

    /**
     * @param mixed $PicUrl
     */
    public function setPicUrl($PicUrl): void
    {
        $this->PicUrl = $PicUrl;
    }

    /**
     * @return mixed
     */
    public function getUrl()
    {
        return $this->Url;
    }

    /**
     * @param mixed $Url
     */
    public function setUrl($Url): void
    {
        $this->Url = $Url;
    }

    protected function initialize(): void
    {
        if(empty($this->CreateTime)){
           $this->CreateTime = time();
        }
    }
}