<?php


namespace EasySwoole\WeChat\Tests\Mock;


use EasySwoole\WeChat\Kernel\Contracts\ClientInterface;
use EasySwoole\WeChat\Tests\Mock\Message\ServerRequest;
use EasySwoole\WeChat\Tests\Mock\Message\Uri;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;

class MockHttpClient implements ClientInterface
{
    private $onRequest;
    private $request;
    private $response;
    private $timeout;

    public function __construct(callable $onRequest, ResponseInterface $response)
    {
        $this->onRequest = $onRequest;
        $this->response = $response;
        $this->request = new ServerRequest();
    }

    public function setTimeout(float $timeout): ClientInterface
    {
        $this->timeout = $timeout;
        return $this;
    }

    public function getTimeout(): ?float
    {
        return $this->timeout;
    }

    public function setHeaders(array $headers): ClientInterface
    {
        foreach ($headers as $name => $value) {
            $this->request->withHeader($name, $value);
        }
        return $this;
    }

    public function setMethod(string $method): ClientInterface
    {
        $this->request->withMethod($method);
        return $this;
    }

    public function setBody(StreamInterface $body): ClientInterface
    {
        $this->request->withBody($body);
        return $this;
    }

    public function addFile(string $path, string $dataName): ClientInterface
    {
        $this->request->withUploadedFiles(array_merge($this->request->getUploadedFiles(), [$dataName, $path]));
        return $this;
    }

    public function addData(string $data, string $dataName): ClientInterface
    {
        $this->request->withParsedBody([$dataName => $data]);
        return $this;
    }

    public function addStream(StreamInterface $stream, string $dataName): ClientInterface
    {
        $this->request->withUploadedFiles(array_merge($this->request->getUploadedFiles(), [$dataName, $stream]));
        return $this;
    }

    public function send(string $url): ResponseInterface
    {
        $this->request->withUri(new Uri($url));
        call_user_func($this->onRequest, $this->request);
        return $this->response;
    }

    public function getClient(): ClientInterface
    {
        return $this;
    }
}