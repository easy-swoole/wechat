<?php
/**
 * Created by PhpStorm.
 * Author: 黄龙辉 XueSi
 * Email: 1592328848@qq.com
 * Date: 2022/3/10 10:00:54
 */

namespace EasySwoole\WeChat\Tests\MiniProgram\PhoneNumber;

use EasySwoole\WeChat\Kernel\ServiceContainer;
use EasySwoole\WeChat\MiniProgram\PhoneNumber\Client;
use EasySwoole\WeChat\Tests\Mock\Message\Status;
use EasySwoole\WeChat\Tests\TestCase;
use Psr\Http\Message\ServerRequestInterface;

class ClientTest extends TestCase
{
    public function testGetUserPhoneNumber()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('getUserPhoneNumber.json'));

        $app = $this->mockAccessToken(new ServiceContainer([
            'appId' => 'mock_appid',
            'appSecret' => 'mock_secret'
        ]));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/wxa/business/getuserphonenumber', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);
        $ret = $client->getUserPhoneNumber('e31968a7f94cc5ee25fafc2aef2773f0bb8c3937b22520eb8ee345274d00c144');
        $this->assertIsArray($ret);
        $this->assertSame(json_decode($this->readMockResponseJson('getUserPhoneNumber.json'), true), $ret);
    }

    private function readMockResponseJson($filename)
    {
        return file_get_contents(__DIR__ . '/mock_data/' . $filename);
    }
}