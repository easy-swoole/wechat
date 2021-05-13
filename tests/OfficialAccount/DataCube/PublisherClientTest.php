<?php
/**
 * Created by PhpStorm.
 * User: 67066
 * Date: 2020/12/30
 * Time: 11:49
 */

namespace EasySwoole\WeChat\Tests\OfficialAccount\DataCube;

use EasySwoole\WeChat\Kernel\ServiceContainer;
use EasySwoole\WeChat\OfficialAccount\DataCube\PublisherClient;
use EasySwoole\WeChat\Tests\Mock\Message\Status;
use EasySwoole\WeChat\Tests\TestCase;
use Psr\Http\Message\ServerRequestInterface;

/**
 * 广告分析测试
 */
class PublisherClientTest extends TestCase
{
    // 获取公众号分广告位数据
    public function testAdposGeneral()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('adposGeneral.json'));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => 'mock_appId']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('GET', $request->getMethod());
            $this->assertEquals('/publisher/stat', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token&action=publisher_adpos_general&page=1&page_size=10&start_date=2019-10-11&end_date=2019-10-12', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new PublisherClient($app);

        $page = 1;
        $pageSize = 10;
        $startDate = '2019-10-11';
        $endDate = '2019-10-12';

        $ret = $client->adposGeneral($page, $pageSize, $startDate, $endDate);

        $this->assertIsArray($ret);

        $this->assertSame($this->readJsonToArray('adposGeneral.json'), $ret);
    }

    // 获取公众号返佣商品数据
    public function testCpsGeneral()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('cpsGeneral.json'));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => 'mock_appId']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('GET', $request->getMethod());
            $this->assertEquals('/publisher/stat', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token&action=publisher_cps_general&page=1&page_size=10&start_date=2019-10-11&end_date=2019-10-12', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new PublisherClient($app);

        $page = 1;
        $pageSize = 10;
        $startDate = '2019-10-11';
        $endDate = '2019-10-12';

        $ret = $client->cpsGeneral($page, $pageSize, $startDate, $endDate);

        $this->assertIsArray($ret);

        $this->assertSame($this->readJsonToArray('cpsGeneral.json'), $ret);
    }

    // 获取公众号结算收入数据及结算主体信息
    function testSettlement()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('settlement.json'));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => 'mock_appId']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('GET', $request->getMethod());
            $this->assertEquals('/publisher/stat', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token&action=publisher_settlement&page=1&page_size=10&start_date=2019-10-11&end_date=2019-10-12', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new PublisherClient($app);

        $page = 1;
        $pageSize = 10;
        $startDate = '2019-10-11';
        $endDate = '2019-10-12';

        $ret = $client->settlement($page, $pageSize, $startDate, $endDate);

        $this->assertIsArray($ret);

        $this->assertSame($this->readJsonToArray('settlement.json'), $ret);
    }

    protected function readJsonToArray(string $file): array
    {
        $json = $this->readMockResponseJson($file);
        return json_decode($json, true);
    }

    protected function readMockResponseJson(string $file): string
    {
        return file_get_contents(dirname(__FILE__) . '/mock_data/PublisherClient/' . $file);
    }
}