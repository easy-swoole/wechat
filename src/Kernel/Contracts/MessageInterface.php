<?php


namespace EasySwoole\WeChat\Kernel\Contracts;


interface MessageInterface
{
    public function getType(): string;

    public function transformForJsonRequest(array $appends = []): array;

    public function transformToXml(array $appends = []): string;
}