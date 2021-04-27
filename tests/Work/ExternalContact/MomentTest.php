<?php
/**
 * Created by PhpStorm.
 * User: XueSi
 * Email: <1592328848@qq.com>
 * Date: 2021/4/24
 * Time: 22:20
 */

namespace EasySwoole\WeChat\Tests\Work\ExternalContact;


use EasySwoole\WeChat\Kernel\ServiceContainer;
use EasySwoole\WeChat\Tests\Mock\Message\Status;
use EasySwoole\WeChat\Tests\TestCase;
use EasySwoole\WeChat\Work\ExternalContact\MomentClient;
use Psr\Http\Message\ServerRequestInterface;

class MomentTest extends TestCase
{
    public function testList()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('list.json'));
        $app = $this->mockAccessToken(new ServiceContainer([
            'corpId' => 'mock_corpId',
            'corpSecret' => 'mock_corpSecret',
        ]));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/externalcontact/get_moment_list', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new MomentClient($app);

        $params = [
            'start_time' => 1605000000,
            'end_time' => 1605172726,
            'creator' => 'zhangsan',
            'filter_type' => 1,
            'cursor' => 'CURSOR',
            'limit' => 10,
        ];

        $this->assertIsArray($client->list($params));

        $this->assertSame(json_decode($this->readMockResponseJson('list.json'), true), $client->list($params));
    }

    public function testTask()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('getTasks.json'));
        $app = $this->mockAccessToken(new ServiceContainer([
            'corpId' => 'mock_corpId',
            'corpSecret' => 'mock_corpSecret',
        ]));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/externalcontact/get_moment_task', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new MomentClient($app);

        $this->assertIsArray($client->getTasks('momxxx', 'CURSOR', 10));

        $this->assertSame(json_decode($this->readMockResponseJson('getTasks.json'), true), $client->getTasks('momxxx', 'CURSOR', 10));
    }

    public function testCustomers(): void
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('getCustomers.json'));
        $app = $this->mockAccessToken(new ServiceContainer([
            'corpId' => 'mock_corpId',
            'corpSecret' => 'mock_corpSecret',
        ]));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/externalcontact/get_moment_customer_list', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new MomentClient($app);

        $this->assertIsArray($client->getCustomers('momxxx', 'xxx', 'CURSOR', 10));

        $this->assertSame(json_decode($this->readMockResponseJson('getCustomers.json'), true), $client->getCustomers('momxxx', 'xxx', 'CURSOR', 10));
    }

    public function testSendResult(): void
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('getSendResult.json'));
        $app = $this->mockAccessToken(new ServiceContainer([
            'corpId' => 'mock_corpId',
            'corpSecret' => 'mock_corpSecret',
        ]));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/externalcontact/get_moment_send_result', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new MomentClient($app);

        $this->assertIsArray($client->getSendResult('momxxx', 'xxx', 'CURSOR', 100));

        $this->assertSame(json_decode($this->readMockResponseJson('getSendResult.json'), true), $client->getSendResult('momxxx', 'xxx', 'CURSOR', 100));
    }

    public function testComments(): void
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('getComments.json'));
        $app = $this->mockAccessToken(new ServiceContainer([
            'corpId' => 'mock_corpId',
            'corpSecret' => 'mock_corpSecret',
        ]));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/externalcontact/get_moment_comments', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new MomentClient($app);

        $this->assertIsArray($client->getComments('momxxx', 'xxx'));

        $this->assertSame(json_decode($this->readMockResponseJson('getComments.json'), true), $client->getComments('momxxx', 'xxx', 'CURSOR', 100));
    }

    protected function readMockResponseJson(string $filename): string
    {
        return file_get_contents(__DIR__ . '/mock_data/Moment/' . $filename);
    }
}