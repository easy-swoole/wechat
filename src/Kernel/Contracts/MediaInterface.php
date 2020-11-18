<?php


namespace EasySwoole\WeChat\Kernel\Contracts;


interface MediaInterface extends MessageInterface
{
    /**
     * @return string
     */
    public function getMediaId(): string;
}