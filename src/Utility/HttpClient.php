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

    static function postFileForJson(string $url, PostFile $file, array $form = null, int $timeout = 30)
    {
        $client = self::client($url);
        if ($file->getPath()) {
            // 兼容 swoole 4.2.12 版本以下 默认值识别错误的问题
            if (version_compare(phpversion('swoole'), '4.2.12', '<')) {
                $client->addFile($file->getPath(), $file->getName());
            } else {
                $client->addFile($file->getPath(), $file->getName(), $file->getMimeType(), $file->getFilename(), $file->getOffset(), $file->getLength());
            }
        } else {
            $client->addData($file->getData(), $file->getName(), $file->getMimeType(), $file->getFilename());
        }

        if (!is_null($form)) {
            $client->setTimeout($timeout);
            foreach ($form as $name => $value) {
                $client->addData($value, $name);
            }
        }
        return self::parserJson($client->exec());
    }

    static function getForJson(string $url):array
    {
        return self::parserJson(self::get($url));
    }

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