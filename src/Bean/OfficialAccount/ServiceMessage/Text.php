<?php
/**
 * Created by PhpStorm.
 * User: EZ
 * Date: 2020/4/2
 * Time: 21:14
 */

namespace EasySwoole\WeChat\Bean\OfficialAccount\ServiceMessage;


use EasySwoole\Spl\SplArray;
use EasySwoole\WeChat\Bean\OfficialAccount\RequestConst;

class Text extends RequestedReplyMsg
{
    protected $text    = [];
    protected $msgtype = RequestConst::MSG_TYPE_TEXT;

    /**
     * @return SplArray
     */
    public function buildMessage() : SplArray
    {
        $data = $this->toArray(null, Text::FILTER_NOT_NULL);

        return new SplArray($data);
    }

    /**
     * @return mixed
     */
    public function getContent() : ?string
    {
        return $this->text['content'] ?? null;
    }

    /**
     * @param mixed $Content
     */
    public function setContent(string $content) : void
    {
        $this->text['content'] = $content;
    }
}