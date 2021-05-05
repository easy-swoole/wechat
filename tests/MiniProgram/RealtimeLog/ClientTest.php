<?php
/**
 * Created by PhpStorm.
 * User: XueSi
 * Email: <1592328848@qq.com>
 * Date: 2021/5/5
 * Time: 19:53
 */

namespace EasySwoole\WeChat\Tests\MiniProgram\RealtimeLog;

use EasySwoole\WeChat\Kernel\ServiceContainer;
use EasySwoole\WeChat\Tests\Mock\Message\Status;
use EasySwoole\WeChat\Tests\TestCase;
use Psr\Http\Message\ServerRequestInterface;
use EasySwoole\WeChat\MiniProgram\RealtimeLog\Client;


class ClientTest extends TestCase
{
    public function testSearch()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('search.json'));

        $app = $this->mockAccessToken(new ServiceContainer([
            'appId' => 'mock_appid',
            'appSecret' => 'mock_secret'
        ]));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('GET', $request->getMethod());
            $this->assertEquals('/wxaapi/userlog/userlog_search', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token&date=20191217&begintime=1576549163&endtime=1576559963&level=2', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        $this->assertIsArray($client->search('20191217', 1576549163, 1576559963, ['level' => 2]));

        $this->assertSame(json_decode($this->readMockResponseJson('search.json'), true), $client->search('20191217', 1576549163, 1576559963, ['level' => 2]));
    }

    private function readMockResponseJson($filename)
    {
        return file_get_contents(__DIR__ . '/mock_data/' . $filename);
    }
}