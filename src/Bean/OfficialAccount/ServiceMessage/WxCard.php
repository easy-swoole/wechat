<?php
/**
 * Created by PhpStorm.
 * User: EZ
 * Date: 2020/4/2
 * Time: 23:27
 */

namespace EasySwoole\WeChat\Bean\OfficialAccount\ServiceMessage;


use EasySwoole\Spl\SplArray;
use EasySwoole\WeChat\Bean\OfficialAccount\RequestConst;

class WxCard extends RequestedReplyMsg
{
    protected $wxcard  = [];
    protected $msgtype = RequestConst::MSG_TYPE_WXCARD;

    /**
     * @return SplArray
     */
    public function buildMessage() : SplArray
    {
        $data = $this->toArray(null, WxCard::FILTER_NOT_NULL);

        return new SplArray($data);
    }

    /**
     * @return mixed
     */
    public function getCardId() : ?string
    {
        return $this->wxcard['card_id'] ?? null;
    }

    /**
     * @param mixed $cardId
     */
    public function setCardId(string $cardId) : void
    {
        $this->wxcard['card_id'] = $cardId;
    }
}