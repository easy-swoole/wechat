<?php
/**
 * Created by PhpStorm.
 * User: XueSi
 * Email: <1592328848@qq.com>
 * Date: 2021/4/25
 * Time: 3:07
 */

namespace EasySwoole\WeChat\Tests\Work\Schedule;


use EasySwoole\WeChat\Kernel\ServiceContainer;
use EasySwoole\WeChat\Tests\Mock\Message\Status;
use EasySwoole\WeChat\Tests\TestCase;
use EasySwoole\WeChat\Work\Schedule\Client;
use Psr\Http\Message\ServerRequestInterface;

class ClientTest extends TestCase
{
    public function testAdd()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('add.json'));

        $app = $this->mockAccessToken(new ServiceContainer([
            'corpId' => 'mock_corpId',
            'corpSecret' => 'mock_corpSecret'
        ]));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/oa/schedule/add', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        $schedule = [
            'organizer' => 'userid1',
            'start_time' => 1571274600,
            'end_time' => 1571320210,
            'attendees' => [
                [
                    'userid' => 'userid2',
                ],
            ],
            'summary' => '需求评审会议',
            'description' => '2.0版本需求初步评审',
            'reminders' => [
                'is_remind' => 1,
                'remind_before_event_secs' => 3600,
                'is_repeat' => 1,
                'repeat_type' => 7,
                'repeat_until' => 1606976813,
                'is_custom_repeat' => 1,
                'repeat_interval' => 1,
                'repeat_day_of_week' => [3, 7],
                'repeat_day_of_month' => [10, 21],
                'timezone' => 8,
            ],
            'location' => '广州国际媒体港10楼1005会议室',
            'cal_id' => 'wcjgewCwAAqeJcPI1d8Pwbjt7nttzAAA'
        ];

        $this->assertIsArray($client->add($schedule));

        $this->assertSame(json_decode($this->readMockResponseJson('add.json'), true), $client->add($schedule));
    }

    public function testUpdate()
    {
        $response = $this->buildResponse(Status::CODE_OK, '{"errcode":0,"errmsg":"ok"}');

        $app = $this->mockAccessToken(new ServiceContainer([
            'corpId' => 'mock_corpId',
            'corpSecret' => 'mock_corpSecret'
        ]));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/oa/schedule/update', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        $schedule = [
            'organizer' => 'userid1',
            'start_time' => 1571274600,
            'end_time' => 1571320210,
            'attendees' => [
                [
                    'userid' => 'userid2',
                ],
            ],
            'summary' => 'test_summary',
            'description' => 'test_description',
            'reminders' => [
                'is_remind' => 1,
                'remind_before_event_secs' => 3600,
                'is_repeat' => 1,
                'repeat_type' => 7,
                'repeat_until' => 1606976813,
                'is_custom_repeat' => 1,
                'repeat_interval' => 1,
                'repeat_day_of_week' => [3, 7],
                'repeat_day_of_month' => [10, 21],
                'timezone' => 8,
            ],
            'location' => 'test_place',
        ];

        $this->assertTrue($client->update('17c7d2bd9f20d652840f72f59e796AAA', $schedule));
    }

    public function testGet()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('get.json'));

        $app = $this->mockAccessToken(new ServiceContainer([
            'corpId' => 'mock_corpId',
            'corpSecret' => 'mock_corpSecret'
        ]));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/oa/schedule/get', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        $this->assertIsArray($client->get(['17c7d2bd9f20d652840f72f59e796AAA']));

        $this->assertSame(json_decode($this->readMockResponseJson('get.json'), true), $client->get(['17c7d2bd9f20d652840f72f59e796AAA']));
    }

    public function testGetByCalendar()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('getByCalendar.json'));

        $app = $this->mockAccessToken(new ServiceContainer([
            'corpId' => 'mock_corpId',
            'corpSecret' => 'mock_corpSecret'
        ]));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/oa/schedule/get_by_calendar', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        $this->assertIsArray($client->getByCalendar('wcjgewCwAAqeJcPI1d8Pwbjt7nttzAAA', 100, 1000));

        $this->assertSame(json_decode($this->readMockResponseJson('getByCalendar.json'), true), $client->getByCalendar('wcjgewCwAAqeJcPI1d8Pwbjt7nttzAAA', 100, 1000));
    }

    public function testDelete()
    {
        $response = $this->buildResponse(Status::CODE_OK, '{"errcode":0,"errmsg":"ok"}');

        $app = $this->mockAccessToken(new ServiceContainer([
            'corpId' => 'mock_corpId',
            'corpSecret' => 'mock_corpSecret'
        ]));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/oa/schedule/del', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        $this->assertTrue($client->delete('17c7d2bd9f20d652840f72f59e796AAA'));
    }

    protected function readMockResponseJson(string $filename)
    {
        return file_get_contents(__DIR__ . '/mock_data/' . $filename);
    }
}