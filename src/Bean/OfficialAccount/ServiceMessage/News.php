<?php
/**
 * Created by PhpStorm.
 * User: EZ
 * Date: 2020/4/2
 * Time: 21:33
 */

namespace EasySwoole\WeChat\Bean\OfficialAccount\ServiceMessage;


use EasySwoole\Spl\SplArray;
use EasySwoole\Spl\SplBean;
use EasySwoole\WeChat\Bean\OfficialAccount\RequestConst;

class News extends RequestedReplyMsg
{
    protected $news    = [];
    protected $mpnews  = [];
    protected $senWay  = ['touser', 'msgtype', 'news'];
    protected $msgtype = RequestConst::MSG_TYPE_NEWS;

    /**
     * @return SplArray
     */
    public function buildMessage() : SplArray
    {

        $data = $this->toArray($this->senWay, News::FILTER_NOT_NULL);

        return new SplArray($data);
    }

    /**
     * @return string
     */
    public function getTitle() : ?string
    {
        return $this->news['articles'][0]['title'] ?? null;
    }

    /**
     * @param string $title
     *
     * @return News
     */
    public function setTitle(string $title) : News
    {
        $this->news['articles'][0]['title'] = $title;

        return $this;
    }

    /**
     * @return string
     */
    public function getDescription() : string
    {
        return $this->news['articles'][0]['description'] ?? null;
    }

    /**
     * @param string $description
     *
     * @return News
     */
    public function setDescription(string $description) : News
    {
        $this->news['articles'][0]['description'] = $description;

        return $this;
    }

    /**
     * @return string
     */
    public function getUrl() : ?string
    {
        return $this->news['articles'][0]['url'] ?? null;
    }

    /**
     * @param string $newsUrl
     *
     * @return News
     */
    public function setUrl(string $newsUrl) : News
    {
        $this->news['articles'][0]['url'] = $newsUrl;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getPicUrl() : ?string
    {
        return $this->news['articles'][0]['picurl'] ?? null;
    }

    /**
     * @param string $picUrl
     *
     * @return News
     */
    public function setPicUrl(string $picUrl) : News
    {
        $this->news['articles'][0]['picurl'] = $picUrl;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getMediaId() : ?string
    {
        return $this->mpnews['media_id'] ?? null;
    }

    /**
     * @param $mediaId
     *
     * @return News
     */
    public function setMediaId($mediaId) : News
    {
        $this->senWay             = ['touser', 'msgtype', 'mpnews'];
        $this->msgtype            = RequestConst::MSG_TYPE_MPNEWS;
        $this->mpnews['media_id'] = $mediaId;

        return $this;
    }
}