<?php
/**
 * Created by PhpStorm.
 * User: 67066
 * Date: 2020/11/29
 * Time: 18:43
 */

namespace EasySwoole\WeChat\Tests\OfficialAccount\DataCube;


use EasySwoole\WeChat\Kernel\ServiceContainer;
use EasySwoole\WeChat\OfficialAccount\DataCube\Client;
use EasySwoole\WeChat\Tests\Mock\Message\Status;
use EasySwoole\WeChat\Tests\TestCase;
use Psr\Http\Message\ServerRequestInterface;

class ClientTest extends TestCase
{
    public function testUserSummary()
    {
        $this->template1('userSummary');
    }

    public function testUserCumulate()
    {
        $this->template1('userCumulate');
    }

    public function testArticleSummary()
    {
        $this->template1('articleSummary');
    }

    public function testArticleTotal()
    {
        $this->template1('articleTotal');
    }

    public function testUserReadSummary()
    {
        $this->template1('userReadSummary');
    }

    public function testUserReadHourly()
    {
        $this->template1('userReadHourly');
    }

    public function testUserShareSummary()
    {
        $this->template1('userShareSummary');
    }

    public function testUserShareHourly()
    {
        $this->template1('userShareHourly');
    }

    public function testUpstreamMessageSummary()
    {
        $this->template1('upstreamMessageSummary');
    }

    public function testUpstreamMessageHourly()
    {
        $this->template1('upstreamMessageHourly');
    }

    public function testUpstreamMessageWeekly()
    {
        $this->template1('upstreamMessageWeekly');
    }

    public function testUpstreamMessageMonthly()
    {
        $this->template1('upstreamMessageMonthly');
    }

    public function testUpstreamMessageDistSummary()
    {
        $this->template1('upstreamMessageDistSummary');
    }

    public function testUpstreamMessageDistWeekly()
    {
        $this->template1('upstreamMessageDistWeekly');
    }

    public function testUpstreamMessageDistMonthly()
    {
        $this->template1('upstreamMessageDistMonthly');
    }

    public function testInterfaceSummary()
    {
        $this->template1('interfaceSummary');
    }

    public function testInterfaceSummaryHourly()
    {
        $this->template1('interfaceSummaryHourly');
    }

    public function testCardSummary()
    {
        $this->template2('cardSummary');
    }

    public function testFreeCardSummary1()
    {
        $this->template2('freeCardSummary');
    }

    public function testFreeCardSummary2()
    {
        //参数模拟
        $beginDate = '2014-12-02';
        $endDate = '2014-12-07';
        $condSource = 0;
        $cardId = 'po8pktyDLmakNY2fn2VyhkiEPqGE';
        //request检查
        $needHttpMethod = 'POST';
        $needPath = '/datacube/getcardcardinfo';
        $checkFunc = function (ServerRequestInterface $request) use (
            $needHttpMethod,
            $needPath,
            $beginDate,
            $endDate,
            $condSource,
            $cardId
        ) {
            $this->assertEquals($needHttpMethod, $request->getMethod());
            $this->assertEquals($needPath, $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
            $this->assertEquals(json_encode([
                'begin_date' => $beginDate,
                'end_date' => $endDate,
                'cond_source' => $condSource,
                'card_id' => $cardId,
            ]), $request->getBody()->getContents());
        };
        //构建app
        $responseDataName = 'freeCardSummary.json';
        $app = $this->prepareAppAndResponseWithToken($responseDataName, $checkFunc);
        //调用客户端
        $client = new Client($app);
        $rs = $client->freeCardSummary($beginDate, $endDate, $condSource, $cardId);
        //结果检查
        $this->assertIsArray($rs);
        $this->assertEquals($this->readJsonToArray($responseDataName), $rs);
    }

    public function testMemberCardSummary()
    {
        $this->template2('memberCardSummary');
    }

    public function testMemberCardSummaryById()
    {
        $beginDate = '2014-12-02';
        $endDate = '2014-12-07';
        $cardId = 'p4WkzwieuDBzzn7Jed6SBO0-ZgaU';

        $needPath = '/datacube/getcardmembercarddetail';
        $needHttpMethod = 'POST';
        $checkFunc = function (ServerRequestInterface $request) use (
            $needHttpMethod,
            $needPath,
            $beginDate,
            $endDate,
            $cardId
        ) {
            $this->assertEquals($needHttpMethod, $request->getMethod());
            $this->assertEquals($needPath, $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
            $this->assertEquals(json_encode([
                'begin_date' => $beginDate,
                'end_date' => $endDate,
                'card_id' => $cardId,
            ]), $request->getBody()->getContents());
        };

        $responseDataName = 'memberCardSummaryById.json';
        $app = $this->prepareAppAndResponseWithToken($responseDataName, $checkFunc);

        $client = new Client($app);
        $rs = $client->memberCardSummaryById($beginDate, $endDate, $cardId);

        $this->assertIsArray($rs);
        $this->assertEquals($this->readJsonToArray($responseDataName), $rs);
    }

    protected function prepareAppAndResponseWithToken($responseDataName, $checkFunc)
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson($responseDataName));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient($checkFunc, $response, $app);
        return $app;
    }

