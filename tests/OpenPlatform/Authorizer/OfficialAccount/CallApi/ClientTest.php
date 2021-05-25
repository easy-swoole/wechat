<?php
/**
 * Created by PhpStorm.
 * User: XueSi
 * Email: <1592328848@qq.com>
 * Date: 2021/5/11
 * Time: 1:42
 */

namespace EasySwoole\WeChat\Tests\OpenPlatform\Authorizer\OfficialAccount\CallApi;

use EasySwoole\WeChat\Tests\Mock\Message\Status;
use EasySwoole\WeChat\Tests\TestCase;
use EasySwoole\WeChat\OpenPlatform\Application;
use Psr\Http\Message\ServerRequestInterface;
use EasySwoole\WeChat\OpenPlatform\Authorizer\OfficialAccount\CallApi\Client;

class ClientTest extends TestCase
{
    public function testClearQuota()
    {
        $response = $this->buildResponse(Status::CODE_OK, '{"errcode":0,"errmsg":"ok"}');

        /** @var Application $component */
        $component = $this->mockAccessToken(new Application([
            'appId' => 'COMPONENT_APPID',
            'token' => 'COMPONENT_TOKEN'
        ]));

        $officialAccount = $component->officialAccount(
            'mock_app_id', 'mock_refresh_token'
        );
        $officialAccount = $this->mockAccessToken($officialAccount);

        $officialAccount = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/clear_quota', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $officialAccount);

        $client = new Client($officialAccount, $component);

        $this->assertTrue($client->clearQuota());
    }

    public function testClearComponentQuota()
    {
        $response = $this->buildResponse(Status::CODE_OK, '{"errcode":0,"errmsg":"ok"}');

        /** @var Application $component */
        $component = $this->mockAccessToken(new Application([
            'appId' => 'COMPONENT_APPID',
            'token' => 'COMPONENT_TOKEN'
        ]));

        $officialAccount = $component->officialAccount(
            'mock_app_id', 'mock_refresh_token'
        );
        $officialAccount = $this->mockAccessToken($officialAccount);

        $officialAccount = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/component/clear_quota', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $officialAccount);

        $client = new Client($officialAccount, $component);

        $this->assertTrue($client->clearComponentQuota());
    }

    protected function readMockResponseJson(string $filename): string
    {
        return file_get_contents(__DIR__ . '/mock_data/' . $filename);
    }
}
