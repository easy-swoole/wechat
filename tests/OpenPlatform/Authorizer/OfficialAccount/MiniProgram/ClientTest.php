<?php
/**
 * Created by PhpStorm.
 * User: XueSi
 * Email: <1592328848@qq.com>
 * Date: 2021/5/11
 * Time: 1:55
 */

namespace EasySwoole\WeChat\Tests\OpenPlatform\Authorizer\OfficialAccount\MiniProgram;


use EasySwoole\WeChat\Tests\TestCase;
use EasySwoole\WeChat\Tests\Mock\Message\Status;
use EasySwoole\WeChat\OpenPlatform\Application;
use Psr\Http\Message\ServerRequestInterface;
use EasySwoole\WeChat\OpenPlatform\Authorizer\OfficialAccount\MiniProgram\Client;

class ClientTest extends TestCase
{
    public function testList()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('list.json'));

        /** @var Application $component */
        $component = $this->mockAccessToken(new Application([
            'appId' => 'COMPONENT_APPID',
            'token' => 'COMPONENT_TOKEN',
        ]));

        $officialAccount = $component->officialAccount(
            'mock_app_id', 'mock_refresh_token'
        );
        $officialAccount = $this->mockAccessToken($officialAccount);

        $officialAccount = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/wxopen/wxamplinkget', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $officialAccount);

        $client = new Client($officialAccount);

        $ret = $client->list();

        $this->assertIsArray($ret);

        $this->assertSame(json_decode($this->readMockResponseJson('list.json'), true), $ret);
    }

    public function testLink()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('list.json'));

        /** @var Application $component */
        $component = $this->mockAccessToken(new Application([
            'appId' => 'COMPONENT_APPID',
            'token' => 'COMPONENT_TOKEN',
        ]));

        $officialAccount = $component->officialAccount(
            'mock_app_id', 'mock_refresh_token'
        );
        $officialAccount = $this->mockAccessToken($officialAccount);

        $officialAccount = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/wxopen/wxamplink', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $officialAccount);

        $client = new Client($officialAccount);

        $this->assertTrue($client->link('xxxxxx', '1', '1'));
    }

    public function testUnlink()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('list.json'));

        /** @var Application $component */
        $component = $this->mockAccessToken(new Application([
            'appId' => 'COMPONENT_APPID',
            'token' => 'COMPONENT_TOKEN',
        ]));

        $officialAccount = $component->officialAccount(
            'mock_app_id', 'mock_refresh_token'
        );
        $officialAccount = $this->mockAccessToken($officialAccount);

        $officialAccount = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/wxopen/wxampunlink', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $officialAccount);

        $client = new Client($officialAccount);

        $this->assertTrue($client->unlink('xxxxxx'));
    }

    protected function readMockResponseJson(string $filename): string
    {
        return file_get_contents(__DIR__ . '/mock_data/' . $filename);
    }
}
