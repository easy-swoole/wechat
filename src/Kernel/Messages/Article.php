<?php


namespace EasySwoole\WeChat\Kernel\Messages;


class Article extends Message
{
    /** @var string */
    protected $type = Message::MPNEWS;

    /** @var string[] */
    protected $required = [
        'thumb_media_id',
        'title',
        'content',
        'show_cover',
    ];
}