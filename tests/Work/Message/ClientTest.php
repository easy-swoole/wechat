<?php
/**
 * Created by PhpStorm.
 * User: XueSi
 * Email: <1592328848@qq.com>
 * Date: 2021/4/25
 * Time: 1:52
 */

namespace EasySwoole\WeChat\Tests\Work\Message;


use EasySwoole\WeChat\Kernel\ServiceContainer;
use EasySwoole\WeChat\Tests\Mock\Message\Status;
use EasySwoole\WeChat\Tests\TestCase;
use EasySwoole\WeChat\Work\Message\Client;
use EasySwoole\WeChat\Work\Message\Messenger;
use Psr\Http\Message\ServerRequestInterface;

class ClientTest extends TestCase
{
    public function testMessage()
    {
        $response = $this->buildResponse(Status::CODE_OK, '{"errcode":0,"errmsg":"ok"}');

        $app = $this->mockAccessToken(new ServiceContainer([
            'corpId' => 'mock_corpId',
            'corpSecret' => 'mock_corpSecret',
            'agentId' => 'mock_agentId'
        ]));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {

        }, $response, $app);

        $client = new Client($app);

        $this->assertInstanceOf(Messenger::class, $client->message('hello'));
    }

    public function testSend()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('send.json'));

        $app = $this->mockAccessToken(new ServiceContainer([
            'corpId' => 'mock_corpId',
            'corpSecret' => 'mock_corpSecret'
        ]));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/message/send', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        $message = [
            'foo' => 'bar'
        ];

        $this->assertIsArray($client->send($message));

        $this->assertSame(json_decode($this->readMockResponseJson('send.json'), true), $client->send($message));
    }

    protected function readMockResponseJson(string $filename): string
    {
        return file_get_contents(__DIR__ . '/mock_data/' . $filename);
    }
}