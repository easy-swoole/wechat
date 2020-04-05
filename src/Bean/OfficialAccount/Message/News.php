<?php


namespace EasySwoole\WeChat\Bean\OfficialAccount\Message;


use EasySwoole\Spl\SplArray;
use EasySwoole\WeChat\Bean\OfficialAccount\RequestConst;

class News extends RequestedReplyMsg
{
    protected $Articles = [];
    protected $ArticleCount;
    protected $MsgType = RequestConst::MSG_TYPE_NEWS;

    /**
     * buildMessage
     *
     * @return SplArray
     */
    public function buildMessage(): SplArray
    {
        $this->ArticleCount = count($this->Articles);
        $data = $this->toArray(null, News::FILTER_NOT_NULL);
        return new SplArray($data);
    }

    /**
     * setNews
     *
     * @param array $newsList
     * @return News
     */
    public function setNews(array $newsList): News
    {
        foreach ($newsList as $news) {
            $this->push($news);
        }
        return $this;
    }

    /**
     * getNews
     *
     * @return array
     */
    public function getNews(): array
    {
        return $this->Articles;
    }

    /**
     * push
     *
     * @param NewsItem $newsItem
     * @return News
     */
    public function push(NewsItem $newsItem): News
    {
        $this->Articles[] = $newsItem->toArray(null, $newsItem::FILTER_NOT_NULL);
        return $this;
    }
}