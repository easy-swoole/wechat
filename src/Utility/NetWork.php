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
use EasySwoole\HttpClient\HttpClient;
use EasySwoole\WeChat\Bean\PostFile;
use EasySwoole\WeChat\Exception\RequestError;

/**
 * 协程客户端封装
 * Class HttpClient
 * @package EasySwoole\WeChat\Utility
 */
class NetWork
{
    /*
     * 一个应用内，基本没有必要实现不同的APP_ID 超时不同
     */
    static $TIMEOUT = 15;

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
        return (new HttpClient($url))->setTimeout(self::$TIMEOUT)->get();
    }

    /**
     * 发起一次Get请求并获得返回
     * @param string $url
     * @param array $data
     * @return Response
     * @throws InvalidUrl
     */
    static function getByArray(string $url, array $data): Response
    {
        return (new HttpClient($url))->setTimeout(self::$TIMEOUT)->setQuery($data)->get();
    }

    /**
     * 返回内容进行Json解析
     * @param string $url
     * @return array
     * @throws InvalidUrl
     * @throws RequestError
     */
    static function getForJson(string $url, array $data = []): array
    {
        if ($data) {
            return self::parserJson(self::getByArray($url, $data));
        } else {
            return self::parserJson(self::get($url));
        }
    }

    /**
     * 发起一次POST请求
     * @param string $url 发起请求的链接
     * @param string|array $data 可以传入字符串和数组
     * @param int|null $timeout 如果传入则使用独立超时设置
     * @return Response
     * @throws InvalidUrl
     */
    static function post(string $url, $data = null)
    {
        return self::postJson($url, $data);
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
    static function postForJson(string $url, $data)
    {
        return self::parserJson(self::post($url, $data));
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
        // 传入的数据需要提前编码为Json
        if (is_array($data)) {
            $data = json_encode($data, JSON_UNESCAPED_UNICODE | JSON_UNESCAPED_SLASHES);
        }

        $client = new HttpClient($url);
        $client->setTimeout(self::$TIMEOUT);
        return $client->postJson($data);
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
     * 上传URL
     *
     * @param            $url
     * @param PostFile   $postFile
     * @param array|null $extraData
     * @param int        $timeout
     * @return Response
     * @throws InvalidUrl
     */
    static function uploadFileByPath($url, PostFile $postFile, array $extraData = null, int $timeout = 30)
    {
        $client = new HttpClient($url);
        $client->setTimeout($timeout);
        $client->getClient()->addFile($postFile->getPath(), $postFile->getName(), $postFile->getMimeType(), $postFile->getFilename(), $postFile->getOffset(), $postFile->getLength());
        return $client->post($extraData);
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
}