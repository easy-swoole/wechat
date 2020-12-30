<?php
/**
 * Created by PhpStorm.
 * User: 67066
 * Date: 2020/12/30
 * Time: 11:49
 */

namespace EasySwoole\WeChat\Tests\OfficialAccount\Menu;

use EasySwoole\WeChat\Kernel\ServiceContainer;
use EasySwoole\WeChat\OfficialAccount\DataCube\PublisherClient;
use EasySwoole\WeChat\Tests\Mock\Message\Status;
use EasySwoole\WeChat\Tests\TestCase;
use Psr\Http\Message\ServerRequestInterface;

/**
 * 广告分析测试
 * */
class PublisherClientTest extends TestCase
{
    /**
     * 获取公众号分广告位数据
     * */
    function testAdposGeneral()
    {
        $responseDataName = 'adposGeneral.json';
        $method = 'GET';
        $urlFormat = '/publisher/stat';
        $getParamFormat = 'action=publisher_adpos_general';
        $app = $this->prepareAppAndResponseWithToken($responseDataName, $method, $urlFormat, $getParamFormat);

        $page = 1;
        $pageSize = 10;
        $startDate = '2019-10-11';
        $endDate = '2019-10-12';
        $client = new PublisherClient($app);
        $rs = $client->adposGeneral($page, $pageSize, $startDate, $endDate);
        $this->assertIsArray($rs);
        $this->assertEquals($this->readJsonToArray($responseDataName), $rs);
    }

    /**
     * 获取公众号返佣商品数据
     * */
    function testCpsGeneral()
    {
        $responseDataName = 'cpsGeneral.json';
        $method = 'GET';
        $urlFormat = '/publisher/stat';
        $getParamFormat = 'action=publisher_cps_general';
        $app = $this->prepareAppAndResponseWithToken($responseDataName, $method, $urlFormat, $getParamFormat);

        $page = 1;
        $pageSize = 10;
        $startDate = '2019-10-11';
        $endDate = '2019-10-12';
        $client = new PublisherClient($app);
        $rs = $client->cpsGeneral($page, $pageSize, $startDate, $endDate);
        $this->assertIsArray($rs);
        $this->assertEquals($this->readJsonToArray($responseDataName), $rs);
    }

    /**
     * 获取公众号结算收入数据及结算主体信息
     * */
    function testSettlement()
    {
        $responseDataName = 'settlement.json';
        $method = 'GET';
        $urlFormat = '/publisher/stat';
        $getParamFormat = 'action=publisher_settlement';
        $app = $this->prepareAppAndResponseWithToken($responseDataName, $method, $urlFormat, $getParamFormat);

        $page = 1;
        $pageSize = 10;
        $startDate = '2019-10-11';
        $endDate = '2019-10-12';
        $client = new PublisherClient($app);
        $rs = $client->settlement($page, $pageSize, $startDate, $endDate);
        $this->assertIsArray($rs);
        $this->assertEquals($this->readJsonToArray($responseDataName), $rs);
    }

    protected function prepareAppAndResponseWithToken($responseDataName, $method, $urlFormat, $getParamFormat)
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson($responseDataName));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) use (
            $method,
            $urlFormat,
            $getParamFormat
        ) {
            $this->assertEquals($method, $request->getMethod());
            $this->assertEquals($urlFormat, $request->getUri()->getPath());
//            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
//            $this->assertEquals($getParamFormat, $request->getUri()->getQuery());
        }, $response, $app);
        return $app;
    }

    protected function readJsonToArray(string $file): array
    {
        $json = $this->readMockResponseJson($file);
        return json_decode($json, true);
    }

    protected function readMockResponseJson(string $file): string
    {
        return file_get_contents(dirname(__FILE__) . '/mock_data/' . $file);
    }
}