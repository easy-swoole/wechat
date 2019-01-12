<?php
/**
 * Created by PhpStorm.
 * User: yf
 * Date: 2018-12-29
 * Time: 22:32
 */

namespace EasySwoole\WeChat\Utility;
use EasySwoole\HttpClient\Bean\Response;
use EasySwoole\HttpClient\HttpClient as Client;
use EasySwoole\WeChat\Exception\RequestError;

class HttpClient
{
    /*
     * 一个应用内，基本没有必要实现不同的APP_ID 超时不同
     */
    static $CONNECT_TIMEOUT = 1;
    static $TIMEOUT = 1;

    /**
     * @param string $url
     * @return Response
     */
    static function get(string $url):Response
    {
        return self::client($url)->exec();
    }

    /**
     * @param string $url
     * @return array
     * @throws RequestError
     */
    static function getForJson(string $url):array
    {
        return self::parserJson(self::get($url));
    }

    /**
     * @param string   $url
     * @param          $data
     * @param int|null $timeout
     * @return Response
     */
    static function post(string $url, $data, int $timeout = null)
    {
        $client = self::client($url);
        if (!is_null($timeout) && $timeout > self::$TIMEOUT) {
            $client->setTimeout($timeout);
        }

        if (count($data) > 0) {
            if (count($data) === count($data, COUNT_RECURSIVE)) {
                $client->addData(...$data);
            } else {
                foreach ($data as $item) {
                    $client->addData(...$item);
                }
            }
        }

        return $client->exec();
    }

    /**
     * @param string   $url
     * @param          $data
     * @param int|null $timeout
     * @return mixed
     * @throws RequestError
     */
    static function postForJson(string $url, $data, int $timeout = null)
    {
        return self::parserJson(self::post($url, $data, $timeout));
    }

    /**
     * @param string $url
     * @param        $data
     * @return Response
     */
    static function postJson(string $url,$data):Response
    {
        $client = self::client($url);
        $client->postJSON(json_encode($data,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES));
        return $client->exec();
    }

    /**
     * @param string $url
     * @param array  $data
     * @return array
     * @throws RequestError
     */
    static function postJsonForJson(string $url,array $data):array
    {
        return self::parserJson(self::postJson($url, $data));
    }

    /**
     * 返回Json进行解析
     * @param Response $response
     * @return mixed
     * @throws RequestError
     */
    private static function parserJson(Response $response)
    {
        $content = $response->getBody();
        $json = json_decode($content, true);
        //解包失败认为请求出错
        if (!is_array($json)) {
            $ex = new RequestError();
            $ex->setResponse($response);
            throw $ex;
        }
        return $json;
    }

    private static function client(string $url):Client
    {
        $client = new Client($url);
        $client->setTimeout(self::$TIMEOUT);
        $client->setConnectTimeout(self::$CONNECT_TIMEOUT);
        return $client;
    }
}