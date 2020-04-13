<?php
/**
 * Created by PhpStorm.
 * User: EZ
 * Date: 2020/4/8
 * Time: 03:02
 */

namespace EasySwoole\WeChat\Bean\OfficialAccount\GroupSendingMessage;


use EasySwoole\Spl\SplArray;
use EasySwoole\WeChat\Bean\OfficialAccount\RequestConst;

class Video extends RequestedReplyMsg
{
    protected $title;
    protected $description;
    protected $filter  = [];
    protected $mpvideo = [];
    protected $msgtype = RequestConst::MSG_TYPE_MPVIDEO;

    public function buildMessage() : SplArray
    {
        $data = $this->toArray(null, News::FILTER_NOT_NULL);

        return new SplArray($data);
    }

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
    public function setTitle($title) : void
    {
        $this->title = $title;
    }

    /**
     * @return mixed
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * @param mixed $description
     */
    public function setDescription($description) : void
    {
        $this->description = $description;
    }

}