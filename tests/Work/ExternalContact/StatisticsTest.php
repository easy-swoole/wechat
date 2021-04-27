<?php
/**
 * Created by PhpStorm.
 * User: XueSi
 * Email: <1592328848@qq.com>
 * Date: 2021/4/24
 * Time: 22:33
 */

namespace EasySwoole\WeChat\Tests\Work\ExternalContact;


use EasySwoole\WeChat\Kernel\ServiceContainer;
use EasySwoole\WeChat\Tests\Mock\Message\Status;
use EasySwoole\WeChat\Tests\TestCase;
use EasySwoole\WeChat\Work\ExternalContact\StatisticsClient;
use Psr\Http\Message\ServerRequestInterface;

class StatisticsTest extends TestCase
{
    public function testUserBehavior()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('userBehavior.json'));
        $app = $this->mockAccessToken(new ServiceContainer([
            'corpId' => 'mock_corpId',
            'corpSecret' => 'mock_corpSecret',
        ]));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/externalcontact/get_user_behavior_data', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new StatisticsClient($app);

        $userIds = [
            "zhangsan",
            "lisi"
        ];

        $partyIds = [
            1001,
            1002
        ];

        $this->assertIsArray($client->userBehavior($userIds, 1536508800, 1536595200, $partyIds));

        $this->assertSame(json_decode($this->readMockResponseJson('userBehavior.json'), true), $client->userBehavior($userIds, 1536508800, 1536595200, $partyIds));
    }

    public function testGroupChatStatistic(): void
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('groupChatStatistic.json'));
        $app = $this->mockAccessToken(new ServiceContainer([
            'corpId' => 'mock_corpId',
            'corpSecret' => 'mock_corpSecret',
        ]));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/externalcontact/groupchat/statistic', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new StatisticsClient($app);

        $params = [
            'day_begin_time' => 1600272000,
            'day_end_time' => 1600444800,
            'owner_filter' => [
                'userid_list' => ["zhangsan"]
            ],
            'order_by' => 2,
            'order_asc' => 0,
            'offset' => 0,
            'limit' => 1000
        ];

        $this->assertIsArray($client->groupChatStatistic($params));

        $this->assertSame(json_decode($this->readMockResponseJson('groupChatStatistic.json'), true), $client->groupChatStatistic($params));
    }

    public function testGroupChatStatisticGroupByDay(): void
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('groupChatStatisticGroupByDay.json'));
        $app = $this->mockAccessToken(new ServiceContainer([
            'corpId' => 'mock_corpId',
            'corpSecret' => 'mock_corpSecret',
        ]));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/externalcontact/groupchat/statistic_group_by_day', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new StatisticsClient($app);

        $this->assertIsArray($client->groupChatStatisticGroupByDay(1600272000, 1600358400, ["zhangsan"]));

        $this->assertSame(json_decode($this->readMockResponseJson('groupChatStatisticGroupByDay.json'), true), $client->groupChatStatisticGroupByDay(1600272000, 1600358400, ["zhangsan"]));
    }

    protected function readMockResponseJson(string $filename): string
    {
        return file_get_contents(__DIR__ . '/mock_data/Statistics/' . $filename);
    }
}