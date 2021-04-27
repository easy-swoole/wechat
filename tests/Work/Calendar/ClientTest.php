<?php
/**
 * Created by PhpStorm.
 * User: XueSi
 * Email: <1592328848@qq.com>
 * Date: 2021/4/24
 * Time: 17:28
 */

namespace EasySwoole\WeChat\Tests\Work\Calendar;


use EasySwoole\WeChat\Kernel\ServiceContainer;
use EasySwoole\WeChat\Tests\Mock\Message\Status;
use EasySwoole\WeChat\Tests\TestCase;
use EasySwoole\WeChat\Work\Calendar\Client;
use Psr\Http\Message\ServerRequestInterface;

class ClientTest extends TestCase
{
    public function testAdd()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('add.json'));
        $app = $this->mockAccessToken(new ServiceContainer([
            'corpId' => 'mock_corpId',
            'corpSecret' => 'mock_corpSecret',
        ]));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/oa/calendar/add', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $calendar = [
            'calendar' => [
                'organizer' => 'userid1',
                'readonly' => 1,
                'set_as_default' => 1,
                'summary' => 'test_summary',
                'color' => '#FF3030',
                'description' => 'test_describe',
                'shares' => [
                    [
                        'userid' => 'userid2',
                    ],
                    [
                        'userid' => 'userid3',
                        'readonly' => 1,
                    ],
                ],
            ],
            'agentid' => 1000014,
        ];

        $client = new Client($app);
        $this->assertIsArray($client->add($calendar));
        $this->assertSame(json_decode($this->readMockResponseJson('add.json'), true), $client->add($calendar));
    }

    public function testUpdate()
    {
        $response = $this->buildResponse(Status::CODE_OK, '{"errcode":0,"errmsg":"ok"}');
        $app = $this->mockAccessToken(new ServiceContainer([
            'corpId' => 'mock_corpId',
            'corpSecret' => 'mock_corpSecret',
        ]));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/oa/calendar/update', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $calendar = [
            'readonly' => 1,
            'summary' => 'test_summary',
            'color' => '#FF3030',
            'description' => 'test_describe_1',
            'shares' => [
                [
                    'userid' => 'userid1',
                ],
                [
                    'userid' => 'userid2',
                    'readonly' => 1,
                ]
            ]
        ];

        $client = new Client($app);
        $this->assertTrue($client->update('wcjgewCwAAqeJcPI1d8Pwbjt7nttzAAA', $calendar));
    }

    public function testGet()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('get.json'));
        $app = $this->mockAccessToken(new ServiceContainer([
            'corpId' => 'mock_corpId',
            'corpSecret' => 'mock_corpSecret',
        ]));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/oa/calendar/get', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);
        $this->assertIsArray($client->get(['wcjgewCwAAqeJcPI1d8Pwbjt7nttzAAA']));

        $this->assertSame(json_decode($this->readMockResponseJson('get.json'), true), $client->get(['wcjgewCwAAqeJcPI1d8Pwbjt7nttzAAA']));
    }

    public function testDelete()
    {
        $response = $this->buildResponse(Status::CODE_OK, '{"errcode":0,"errmsg":"ok"}');
        $app = $this->mockAccessToken(new ServiceContainer([
            'corpId' => 'mock_corpId',
            'corpSecret' => 'mock_corpSecret',
        ]));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/oa/calendar/del', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);
        $this->assertTrue($client->delete('wcjgewCwAAqeJcPI1d8Pwbjt7nttzAAA'));
    }

    protected function readMockResponseJson(string $filename): string
    {
        return file_get_contents(__DIR__ . '/mock_data/' . $filename);
    }
}