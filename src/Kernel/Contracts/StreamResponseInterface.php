<?php


namespace EasySwoole\WeChat\Kernel\Contracts;


use Psr\Http\Message\StreamInterface;

interface StreamResponseInterface
{
    public function save(string $directory, string $filename = '', bool $appendSuffix = true): string;

    public function saveAs(string $directory, string $filename, bool $appendSuffix = true): string;

    public function getStream(): StreamInterface;
}