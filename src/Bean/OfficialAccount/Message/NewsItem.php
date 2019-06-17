<?php


namespace EasySwoole\WeChat\Bean\OfficialAccount\Message;


use EasySwoole\Spl\SplBean;

class NewsItem extends SplBean
{
    protected $Title;
    protected $Description;
    protected $PicUrl;
    protected $Url;

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
}