<?php

namespace EasySwoole\WeChat\Tests\OfficialAccount\ShakeAround;


use EasySwoole\WeChat\Kernel\ServiceContainer;
use EasySwoole\WeChat\OfficialAccount\ShakeAround\StatsClient;
use EasySwoole\WeChat\Tests\Mock\Message\Status;
use EasySwoole\WeChat\Tests\TestCase;
use Psr\Http\Message\ServerRequestInterface;

class StatsClientTest extends TestCase
{

    public function testDeviceSummary()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('stats_device_summary.json'));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/shakearound/statistics/device', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $data = [
            'device_id' => 10011,
            'uuid' => 'FDA50693-A4E2-4FB1-AFCF-C6EB07647825',
            'major' => 1002,
            'minor' => 1223
        ];

        $client = new StatsClient($app);
        $this->assertIsArray($client->deviceSummary($data, 1438704000, 1438704000));
        $this->assertEquals(json_decode($this->readMockResponseJson('stats_device_summary.json'), true), $client->deviceSummary($data, 1438704000, 1438704000));
    }

    public function testDevicesSummary()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('stats_devices_summary.json'));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/shakearound/statistics/devicelist', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new StatsClient($app);
        $this->assertIsArray($client->devicesSummary(1438704000, 1));
        $this->assertEquals(json_decode($this->readMockResponseJson('stats_devices_summary.json'), true), $client->devicesSummary(1438704000, 1));
    }


    public function testPageSummary()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('stats_page_summary.json'));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/shakearound/statistics/page', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new StatsClient($app);
        $this->assertIsArray($client->pageSummary(12345, 1438704000, 1438704000));
        $this->assertEquals(json_decode($this->readMockResponseJson('stats_page_summary.json'), true), $client->pageSummary(12345, 1438704000, 1438704000));
    }


    public function testPagesSummary()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('stats_pages_summary.json'));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/shakearound/statistics/pagelist', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new StatsClient($app);
        $this->assertIsArray($client->pagesSummary(1438704000, 1));
        $this->assertEquals(json_decode($this->readMockResponseJson('stats_pages_summary.json'), true), $client->pagesSummary(1438704000, 1));
    }

    private function readMockResponseJson(string $file): string
    {
        return file_get_contents(dirname(__FILE__) . '/mock_data/' . $file);
    }
}
