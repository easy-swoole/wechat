<?php
/**
 * Created by PhpStorm.
 * User: hlh XueSi <1592328848@qq.com>
 * Date: 2022/9/24
 * Time: 12:19 下午
 */

namespace EasySwoole\WeChat\Tests\OpenPlatform\Authorizer\MiniProgram\Record;

use EasySwoole\WeChat\Tests\Mock\Message\Status;
use EasySwoole\WeChat\Tests\TestCase;
use EasySwoole\WeChat\OpenPlatform\Application;
use Psr\Http\Message\ServerRequestInterface;
use EasySwoole\WeChat\OpenPlatform\Authorizer\MiniProgram\Record\Client;

class ClientTest extends TestCase
{
    public function testGetIllegalRecords()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('getIllegalRecords.json'));

        /** @var Application $component */
        $component = $this->mockAccessToken(new Application([
            'appId' => 'COMPONENT_APPID',
            'token' => 'COMPONENT_TOKEN'
        ]));

        $miniProgram = $component->miniProgram(
            'mock_app_id', 'mock_refresh_token'
        );
        $miniProgram = $this->mockAccessToken($miniProgram);

        $miniProgram = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/wxa/getillegalrecords', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $miniProgram);

        $client = new Client($miniProgram);

        $startTime = 1600051606;
        $endTime = 1600053000;

        $ret = $client->getIllegalRecords($startTime, $endTime);

        $this->assertIsArray($ret);

        $this->assertSame(json_decode($this->readMockResponseJson('getIllegalRecords.json'), true), $ret);
    }

    public function testGetAppealRecords()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('getAppealRecords.json'));

        /** @var Application $component */
        $component = $this->mockAccessToken(new Application([
            'appId' => 'COMPONENT_APPID',
            'token' => 'COMPONENT_TOKEN'
        ]));

        $miniProgram = $component->miniProgram(
            'mock_app_id', 'mock_refresh_token'
        );
        $miniProgram = $this->mockAccessToken($miniProgram);

        $miniProgram = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/wxa/getappealrecords', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $miniProgram);

        $client = new Client($miniProgram);

        $illegalRecordId = '2_11100';

        $ret = $client->getAppealRecords($illegalRecordId);

        $this->assertIsArray($ret);

        $this->assertSame(json_decode($this->readMockResponseJson('getAppealRecords.json'), true), $ret);
    }

    protected function readMockResponseJson(string $filename): string
    {
        return file_get_contents(__DIR__ . '/mock_data/' . $filename);
    }
}