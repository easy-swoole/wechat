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

    static function get(string $url):Response
    {
        return self::client($url)->exec();
    }

    static function post()
    {

    }

    static function postJson($url,$data):Response
    {
        $client = self::client($url);
        $client->postJSON(json_encode($data,JSON_UNESCAPED_UNICODE|JSON_UNESCAPED_SLASHES));
        return $client->exec();
    }

    static function getForJson(string $url):array
    {
        $response = self::get($url);
        $content = $response->getBody();
        $json = json_decode($content,true);
        //解包失败认为请求出错
        if(!is_array($json)){
            $ex = new RequestError();
            $ex->setResponse($response);
            throw $ex;
        }
        return $json;
    }

    static function postJsonForJson(string $url,array $data):array
    {
        $response = self::postJson($url,$data);
        $content = $response->getBody();
        $json = json_decode($content,true);
        //解包失败认为请求出错
        if(!is_array($json)){
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