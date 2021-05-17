<?php
/**
 * Created by PhpStorm.
 * User: XueSi
 * Email: <1592328848@qq.com>
 * Date: 2021/5/18
 * Time: 0:52
 */

namespace EasySwoole\WeChat\Tests\OfficialAccount\OAuth;

use EasySwoole\WeChat\OfficialAccount\Application;
use EasySwoole\WeChat\OfficialAccount\OAuth\Client;
use EasySwoole\WeChat\OfficialAccount\OAuth\User;
use EasySwoole\WeChat\Tests\Mock\Message\Status;
use EasySwoole\WeChat\Tests\TestCase;
use Psr\Http\Message\ServerRequestInterface;

class ClientTest extends TestCase
{
    public function testRedirect()
    {
        $officialAccount = new Application([
            'appId' => 'mock_appId',
            'appSecret' => 'mock_appSecret'
        ]);

        $client = new Client($officialAccount);

        $this->assertSame('https://open.weixin.qq.com/connect/oauth2/authorize?appid=mock_appId&redirect_uri=REDIRECT_URI&response_type=code&scope=SCOPE&state=STATE#wechat_redirect', $client->redirect('REDIRECT_URI', 'SCOPE', 'STATE'));
    }

    public function testSnsAuthFromCode()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('snsAuthFromCode.json'));

        $officialAccount = new Application([
            'appId' => 'mock_appId',
            'appSecret' => 'mock_appSecret'
        ]);

        $officialAccount = $this->mockAccessToken($officialAccount);

        $officialAccount = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('GET', $request->getMethod());
            $this->assertEquals('/sns/oauth2/access_token', $request->getUri()->getPath());
            $this->assertEquals('appid=mock_appId&secret=mock_appSecret&code=mock_code&grant_type=authorization_code', $request->getUri()->getQuery());
        }, $response, $officialAccount);

        $client = new Client($officialAccount);

        $ret = $client->snsAuthFromCode('mock_code');

        $this->assertIsArray($ret);

        $this->assertSame(json_decode($this->readMockResponseJson('snsAuthFromCode.json'), true), $ret);
    }

    public function testUserFromToken()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('userFromToken.json'));

        $officialAccount = new Application([
            'appId' => 'mock_appId',
            'appSecret' => 'mock_appSecret'
        ]);

        $officialAccount = $this->mockAccessToken($officialAccount);

        $officialAccount = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('GET', $request->getMethod());
            $this->assertEquals('/sns/userinfo', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_token&openid=mock_openId&lang=zh_CN', $request->getUri()->getQuery());
        }, $response, $officialAccount);

        $client = new Client($officialAccount);

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