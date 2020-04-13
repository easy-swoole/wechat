<?php
/**
 * Created by PhpStorm.
 * User: EZ
 * Date: 2020/4/8
 * Time: 02:33
 */


namespace EasySwoole\WeChat\Bean\OfficialAccount\GroupSendingMessage;


use EasySwoole\Spl\SplArray;
use EasySwoole\WeChat\Bean\OfficialAccount\RequestConst;

class Text extends RequestedReplyMsg
{
    protected $text    = [];
    protected $msgtype = RequestConst::MSG_TYPE_TEXT;

    public function buildMessage() : SplArray
    {
        $data = $this->toArray(null, Text::FILTER_NOT_NULL);

        return new SplArray($data);
    }

    /**
     * @param string $content
     *
     * @return Text
     */
    public function setContent(string $content) : Text
    {
        $this->text['content'] = $content;

        return $this;
    }

    /**
     * @return null|string
     */
    public function getContent() : ?string
    {
        return $this->text['content'] ?? null;
    }


}