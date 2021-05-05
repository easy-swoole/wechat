<?php
/**
 * Created by PhpStorm.
 * User: XueSi
 * Email: <1592328848@qq.com>
 * Date: 2021/5/5
 * Time: 19:21
 */

namespace EasySwoole\WeChat\Tests\MiniProgram\Live;

use EasySwoole\WeChat\Kernel\ServiceContainer;
use EasySwoole\WeChat\Tests\Mock\Message\Status;
use EasySwoole\WeChat\Tests\TestCase;
use Psr\Http\Message\ServerRequestInterface;
use EasySwoole\WeChat\MiniProgram\Live\Client;


class ClientTest extends TestCase
{
    public function testGetRooms()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('getRooms.json'));

        $app = $this->mockAccessToken(new ServiceContainer([
            'appId' => 'mock_appid',
            'appSecret' => 'mock_secret'
        ]));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/wxa/business/getliveinfo', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        $this->assertIsArray($client->getRooms(0, 10));

        $this->assertSame(json_decode($this->readMockResponseJson('getRooms.json'), true), $client->getRooms(0, 10));
    }

    public function testGetPlaybacks()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('getPlaybacks.json'));

        $app = $this->mockAccessToken(new ServiceContainer([
            'appId' => 'mock_appid',
            'appSecret' => 'mock_secret'
        ]));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/wxa/business/getliveinfo', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        $this->assertIsArray($client->getPlaybacks(354, 0, 10));

        $this->assertSame(json_decode($this->readMockResponseJson('getPlaybacks.json'), true), $client->getPlaybacks(354, 0, 10));
    }

    private function readMockResponseJson($filename)
    {
        return file_get_contents(__DIR__ . '/mock_data/' . $filename);
    }
}