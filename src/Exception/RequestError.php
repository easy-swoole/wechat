<?php
/**
 * Created by PhpStorm.
 * User: yf
 * Date: 2018-12-29
 * Time: 22:50
 */

namespace EasySwoole\WeChat\Exception;


use EasySwoole\HttpClient\Bean\Response;

class RequestError extends Exception
{
    private $response;

    /**
     * @return mixed
     */
    public function getResponse():Response
    {
        return $this->response;
    }

    /**
     * @param mixed $response
     */
    public function setResponse(Response $response): void
    {
        $this->response = $response;
    }
}