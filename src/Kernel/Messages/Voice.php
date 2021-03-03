<?php


namespace EasySwoole\WeChat\Kernel\Messages;

/**
 * Class Voice
 * @property string $media_id
 * @package EasySwoole\WeChat\Kernel\Messages
 */
class Voice extends Media
{
    protected $type = Message::VOICE;
}
