<?php


namespace EasySwoole\WeChat\Kernel\Exceptions;


use Psr\Http\Message\ResponseInterface;
use Throwable;

class HttpException extends Exception
{
    protected $response;

    public function __construct(string $message = "", ResponseInterface $response = null, $code = 0, Throwable $previous = null)
    {
        parent::__construct($message, $code, $previous);
        $this->response = $response;
    }

    public function getResponse():?ResponseInterface
    {
        return $this->response;
    }
}