    protected function readMockResponseJson(string $file): string
    {
        return file_get_contents(dirname(__FILE__) . '/mock_data/Client/' . $file);
    }

    protected function readJsonToArray(string $file): array
    {
        $json = $this->readMockResponseJson($file);
        return json_decode($json, true);
    }

    /**
     * 模板1:只有beginDate,endDate
     */
    protected function template1($method)
    {
        //可用方法列表 => 应有的path
        $methodPathMap = [
            'userSummary' => '/datacube/getusersummary',
            'userCumulate' => '/datacube/getusercumulate',
            'articleSummary' => '/datacube/getarticlesummary',
            'articleTotal' => '/datacube/getarticletotal',
            'userReadSummary' => '/datacube/getuserread',
            'userReadHourly' => '/datacube/getuserreadhour',
            'userShareSummary' => '/datacube/getusershare',
            'userShareHourly' => '/datacube/getusersharehour',
            'upstreamMessageSummary' => '/datacube/getupstreammsg',
            'upstreamMessageHourly' => '/datacube/getupstreammsghour',
            'upstreamMessageWeekly' => '/datacube/getupstreammsgweek',
            'upstreamMessageMonthly' => '/datacube/getupstreammsgmonth',
            'upstreamMessageDistSummary' => '/datacube/getupstreammsgdist',
            'upstreamMessageDistWeekly' => '/datacube/getupstreammsgdistweek',
            'upstreamMessageDistMonthly' => '/datacube/getupstreammsgdistmonth',
            'interfaceSummary' => '/datacube/getinterfacesummary',
            'interfaceSummaryHourly' => '/datacube/getinterfacesummaryhour',


        ];
        //参数模拟
        $beginDate = '2014-12-02';
        $endDate = '2014-12-07';
        //request检查
        $needHttpMethod = 'POST';
        $needPath = $methodPathMap[$method];
        $checkFunc = function (ServerRequestInterface $request) use ($needHttpMethod, $needPath, $beginDate, $endDate) {
            $this->assertEquals($needHttpMethod, $request->getMethod());
            $this->assertEquals($needPath, $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
            $this->assertEquals(json_encode([
                'begin_date' => $beginDate,
                'end_date' => $endDate,
            ]), $request->getBody()->getContents());
        };
        //构建app
        $responseDataName = $method . '.json';
        $app = $this->prepareAppAndResponseWithToken($responseDataName, $checkFunc);
        //客户端调用
        $client = new Client($app);
        $rs = call_user_func_array([$client, $method], [$beginDate, $endDate]);
        //结果检查
        $this->assertIsArray($rs);
        $this->assertEquals($this->readJsonToArray($responseDataName), $rs);
    }

    /**
     * 模板2:只有beginDate,endDate,condSource
     */
    protected function template2($method)
    {
        //可用方法列表 => 应有的path
        $methodPathMap = [
            'cardSummary' => '/datacube/getcardbizuininfo',
            'memberCardSummary' => '/datacube/getcardmembercardinfo',
            'freeCardSummary' => '/datacube/getcardcardinfo',
        ];

        //参数模拟
        $beginDate = '2014-12-02';
        $endDate = '2014-12-07';
        $condSource = 0;
        //request检查
        $needHttpMethod = 'POST';
        $needPath = $methodPathMap[$method];
        $checkFunc = function (ServerRequestInterface $request) use (
            $needHttpMethod,
            $needPath,
            $beginDate,
            $endDate,
            $condSource
        ) {
            $this->assertEquals($needHttpMethod, $request->getMethod());
            $this->assertEquals($needPath, $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
            $this->assertEquals(json_encode([
                'begin_date' => $beginDate,
                'end_date' => $endDate,
                'cond_source' => $condSource,
            ]), $request->getBody()->getContents());
        };
        //构建app
        $responseDataName = $method . '.json';
        $app = $this->prepareAppAndResponseWithToken($responseDataName, $checkFunc);
        //客户端调用
        $client = new Client($app);
        $rs = call_user_func_array([$client, $method], [$beginDate, $endDate, $condSource]);
        //结果检查
        $this->assertIsArray($rs);
        $this->assertEquals($this->readJsonToArray($responseDataName), $rs);
    }

}
