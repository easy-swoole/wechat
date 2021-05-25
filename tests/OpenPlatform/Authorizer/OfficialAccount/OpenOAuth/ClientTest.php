<?php
/**
 * Created by PhpStorm.
 * User: XueSi
 * Email: <1592328848@qq.com>
 * Date: 2021/5/11
 * Time: 2:02
 */

namespace EasySwoole\WeChat\Tests\OpenPlatform\Authorizer\OfficialAccount\OpenOAuth;

use EasySwoole\WeChat\OpenPlatform\Authorizer\OfficialAccount\OpenOAuth\User;
use EasySwoole\WeChat\Tests\TestCase;
use EasySwoole\WeChat\Tests\Mock\Message\Status;
use EasySwoole\WeChat\OpenPlatform\Application;
use Psr\Http\Message\ServerRequestInterface;
use EasySwoole\WeChat\OpenPlatform\Authorizer\OfficialAccount\OpenOAuth\Client;

class ClientTest extends TestCase
{
    public function testRedirect()
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

        $this->assertSame('https://open.weixin.qq.com/connect/oauth2/authorize?appid=mock_app_id&redirect_uri=REDIRECT_URI&response_type=code&scope=SCOPE&state=STATE#wechat_redirect', $client->redirect('REDIRECT_URI', 'SCOPE', 'STATE'));
    }

    public function testSnsAuthFromCode()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('snsAuthFromCode.json'));

        /** @var Application $component */
        $component = $this->mockAccessToken(new Application([
            'appId' => 'COMPONENT_APPID',
            'token' => 'COMPONENT_TOKEN'
        ]));

        $component = $this->mockAccessToken($component);

        $officialAccount = $component->officialAccount(
            'mock_app_id', 'mock_refresh_token'
        );

        $officialAccount = $this->mockAccessToken($officialAccount);

        $officialAccount = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('GET', $request->getMethod());
            $this->assertEquals('/sns/oauth2/component/access_token', $request->getUri()->getPath());
            $this->assertEquals('appid=mock_app_id&code=mock_code&grant_type=authorization_code&component_access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $officialAccount);

        $client = new Client($officialAccount, $component);

        $ret = $client->snsAuthFromCode('mock_code');

        $this->assertIsArray($ret);

        $this->assertSame(json_decode($this->readMockResponseJson('snsAuthFromCode.json'), true), $ret);
    }

    public function testUserFromToken()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('userFromToken.json'));

        /** @var Application $component */
        $component = $this->mockAccessToken(new Application([
            'appId' => 'COMPONENT_APPID',
            'token' => 'COMPONENT_TOKEN'
        ]));

        $component = $this->mockAccessToken($component);

        $officialAccount = $component->officialAccount(
            'mock_app_id', 'mock_refresh_token'
        );

        $officialAccount = $this->mockAccessToken($officialAccount);

        $officialAccount = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('GET', $request->getMethod());
            $this->assertEquals('/sns/userinfo', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_token&openid=mock_openId&lang=zh_CN', $request->getUri()->getQuery());
        }, $response, $officialAccount);

        $client = new Client($officialAccount, $component);

        /** @var User $userObj */
        $userObj = $client->userFromToken('mock_token', 'mock_openId', 'zh_CN');

        $this->assertInstanceOf(User::class, $userObj);

        $this->assertIsArray($userObj->getRaw());

        $mockUserArr = json_decode($this->readMockResponseJson('userFromToken.json'), true);

        $this->assertSame($mockUserArr, $userObj->getRaw());

        $this->assertSame($mockUserArr['openid'], $userObj->getId());

        $this->assertSame($mockUserArr['nickname'], $userObj->getNickname());

        $this->assertSame($mockUserArr['headimgurl'], $userObj->getAvatar());
    }

    protected function readMockResponseJson(string $filename): string
    {
        return file_get_contents(__DIR__ . '/mock_data/' . $filename);
    }
}
