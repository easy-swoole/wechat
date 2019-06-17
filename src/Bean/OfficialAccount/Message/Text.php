<?php


namespace EasySwoole\WeChat\Bean\OfficialAccount\Message;


use EasySwoole\Spl\SplArray;
use EasySwoole\WeChat\Bean\OfficialAccount\RequestConst;

class Text extends RequestedReplyMsg
{
    protected $Content;
    protected $MsgType = RequestConst::MSG_TYPE_TEXT;

    public function buildMessage(): SplArray
    {
        $data = $this->toArray(null, Text::FILTER_NOT_NULL);
        return new SplArray($data);
    }

    /**
     * @return mixed
     */
    public function getContent(): ?string
    {
        return $this->Content ?? null;
    }

    /**
     * @param mixed $Content
     */
    public function setContent(string $Content): void
    {
        $this->Content = $Content;
    }
}