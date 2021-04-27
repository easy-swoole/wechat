<?php
/**
 * Created by PhpStorm.
 * User: XueSi
 * Email: <1592328848@qq.com>
 * Date: 2021/4/25
 * Time: 0:13
 */

namespace EasySwoole\WeChat\Tests\Work\Live;


use EasySwoole\WeChat\Kernel\ServiceContainer;
use EasySwoole\WeChat\Tests\Mock\Message\Status;
use EasySwoole\WeChat\Tests\TestCase;
use EasySwoole\WeChat\Work\Live\Client;
use Psr\Http\Message\ServerRequestInterface;

class ClientTest extends TestCase
{
    public function testGetUserLivingId()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('getUserLivingId.json'));
        $app = $this->mockAccessToken(new ServiceContainer([
            'corpId' => 'mock_corpId',
            'corpSecret' => 'mock_corpSecret',
        ]));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/living/get_user_livingid', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        $this->assertIsArray($client->getUserLivingId('USERID', 1586136317, 1586236317, 'NEXT_KEY', 100));

        $this->assertSame(json_decode($this->readMockResponseJson('getUserLivingId.json'), true), $client->getUserLivingId('USERID', 1586136317, 1586236317, 'NEXT_KEY', 100));
    }

    public function testGetLiving()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('getLiving.json'));
        $app = $this->mockAccessToken(new ServiceContainer([
            'corpId' => 'mock_corpId',
            'corpSecret' => 'mock_corpSecret',
        ]));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('GET', $request->getMethod());
            $this->assertEquals('/cgi-bin/living/get_living_info', $request->getUri()->getPath());
            $this->assertEquals('livingid=LIVINGID&access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        $this->assertIsArray($client->getLiving('LIVINGID'));

        $this->assertSame(json_decode($this->readMockResponseJson('getLiving.json'), true), $client->getLiving('LIVINGID'));
    }

    public function testGetWatchStat()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('getWatchStat.json'));
        $app = $this->mockAccessToken(new ServiceContainer([
            'corpId' => 'mock_corpId',
            'corpSecret' => 'mock_corpSecret',
        ]));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/living/get_watch_stat', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        $this->assertIsArray($client->getWatchStat('livingid1', 'NEXT_KEY'));

        $this->assertSame(json_decode($this->readMockResponseJson('getWatchStat.json'), true), $client->getWatchStat('livingid1', 'NEXT_KEY'));
    }

    protected function readMockResponseJson(string $filename): string
    {
        return file_get_contents(__DIR__ . '/mock_data/' . $filename);
    }
}