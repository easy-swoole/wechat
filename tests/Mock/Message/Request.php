<?php

namespace EasySwoole\WeChat\Tests\Mock\Message;


use Psr\Http\Message\RequestInterface;
use Psr\Http\Message\UriInterface;

class Request extends Message implements RequestInterface
{
    private $uri;
    private $method;
    private $target;

    public function __construct($method = 'GET', Uri $uri = null, array $headers = null, Stream $body = null, $protocolVersion = '1.1')
    {
        $this->method = $method;
        if ($uri != null) {
            $this->uri = $uri;
        }else{
            $this->uri = new Uri();
        }
        parent::__construct($headers, $body, $protocolVersion);
    }

    public function getRequestTarget()
    {
        if (!empty($this->target)) {
            return $this->target;
        }
        if ($this->uri instanceof Uri) {
            $target = $this->uri->getPath();
            if ($target == '') {
                $target = '/';
            }
            if ($this->uri->getQuery() != '') {
                $target .= '?' . $this->uri->getQuery();
            }
        } else {
            $target = "/";
        }
        return $target;
    }

    public function withRequestTarget($requestTarget)
    {
        $this->target = $requestTarget;
        return $this;
    }

    public function getMethod()
    {
        return $this->method;
    }

    public function withMethod($method)
    {
        $this->method = strtoupper($method);
        return $this;
    }

    public function getUri()
    {
        if($this->uri == null){
            $this->uri = new Uri();
        }
        return $this->uri;
    }

    public function withUri(UriInterface $uri, $preserveHost = false)
    {
        if ($uri === $this->uri) {
            return $this;
        }
        $this->uri = $uri;
        if (!$preserveHost) {
            $host = $this->uri->getHost();
            if (!empty($host)) {
                if (($port = $this->uri->getPort()) !== null) {
                    $host .= ':' . $port;
                }
                if ($this->getHeader('host')) {
                    $header = $this->getHeader('host');
                } else {
                    $header = 'Host';
                }
                $this->withHeader($header, $host);
            }
        }
        return $this;
    }
}