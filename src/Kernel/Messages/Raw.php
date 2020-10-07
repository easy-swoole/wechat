<?php


namespace EasySwoole\WeChat\Kernel\Messages;


class Raw extends Message
{
    protected $MsgType = Message::RAW;
    protected $Content;

    /**
     * @return mixed
     */
    public function getContent(): string
    {
        return $this->Content ?? "";
    }

    /**
     * @param mixed $Content
     */
    public function setContent(string $Content): void
    {
        $this->Content = $Content;
    }

    public function __toString()
    {
        return $this->getContent();
    }
}