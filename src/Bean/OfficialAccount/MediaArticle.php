<?php
/**
 * Created by PhpStorm.
 * User: runs
 * Date: 19-1-8
 * Time: 下午2:10
 */

namespace EasySwoole\WeChat\Bean\OfficialAccount;


use EasySwoole\Spl\SplBean;

/**
 * 微信图文消息
 * @package EasySwoole\WeChat\Bean\OfficialAccount
 */
class MediaArticle extends SplBean
{
    protected $title;
    protected $thumb_media_id;
    protected $author;
    protected $digest;
    protected $show_cover_pic;
    protected $content;
    protected $content_source_url;
    protected $need_open_comment;
    protected $only_fans_can_comment;

    /**
     * @return mixed
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * @param mixed $title
     */
    public function setTitle($title): void
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getThumbMediaId()
    {
        return $this->thumb_media_id;
    }

    /**
     * @param mixed $thumb_media_id
     */
    public function setThumbMediaId($thumb_media_id): void
    {
        $this->thumb_media_id = $thumb_media_id;
    }

    /**
     * @return mixed
     */
    public function getAuthor()
    {
        return $this->author;
    }

    /**
     * @param mixed $author
     */
    public function setAuthor($author): void
    {
        $this->author = $author;
    }

    /**
     * @return mixed
     */
    public function getDigest()
    {
        return $this->digest;
    }

    /**
     * @param mixed $digest
     */
    public function setDigest($digest): void
    {
        $this->digest = $digest;
    }

    /**
     * @return mixed
     */
    public function getShowCoverPic()
    {
        return $this->show_cover_pic;
    }

    /**
     * @param mixed $show_cover_pic
     */
    public function setShowCoverPic($show_cover_pic): void
    {
        $this->show_cover_pic = $show_cover_pic;
    }

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->content;
    }

    /**
     * @param mixed $content
     */
    public function setContent($content): void
    {
        $this->content = $content;
    }

    /**
     * @return mixed
     */
    public function getContentSourceUrl()
    {
        return $this->content_source_url;
    }

    /**
     * @param mixed $content_source_url
     */
    public function setContentSourceUrl($content_source_url): void
    {
        $this->content_source_url = $content_source_url;
    }

    /**
     * @return mixed
     */
    public function getNeedOpenComment()
    {
        return $this->need_open_comment;
    }

    /**
     * @param mixed $need_open_comment
     */
    public function setNeedOpenComment($need_open_comment): void
    {
        $this->need_open_comment = $need_open_comment;
    }

    /**
     * @return mixed
     */
    public function getOnlyFansCanComment()
    {
        return $this->only_fans_can_comment;
    }

    /**
     * @param mixed $only_fans_can_comment
     */
    public function setOnlyFansCanComment($only_fans_can_comment): void
    {
        $this->only_fans_can_comment = $only_fans_can_comment;
    }
}