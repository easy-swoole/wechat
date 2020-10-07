<?php


namespace EasySwoole\WeChat\Kernel\Contracts;


interface MessageInterface
{
    public function getMsgType(): string;

    public function getMsgId(): ?int;

    public function getToUserName(): ?string;

    public function getFromUserName(): ?string;

    public function getCreateTime(): ?int;

    public function transformForJsonRequest(array $appends = []): array;

    public function transformToXml(array $appends = []): string;
}