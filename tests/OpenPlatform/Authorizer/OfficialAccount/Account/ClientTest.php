<?php
/**
 * Created by PhpStorm.
 * User: XueSi
 * Email: <1592328848@qq.com>
 * Date: 2021/5/11
 * Time: 1:20
 */

namespace EasySwoole\WeChat\Tests\OpenPlatform\Authorizer\OfficialAccount\Account;

use EasySwoole\WeChat\OpenPlatform\Application;
use EasySwoole\WeChat\Tests\Mock\Message\Status;
use EasySwoole\WeChat\Tests\TestCase;
use Psr\Http\Message\ServerRequestInterface;
use EasySwoole\WeChat\OpenPlatform\Authorizer\OfficialAccount\Account\Client;

class ClientTest extends TestCase
{
    public function testGetFastRegistrationUrl()
    {
        /** @var Application $component */
        $component = new Application([
            'appId' => 'COMPONENT_APPID',
            'token' => 'COMPONENT_TOKEN'
        ]);

        $officialAccount = $component->officialAccount(
            'mock_app_id', 'mock_refresh_token'
        );

        $client = new Client($officialAccount, $component);

        $this->assertSame('https://mp.weixin.qq.com/cgi-bin/fastregisterauth?copy_wx_verify=0&component_appid=COMPONENT_APPID&appid=mock_app_id&redirect_uri=https%3A%2F%2Feasyswoole.wechat.com%2Fcallback', $client->getFastRegistrationUrl('https://easyswoole.wechat.com/callback', false));
    }

    public function testRegister()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('register.json'));

        /** @var Application $component */
        $component = $this->mockAccessToken(new Application([
            'appId' => 'COMPONENT_APPID',
            'token' => 'COMPONENT_TOKEN'
        ]));

        $officialAccount = $component->miniProgram(
            'mock_app_id', 'mock_refresh_token'
        );
        $officialAccount = $this->mockAccessToken($officialAccount);

        $officialAccount = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/account/fastregister', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $officialAccount);

        $client = new Client($officialAccount, $component);

        $ret = $client->register('mock_ticket');

        $this->assertIsArray($ret);

        $this->assertSame(json_decode($this->readMockResponseJson('register.json'), true), $ret);
    }

    protected function readMockResponseJson(string $filename): string
    {
        return file_get_contents(__DIR__ . '/mock_data/' . $filename);
    }
}
