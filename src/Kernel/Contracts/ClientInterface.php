<?php


namespace EasySwoole\WeChat\Kernel\Contracts;


use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

interface ClientInterface
{
    public function setTimeout(float $timeout): ClientInterface;

    public function setHeaders(array $headers): ClientInterface;

    public function setMethod(string $method): ClientInterface;

    public function setBody(StreamInterface $body): ClientInterface;

    public function addFile(string $path, string $dataName): ClientInterface;

    public function addData(string $data, string $dataName): ClientInterface;

    public function addStream(StreamInterface $stream, string $dataName): ClientInterface;

    public function send(string $url): ResponseInterface;
}