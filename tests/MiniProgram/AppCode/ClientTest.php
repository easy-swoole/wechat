<?php
/**
 * Created by PhpStorm.
 * User: XueSi
 * Email: <1592328848@qq.com>
 * Date: 2021/5/5
 * Time: 14:45
 */

namespace EasySwoole\WeChat\Tests\MiniProgram\AppCode;


use EasySwoole\WeChat\Kernel\Psr\StreamResponse;
use EasySwoole\WeChat\Kernel\ServiceContainer;
use EasySwoole\WeChat\Tests\Mock\Message\Status;
use EasySwoole\WeChat\Tests\TestCase;
use Psr\Http\Message\ServerRequestInterface;
use EasySwoole\WeChat\MiniProgram\AppCode\Client;

class ClientTest extends TestCase
{
    public function testCreateQrCode()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('appCode.jpg'), [
            'Content-disposition' => [
                'attachment',
                'filename="appCode.jpg'
            ]
        ]);

        $app = $this->mockAccessToken(new ServiceContainer([
            'appId' => 'mock_appid',
            'appSecret' => 'mock_secret'
        ]));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/wxaapp/createwxaqrcode', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        $this->assertInstanceOf(StreamResponse::class, $client->getQrCode('mock_path'));
    }

    public function testGetAppCode()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('appCode.jpg'), [
            'Content-disposition' => [
                'attachment',
                'filename="appCode.jpg'
            ]
        ]);

        $app = $this->mockAccessToken(new ServiceContainer([
            'appId' => 'mock_appid',
            'appSecret' => 'mock_secret'
        ]));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/wxa/getwxacode', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        $this->assertInstanceOf(StreamResponse::class, $client->get('page/index/index', [
            'width' => 430
        ]));
    }

    public function testGetAppCodeUnlimit()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('appCode.jpg'), [
            'Content-disposition' => [
                'attachment',
                'filename="appCode.jpg'
            ]
        ]);

        $app = $this->mockAccessToken(new ServiceContainer([
            'appId' => 'mock_appid',
            'appSecret' => 'mock_secret'
        ]));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/wxa/getwxacodeunlimit', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        $this->assertInstanceOf(StreamResponse::class, $client->getUnLimit('mock_scene', [
            'page' => '/app/pages/hello',
        ]));
    }

    private function readMockResponseJson($filename)
    {
        return file_get_contents(__DIR__ . '/mock_data/' . $filename);
    }
}