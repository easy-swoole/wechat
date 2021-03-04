<?php


namespace EasySwoole\WeChat\Kernel\Messages;


class MiniprogramPage extends Message
{
    protected $type = Message::MINIPROGRAMPAGE_PAGE;

    /**
     * @var string[]
     */
    protected $required = [
        'thumb_media_id', 'appid', 'pagepath',
    ];
}
