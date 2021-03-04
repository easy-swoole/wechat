<?php


namespace EasySwoole\WeChat\Kernel\Messages;


class NewsItem extends Message
{
    protected $type = Message::NEWS;

    public function toXmlArray(): array
    {
        return [
            'Title' => $this->get('title'),
            'Description' => $this->get('description'),
            'Url' => $this->get('url'),
            'PicUrl' => $this->get('image'),
        ];
    }
}
