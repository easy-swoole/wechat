<?php
/**
 * Created by PhpStorm.
 * User: XueSi
 * Email: <1592328848@qq.com>
 * Date: 2021/5/10
 * Time: 23:35
 */

namespace EasySwoole\WeChat\Tests\OpenPlatform\Authorizer\MiniProgram\QrCodeJump;

use EasySwoole\WeChat\Kernel\Psr\StreamResponse;
use EasySwoole\WeChat\Tests\Mock\Message\Status;
use EasySwoole\WeChat\Tests\TestCase;
use EasySwoole\WeChat\OpenPlatform\Application;
use Psr\Http\Message\ServerRequestInterface;
use EasySwoole\WeChat\OpenPlatform\Authorizer\MiniProgram\QrCodeJump\Client;

class ClientTest extends TestCase
{
    public function testGet()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('get.json'));

        /** @var Application $component */
        $component = $this->mockAccessToken(new Application([
            'appId' => 'COMPONENT_APPID',
            'token' => 'COMPONENT_TOKEN'
        ]));

        $miniProgram = $component->miniProgram(
            'mock_app_id', 'mock_refresh_token'
        );
        $miniProgram = $this->mockAccessToken($miniProgram);

        $miniProgram = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('{}', $request->getBody()->getContents());
            $this->assertEquals('/cgi-bin/wxopen/qrcodejumpget', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $miniProgram);

        $client = new Client($miniProgram);

        $ret = $client->get();

        $this->assertIsArray($ret);

        $this->assertSame(json_decode($this->readMockResponseJson('get.json'), true), $ret);
    }

    public function testDownload()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('download.json'));

        /** @var Application $component */
        $component = $this->mockAccessToken(new Application([
            'appId' => 'COMPONENT_APPID',
            'token' => 'COMPONENT_TOKEN'
        ]));

        $miniProgram = $component->miniProgram(
            'mock_app_id', 'mock_refresh_token'
        );
        $miniProgram = $this->mockAccessToken($miniProgram);

        $miniProgram = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('{}', $request->getBody()->getContents());
            $this->assertEquals('/cgi-bin/wxopen/qrcodejumpdownload', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $miniProgram);

        $client = new Client($miniProgram);

        $ret = $client->download();

        $this->assertIsArray($ret);

        $this->assertSame(json_decode($this->readMockResponseJson('download.json'), true), $ret);
    }

    public function testAdd()
    {
        $response = $this->buildResponse(Status::CODE_OK, '{"errcode":0,"errmsg":"ok"}');

        /** @var Application $component */
        $component = $this->mockAccessToken(new Application([
            'appId' => 'COMPONENT_APPID',
            'token' => 'COMPONENT_TOKEN'
        ]));

        $miniProgram = $component->miniProgram(
            'mock_app_id', 'mock_refresh_token'
        );
        $miniProgram = $this->mockAccessToken($miniProgram);

        $miniProgram = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/wxopen/qrcodejumpadd', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $miniProgram);

        $client = new Client($miniProgram);

        $jumpData = [
            'prefix'          => 'https://weixin.qq.com/qrcodejump',
            'permit_sub_rule' => 1,
            'path'            => 'pages/index/index',
            'open_version'    => 1,
            'debug_url'       => [
                'https://weixin.qq.com/qrcodejump?a=1',
                'https://weixin.qq.com/qrcodejump?a=2'
            ],
            'is_edit'         => 0,
        ];

        $this->assertTrue($client->add($jumpData));
    }

    public function testPublish()
    {
        $response = $this->buildResponse(Status::CODE_OK, '{"errcode":0,"errmsg":"ok"}');

        /** @var Application $component */
        $component = $this->mockAccessToken(new Application([
            'appId' => 'COMPONENT_APPID',
            'token' => 'COMPONENT_TOKEN'
        ]));

        $miniProgram = $component->miniProgram(
            'mock_app_id', 'mock_refresh_token'
        );
        $miniProgram = $this->mockAccessToken($miniProgram);

        $miniProgram = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/wxopen/qrcodejumppublish', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $miniProgram);

        $client = new Client($miniProgram);

        $this->assertTrue($client->publish('https://weixin.qq.com/qrcodejump'));
    }

    public function testDelete()
    {
        $response = $this->buildResponse(Status::CODE_OK, '{"errcode":0,"errmsg":"ok"}');

        /** @var Application $component */
        $component = $this->mockAccessToken(new Application([
            'appId' => 'COMPONENT_APPID',
            'token' => 'COMPONENT_TOKEN'
        ]));

        $miniProgram = $component->miniProgram(
            'mock_app_id', 'mock_refresh_token'
        );
        $miniProgram = $this->mockAccessToken($miniProgram);

        $miniProgram = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/wxopen/qrcodejumpdelete', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $miniProgram);

        $client = new Client($miniProgram);

        $this->assertTrue($client->delete('https://weixin.qq.com/qrcodejump'));
    }

    public function testGetShortUrl()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('getShorturl.json'));

        /** @var Application $component */
        $component = $this->mockAccessToken(new Application([
            'appId' => 'COMPONENT_APPID',
            'token' => 'COMPONENT_TOKEN'
        ]));

        $miniProgram = $component->miniProgram(
            'mock_app_id', 'mock_refresh_token'
        );
        $miniProgram = $this->mockAccessToken($miniProgram);

        $miniProgram = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/shorturl', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $miniProgram);

        $client = new Client($miniProgram);

        $ret = $client->getShorturl('http://wap.koudaitong.com/v2/showcase/goods?alias=128wi9shh&spm=h56083&redirect_count=1');

        $this->assertIsArray($ret);

        $this->assertSame(json_decode($this->readMockResponseJson('getShorturl.json'), true), $ret);
    }

    public function testGetUnlimitWxCode()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('appCode.jpg'), [
            'Content-disposition' => [
                'attachment',
                'filename="appCode.jpg'
            ]
        ]);

        /** @var Application $component */
        $component = $this->mockAccessToken(new Application([
            'appId' => 'COMPONENT_APPID',
            'token' => 'COMPONENT_TOKEN'
        ]));

        $miniProgram = $component->miniProgram(
            'mock_app_id', 'mock_refresh_token'
        );
        $miniProgram = $this->mockAccessToken($miniProgram);

        $miniProgram = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/wxa/getwxacodeunlimit', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $miniProgram);

        $client = new Client($miniProgram);

        $params = [
            'scene' => 'a=1'
        ];

        $this->assertInstanceOf(StreamResponse::class, $client->getUnlimitWxCode($params));
    }

    public function testGetWxCode()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('appCode.jpg'), [
            'Content-disposition' => [
                'attachment',
                'filename="appCode.jpg'
            ]
        ]);

        /** @var Application $component */
        $component = $this->mockAccessToken(new Application([
            'appId' => 'COMPONENT_APPID',
            'token' => 'COMPONENT_TOKEN'
        ]));

        $miniProgram = $component->miniProgram(
            'mock_app_id', 'mock_refresh_token'
        );
        $miniProgram = $this->mockAccessToken($miniProgram);

        $miniProgram = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/wxa/getwxacode', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $miniProgram);

        $client = new Client($miniProgram);

        $params = [
            'path'  => 'page/index/index',
            'width' => 430,
        ];

        $this->assertInstanceOf(StreamResponse::class, $client->getWxCode($params));
    }

    public function testGetWxQrCode()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('appCode.jpg'), [
            'Content-disposition' => [
                'attachment',
                'filename="appCode.jpg'
            ]
        ]);

        /** @var Application $component */
        $component = $this->mockAccessToken(new Application([
            'appId' => 'COMPONENT_APPID',
            'token' => 'COMPONENT_TOKEN'
        ]));

        $miniProgram = $component->miniProgram(
            'mock_app_id', 'mock_refresh_token'
        );
        $miniProgram = $this->mockAccessToken($miniProgram);

        $miniProgram = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/wxaapp/createwxaqrcode', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $miniProgram);

        $client = new Client($miniProgram);

        $this->assertInstanceOf(StreamResponse::class, $client->getWxQrCode('page/index/index', 430));
    }

    protected function readMockResponseJson(string $filename): string
    {
        return file_get_contents(__DIR__ . '/mock_data/' . $filename);
    }
}
