<?php

namespace EasySwoole\WeChat\Tests\Mock\Message;


use Psr\Http\Message\ServerRequestInterface;

class ServerRequest extends Request implements ServerRequestInterface
{
    private $attributes = [];
    private $cookieParams = [];
    private $parsedBody = [];
    private $queryParams = [];
    private $serverParams;
    private $uploadedFiles = [];

    public function __construct($method = 'GET', Uri $uri = null, array $headers = null, Stream $body = null, $protocolVersion = '1.1',$serverParams = array())
    {
        $this->serverParams = $serverParams;
        parent::__construct($method, $uri, $headers, $body, $protocolVersion);
        $query = [];
        foreach (explode("&", $this->getUri()->getQuery()) as $group) {
            if (!empty($group)) {
                $group = explode("=", $group);
                $query[$group[0]] = $group[1];
            }
        }
        $this->withQueryParams($query);
    }

    public function getServerParams()
    {
        return $this->serverParams;
    }

    public function getCookieParams($name = null)
    {
        if($name === null){
            return $this->cookieParams;
        }else{
            if(isset($this->cookieParams[$name])){
                return $this->cookieParams[$name];
            }else{
                return null;
            }
        }

    }

    public function withCookieParams(array $cookies)
    {
        $this->cookieParams = $cookies;
        return $this;
    }

    public function getQueryParams()
    {
        return $this->queryParams;
    }

    public function getQueryParam($name){
        $data = $this->getQueryParams();
        if(isset($data[$name])){
            return $data[$name];
        }else{
            return null;
        }
    }

    public function withQueryParams(array $query)
    {
        $this->queryParams = $query;
        return $this;
    }

    public function getUploadedFiles()
    {
        return $this->uploadedFiles;
    }

    /*
     * 适配二维数组方式上传
     */
    public function getUploadedFile($name)
    {
        if(isset($this->uploadedFiles[$name])){
            return $this->uploadedFiles[$name];
        }else{
            return null;
        }
    }

    /**
     * @param array $uploadedFiles must be array of UploadFile Instance
     * @return ServerRequest
     */
    public function withUploadedFiles(array $uploadedFiles)
    {
        $this->uploadedFiles = $uploadedFiles;
        return $this;
    }

    public function getParsedBody($name = null)
    {
        if($name !== null){
            if(isset($this->parsedBody[$name])){
                return $this->parsedBody[$name];
            }else{
                return null;
            }
        }else{
            return $this->parsedBody;
        }
    }

    public function withParsedBody($data)
    {
        $this->parsedBody = $data;
        return $this;
    }

    public function getAttributes()
    {
        return $this->attributes;
    }

    public function getAttribute($name, $default = null)
    {
        if (false === array_key_exists($name, $this->attributes)) {
            return $default;
        }
        return $this->attributes[$name];
    }

    public function withAttribute($name, $value)
    {
        $this->attributes[$name] = $value;
        return $this;
    }

    public function withoutAttribute($name)
    {
        if (false === array_key_exists($name, $this->attributes)) {
            return $this;
        }
        unset($this->attributes[$name]);
        return $this;
    }
}