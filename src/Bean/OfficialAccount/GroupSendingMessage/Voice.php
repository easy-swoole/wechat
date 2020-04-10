<?php
/**
 * Created by PhpStorm.
 * User: EZ
 * Date: 2020/4/8
 * Time: 02:43
 */

namespace EasySwoole\WeChat\Bean\OfficialAccount\GroupSendingMessage;


use EasySwoole\Spl\SplArray;
use EasySwoole\WeChat\Bean\OfficialAccount\RequestConst;

class Voice extends RequestedReplyMsg
{
    protected $filter  = [];
    protected $voice   = [];
    protected $msgtype = RequestConst::MSG_TYPE_VOICE;

    public function buildMessage() : SplArray
    {
        $data = $this->toArray(null, News::FILTER_NOT_NULL);

        return new SplArray($data);
    }

}