<?php


namespace EasySwoole\WeChat\Kernel\Contracts;


interface RequestMessage extends MessageInterface
{
    public function getId(): ?int;

    public function getToUserName(): ?string;

    public function getFromUserName(): ?string;

    public function getCreateTime(): ?int;
}