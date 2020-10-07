<?php


namespace EasySwoole\WeChat\Kernel\Messages;


class Text extends Message
{
    protected $MsgType = Message::TEXT;

    /** @var string */
    protected $Content;

    /**
     * @return mixed
     */
    public function getContent()
    {
        return $this->Content;
    }

    /**
     * @param mixed $Content
     */
    public function setContent($Content): void
    {
        $this->Content = $Content;
    }
}