<?php
/**
 * Created by PhpStorm.
 * User: EZ
 * Date: 2020/4/8
 * Time: 03:07
 */

namespace EasySwoole\WeChat\Bean\OfficialAccount\GroupSendingMessage;


use EasySwoole\Spl\SplArray;
use EasySwoole\WeChat\Bean\OfficialAccount\RequestConst;

class WxCard extends RequestedReplyMsg
{
    protected $filter  = [];
    protected $wxcard  = [];
    protected $msgtype = RequestConst::MSG_TYPE_WXCARD;

    public function buildMessage() : SplArray
    {
        $data = $this->toArray(null, News::FILTER_NOT_NULL);

        return new SplArray($data);
    }

    /**
     * @param string $cardId
     *
     * @return WxCard
     */
    public function setCardId(string $cardId) : WxCard
    {
        $this->wxcard['card_id'] = $cardId;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getCardId() : ?string
    {
        return $this->wxcard['card_id'] ?? null;
    }

}