<?php
/**
 * Created by PhpStorm.
 * User: XueSi
 * Email: <1592328848@qq.com>
 * Date: 2021/4/24
 * Time: 17:20
 */

namespace EasySwoole\WeChat\Tests\Work\Base;


use EasySwoole\WeChat\Kernel\ServiceContainer;
use EasySwoole\WeChat\Tests\Mock\Message\Status;
use EasySwoole\WeChat\Tests\TestCase;
use EasySwoole\WeChat\Work\Base\Client;
use Psr\Http\Message\ServerRequestInterface;


class ClientTest extends TestCase
{
    public function testGetCallbackIp()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('getCallbackIp.json'));
        $app = $this->mockAccessToken(new ServiceContainer([
            'corpId' => 'mock_corpId',
            'corpSecret' => 'mock_corpSecret',
        ]));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('GET', $request->getMethod());
            $this->assertEquals('/cgi-bin/getcallbackip', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);
        $this->assertIsArray($client->getCallbackIp());
        $this->assertSame(json_decode($this->readMockResponseJson('getCallbackIp.json'), true), $client->getCallbackIp());
    }

    protected function readMockResponseJson(string $filename): string
    {
        return file_get_contents(__DIR__ . '/mock_data/' . $filename);
    }
}