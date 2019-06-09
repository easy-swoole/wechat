<?php
/**
 * Created by PhpStorm.
 * User: yf
 * Date: 2018-12-29
 * Time: 22:32
 */

namespace EasySwoole\WeChat\Utility;

use EasySwoole\HttpClient\Bean\Response;
use EasySwoole\HttpClient\Exception\InvalidUrl;
use EasySwoole\HttpClient\HttpClient as Client;
use EasySwoole\WeChat\Exception\RequestError;

/**
 * 协程客户端封装
 * Class HttpClient
 * @package EasySwoole\WeChat\Utility
 */
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

    /**
     * 发起一次Get请求并获得返回
     * @param string $url
     * @return Response
     * @throws InvalidUrl
     */
    static function get(string $url): Response
    {
        return self::client($url)->getRequest();
    }


    /**
     * 返回内容进行Json解析
     * @param string $url
     * @return array
     * @throws InvalidUrl
     * @throws RequestError
     */
    static function getForJson(string $url): array
    {
        return self::parserJson(self::get($url));
    }

    /**
     * 发起一次POST请求
     * @param string $url 发起请求的链接
     * @param string|array $data 可以传入字符串和数组
     * @param int|null $timeout 如果传入则使用独立超时设置
     * @return Response
     * @throws InvalidUrl
     */
    static function post(string $url, $data = null, int $timeout = null)
    {
        $client = self::client($url);

        // 定义了独立的超时则使用独立设置
        if (!is_null($timeout) && $timeout > self::$TIMEOUT) {
            $client->setTimeout($timeout);
        }

        return $client->postRequest($data);
    }

    /**
     * 返回内容进行Json解析
     * @param string $url 发起请求的链接
     * @param string|array $data 可以传入字符串和数组
     * @param int|null $timeout 如果传入则使用独立超时设置
     * @return array
     * @throws InvalidUrl
     * @throws RequestError
     */
    static function postForJson(string $url, $data, int $timeout = null)
    {
        return self::parserJson(self::post($url, $data, $timeout));
    }

    /**
     * 发送一次包体为JSON的POST
     * @param string $url 发起请求的链接
     * @param string|array $data 可以传入字符串和数组 数组会自动编码为JSON
     * @return Response
     * @throws InvalidUrl
     */
    static function postJson(string $url, $data): Response
    {

        $client = self::client($url);

        // 传入的数据需要提前编码为Json
        if (is_array($data)) {
            $data = json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        }

        return $client->postJsonRequest($data);
    }

    /**
     * 发送一次包体为JSON的POST
     * 返回内容进行Json解析
     * @param string $url 发起请求的链接
     * @param string|array $data 可以传入字符串和数组 数组会自动编码为JSON
     * @return array
     * @throws InvalidUrl
     * @throws RequestError
     */
    static function postJsonForJson(string $url, array $data): array
    {
        return self::parserJson(self::postJson($url, $data));
    }

    /**
     * 上传一个本地文件
     * @param string $url 上传URL
     * @param string $uploadFile 本地文件的路径
     * @param string $uploadName 上传的表单名称
     * @param string|null $mimeType 文件的 MIME 不传则按照扩展名判断
     * @param string|null $filename 文件的名称
     * @param int $offset 上传的偏移量
     * @param int $length 需要发送的长度
     * @param int $timeout
     * @param null $extraPostData
     * @return Response
     * @throws InvalidUrl
     */
    static function uploadFileByPath($url, string $uploadFile, string $uploadName = 'upload', string $mimeType = null, string $filename = null, int $offset = 0, int $length = 0, $timeout = 30, $extraPostData = null)
    {
        $client = self::client($url);
        $client->setTimeout($timeout);
        return $client->uploadByFileRequest($uploadFile, $uploadName, $mimeType, $filename, $offset, $length, $extraPostData);
    }

    /**
     * 以字符串为内容上传
     * @param string $url 上传URL
     * @param string $uploadFile 本地文件的路径
     * @param string $uploadName 上传的表单名称
     * @param string|null $mimeType 文件的 MIME 不传则按照扩展名判断
     * @param string|null $filename 文件的名称
     * @param int $timeout
     * @param null $extraPostData
     * @return Response
     * @throws InvalidUrl
     */
    static function uploadFileByContent($url, string $uploadFile, string $uploadName = 'upload', string $mimeType = null, string $filename = null, $timeout = 30, $extraPostData = null)
    {
        $client = self::client($url);
        $client->setTimeout($timeout);
        return $client->uploadByStringRequest($uploadFile, $uploadName, $mimeType, $filename, $extraPostData);
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

        // 解包失败认为请求出错
        if (!is_array($json)) {
            $ex = new RequestError();
            $ex->setResponse($response);
            throw $ex;
        }

        return $json;
    }

    /**
     * 获取一个协程客户端
     * @param string $url 需要请求的URL
     * @return Client 返回客户端
     * @throws InvalidUrl 链接无效抛出异常
     */
    private static function client(string $url): Client
    {
        $client = new Client($url);
        $client->setTimeout(self::$TIMEOUT);
        $client->setConnectTimeout(self::$CONNECT_TIMEOUT);
        return $client;
    }
}