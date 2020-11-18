<?php


namespace EasySwoole\WeChat\Kernel\Messages;


use EasySwoole\WeChat\Kernel\Contracts\MediaInterface;

class Media extends Message implements MediaInterface
{
    /** @var string */
    protected $mediaId;

    /**
     * @return string
     */
    public function getMediaId(): string
    {
        return $this->mediaId;
    }
}