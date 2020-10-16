<?php


namespace EasySwoole\WeChat\Tests;


use EasySwoole\WeChat\Kernel\Contracts\ClientInterface;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

class MockHttpClient implements ClientInterface
{
    private $onRequest;
    private $request;
    private $response;

    public function __construct(callable $onRequest, ResponseInterface $response)
    {
        $this->onRequest = $onRequest;
        $this->response = $response;
        $this->request = new MockRequest();
    }

    public function setTimeout(float $timeout): ClientInterface
    {
        $this->request->setTimeout($timeout);
        return $this;
    }

    public function setHeaders(array $headers): ClientInterface
    {
        $this->request->setHeaders($headers);
        return $this;
    }

    public function setMethod(string $method): ClientInterface
    {
        $this->request->setMethod($method);
        return $this;
    }

    public function setBody(StreamInterface $body): ClientInterface
    {
        $this->request->setBody($body);
        return $this;
    }

    public function addFile(string $path, string $dataName): ClientInterface
    {
        $this->request->addFiles($path, $dataName);
        return $this;
    }

    public function addStream(StreamInterface $stream, string $dataName): ClientInterface
    {
        $this->request->addFiles($stream, $dataName);
        return $this;
    }

    public function send(string $url): ResponseInterface
    {
        $this->request->setUrI($url);
        call_user_func($this->onRequest, $this->request);
        return $this->response;
    }

    public function getClient(): ClientInterface
    {
        return $this;
    }
}