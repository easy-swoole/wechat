<?php
/**
 * Created by PhpStorm.
 * User: XueSi
 * Email: <1592328848@qq.com>
 * Date: 2021/5/5
 * Time: 18:05
 */

namespace EasySwoole\WeChat\Tests\MiniProgram\DataCube;

use EasySwoole\WeChat\Kernel\ServiceContainer;
use EasySwoole\WeChat\Tests\Mock\Message\Status;
use EasySwoole\WeChat\Tests\TestCase;
use Psr\Http\Message\ServerRequestInterface;
use EasySwoole\WeChat\MiniProgram\DataCube\Client;

class ClientTest extends TestCase
{
    public function testDailyRetainInfo()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('dailyRetainInfo.json'));

        $app = $this->mockAccessToken(new ServiceContainer([
            'appId' => 'mock_appid',
            'appSecret' => 'mock_secret'
        ]));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/datacube/getweanalysisappiddailyretaininfo', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        $this->assertIsArray($client->dailyRetainInfo('20170313', '20170313'));

        $this->assertSame(json_decode($this->readMockResponseJson('dailyRetainInfo.json'), true), $client->dailyRetainInfo('20170313', '20170313'));
    }

    public function testMonthlyRetainInfo()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('monthlyRetainInfo.json'));

        $app = $this->mockAccessToken(new ServiceContainer([
            'appId' => 'mock_appid',
            'appSecret' => 'mock_secret'
        ]));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/datacube/getweanalysisappidmonthlyretaininfo', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        $this->assertIsArray($client->monthlyRetainInfo('20170201', '20170228'));

        $this->assertSame(json_decode($this->readMockResponseJson('monthlyRetainInfo.json'), true), $client->monthlyRetainInfo('20170201', '20170228'));
    }

    public function testWeeklyRetainInfo()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('weeklyRetainInfo.json'));

        $app = $this->mockAccessToken(new ServiceContainer([
            'appId' => 'mock_appid',
            'appSecret' => 'mock_secret'
        ]));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/datacube/getweanalysisappidweeklyretaininfo', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        $this->assertIsArray($client->weeklyRetainInfo('20170306', '20170312'));

        $this->assertSame(json_decode($this->readMockResponseJson('weeklyRetainInfo.json'), true), $client->weeklyRetainInfo('20170306', '20170312'));
    }

    public function testSummaryTrend()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('summaryTrend.json'));

        $app = $this->mockAccessToken(new ServiceContainer([
            'appId' => 'mock_appid',
            'appSecret' => 'mock_secret'
        ]));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/datacube/getweanalysisappiddailysummarytrend', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        $this->assertIsArray($client->summaryTrend('20170313', '20170313'));

        $this->assertSame(json_decode($this->readMockResponseJson('summaryTrend.json'), true), $client->summaryTrend('20170313', '20170313'));
    }

    public function testDailyVisitTrend()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('dailyVisitTrend.json'));

        $app = $this->mockAccessToken(new ServiceContainer([
            'appId' => 'mock_appid',
            'appSecret' => 'mock_secret'
        ]));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/datacube/getweanalysisappiddailyvisittrend', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        $this->assertIsArray($client->dailyVisitTrend('20170313', '20170313'));

        $this->assertSame(json_decode($this->readMockResponseJson('dailyVisitTrend.json'), true), $client->dailyVisitTrend('20170313', '20170313'));
    }

    public function testMonthlyVisitTrend()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('monthlyVisitTrend.json'));

        $app = $this->mockAccessToken(new ServiceContainer([
            'appId' => 'mock_appid',
            'appSecret' => 'mock_secret'
        ]));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/datacube/getweanalysisappidmonthlyvisittrend', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        $this->assertIsArray($client->monthlyVisitTrend('20170301', '20170331'));

        $this->assertSame(json_decode($this->readMockResponseJson('monthlyVisitTrend.json'), true), $client->monthlyVisitTrend('20170301', '20170331'));
    }

    public function testWeeklyVisitTrend()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('weeklyVisitTrend.json'));

        $app = $this->mockAccessToken(new ServiceContainer([
            'appId' => 'mock_appid',
            'appSecret' => 'mock_secret'
        ]));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/datacube/getweanalysisappidweeklyvisittrend', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        $this->assertIsArray($client->weeklyVisitTrend('20170306', '20170312'));

        $this->assertSame(json_decode($this->readMockResponseJson('weeklyVisitTrend.json'), true), $client->weeklyVisitTrend('20170306', '20170312'));
    }

    public function testUserPortrait()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('userPortrait.json'));

        $app = $this->mockAccessToken(new ServiceContainer([
            'appId' => 'mock_appid',
            'appSecret' => 'mock_secret'
        ]));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/datacube/getweanalysisappiduserportrait', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        $this->assertIsArray($client->userPortrait('20170611', '20170617'));

        $this->assertSame(json_decode($this->readMockResponseJson('userPortrait.json'), true), $client->userPortrait('20170611', '20170617'));
    }

    public function testVisitDistribution()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('visitDistribution.json'));

        $app = $this->mockAccessToken(new ServiceContainer([
            'appId' => 'mock_appid',
            'appSecret' => 'mock_secret'
        ]));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/datacube/getweanalysisappidvisitdistribution', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        $this->assertIsArray($client->visitDistribution('20170313', '20170313'));

        $this->assertSame(json_decode($this->readMockResponseJson('visitDistribution.json'), true), $client->visitDistribution('20170313', '20170313'));
    }

    public function testVisitPage()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('visitPage.json'));

        $app = $this->mockAccessToken(new ServiceContainer([
            'appId' => 'mock_appid',
            'appSecret' => 'mock_secret'
        ]));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/datacube/getweanalysisappidvisitpage', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        $this->assertIsArray($client->visitPage('20170313', '20170313'));

        $this->assertSame(json_decode($this->readMockResponseJson('visitPage.json'), true), $client->visitPage('20170313', '20170313'));
    }

    private function readMockResponseJson($filename)
    {
        return file_get_contents(__DIR__ . '/mock_data/' . $filename);
    }
}