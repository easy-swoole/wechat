<?php
/**
 * Created by PhpStorm.
 * User: EZ
 * Date: 2020/4/8
 * Time: 00:06
 */

namespace EasySwoole\WeChat\Bean\OfficialAccount\GroupSendingMessage;


use EasySwoole\Spl\SplArray;
use EasySwoole\WeChat\Bean\OfficialAccount\RequestConst;

class News extends RequestedReplyMsg
{
    protected $mpnews              = [];
    protected $send_ignore_reprint = 0;
    protected $msgtype             = RequestConst::MSG_TYPE_MPNEWS;

    public function buildMessage() : SplArray
    {
        $data = $this->toArray(null, News::FILTER_NOT_NULL);

        return new SplArray($data);
    }

    /**
     * @param int $sendIgnoreReprint
     *
     * @return News
     */
    public function setSendIgnoreReprint(int $sendIgnoreReprint) : News
    {
        $this->send_ignore_reprint = $sendIgnoreReprint;

        return $this;
    }

    /**
     * @return int|null
     */
    public function getSendIgnoreReprint() : ?int
    {
        return $this->send_ignore_reprint ?? null;
    }

}