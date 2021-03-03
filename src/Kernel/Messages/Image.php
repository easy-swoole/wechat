<?php


namespace EasySwoole\WeChat\Kernel\Messages;

/**
 * Class Image
 * @property string $media_id
 * @package EasySwoole\WeChat\Kernel\Messages
 */
class Image extends Media
{
    protected $type = Message::IMAGE;
}
