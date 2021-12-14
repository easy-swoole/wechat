<?php
/**
 * Created by PhpStorm.
 * User: XueSi
 * Email: <1592328848@qq.com>
 * Date: 2021/12/01
 * Time: 20:13
 */

namespace EasySwoole\WeChat\Tests\MiniProgram\ContentSecurity;

use EasySwoole\WeChat\Kernel\ServiceContainer;
use EasySwoole\WeChat\MiniProgram\ContentSecurity\Client;
use EasySwoole\WeChat\Tests\Mock\Message\Status;
use EasySwoole\WeChat\Tests\TestCase;
use Psr\Http\Message\ServerRequestInterface;

class ClientTest extends TestCase
{
    public function testCheckImg()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('checkImg.json'));

        $app = $this->mockAccessToken(new ServiceContainer([
            'appId' => 'mock_appid',
            'appSecret' => 'mock_secret'
        ]));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/wxa/img_sec_check', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        $ret = $client->checkImg(__DIR__ . '/mock_data/mock_image.jpg');

        $this->assertIsArray($ret);

        $this->assertSame(json_decode($this->readMockResponseJson('checkImg.json'), true), $ret);
    }

    public function testCheckMediaAsync()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('checkMediaAsync.json'));

        $app = $this->mockAccessToken(new ServiceContainer([
            'appId' => 'mock_appid',
            'appSecret' => 'mock_secret'
        ]));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/wxa/media_check_async', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        $mediaUrl = 'https://developers.weixin.qq.com/miniprogram/assets/images/head_global_z_@all.png';
        $mediaType = 2;
        $openId = 'OPENID';
        $scene = 1;

        $ret = $client->checkMediaAsync($mediaUrl, $mediaType, $openId, $scene);

        $this->assertIsArray($ret);

        $this->assertSame(json_decode($this->readMockResponseJson('checkMediaAsync.json'), true), $ret);
    }

    public function testCheckMsg()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('checkMsg.json'));

        $app = $this->mockAccessToken(new ServiceContainer([
            'appId' => 'mock_appid',
            'appSecret' => 'mock_secret'
        ]));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/wxa/msg_sec_check', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        $ret = $client->checkMsg([
            'openid' => 'OPENID',
            'scene' => 1,
            'content' => 'hello world!'
        ]);

        $this->assertIsArray($ret);

        $this->assertSame(json_decode($this->readMockResponseJson('checkMsg.json'), true), $ret);
    }

    private function readMockResponseJson($filename)
    {
        return file_get_contents(__DIR__ . '/mock_data/' . $filename);
    }
}
