<?php
/**
 * User: XueSi
 * Date: 2021/4/27 19:55
 * Author: XueSi <1592328848@qq.com>
 */

namespace EasySwoole\WeChat\Tests\Work\OAuth;


use EasySwoole\WeChat\Kernel\ServiceContainer;
use EasySwoole\WeChat\Tests\Mock\Message\Status;
use EasySwoole\WeChat\Tests\TestCase;
use EasySwoole\WeChat\Work\OAuth\Client;
use EasySwoole\WeChat\Work\OAuth\User\ExternalUser;
use EasySwoole\WeChat\Work\OAuth\User\User;
use Psr\Http\Message\ServerRequestInterface;

class ClientTest extends TestCase
{
    public function testRedirect()
    {
        $response = $this->buildResponse(Status::CODE_OK, '{"errcode":0,"errmsg":""}');

        $app = $this->mockAccessToken(new ServiceContainer([
            'corpId' => 'wxCorpId'
        ]));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
        }, $response, $app);

        $client = new Client($app);

        $mockUrl = 'https://open.weixin.qq.com/connect/oauth2/authorize?appid=wxCorpId&redirect_uri=http%3A%2F%2Fapi.3dept.com%2Fcgi-bin%2Fquery%3Faction%3Dget&response_type=code&scope=snsapi_base&state=#wechat_redirect';

        $this->assertSame($mockUrl, $client->redirect('http://api.3dept.com/cgi-bin/query?action=get'));
    }

    public function testUserFromCode()
    {
        // 企业用户
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('user.json'));

        $app = $this->mockAccessToken(new ServiceContainer([
            'corpId' => 'wxCorpId',
            'corpSecret' => 'mock_corpSecret'
        ]));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('GET', $request->getMethod());
            $this->assertEquals('/cgi-bin/user/getuserinfo', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token&code=mock_code', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        $this->assertInstanceOf(User::class, $client->userFromCode('mock_code'));

        $mockUserArr = json_decode($this->readMockResponseJson('user.json'), true);

        $this->assertSame($mockUserArr, $client->userFromCode('mock_code')->getRaw());

        $this->assertSame($mockUserArr['UserId'], $client->userFromCode('mock_code')->getUserId());

        $this->assertSame($mockUserArr['DeviceId'], $client->userFromCode('mock_code')->getDeviceId());


        // 非企业用户
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('external_user.json'));

        $app = $this->mockAccessToken(new ServiceContainer([
            'corpId' => 'wxCorpId',
            'corpSecret' => 'mock_corpSecret'
        ]));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('GET', $request->getMethod());
            $this->assertEquals('/cgi-bin/user/getuserinfo', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token&code=mock_code', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        $this->assertInstanceOf(ExternalUser::class, $client->userFromCode('mock_code'));

        $mockUserArr = json_decode($this->readMockResponseJson('external_user.json'), true);

        $this->assertSame($mockUserArr, $client->userFromCode('mock_code')->getRaw());

        $this->assertSame($mockUserArr['OpenId'], $client->userFromCode('mock_code')->getOpenId());

        $this->assertSame($mockUserArr['DeviceId'], $client->userFromCode('mock_code')->getDeviceId());

        $this->assertSame($mockUserArr['external_userid'], $client->userFromCode('mock_code')->getExternalUserId());
    }

    protected function readMockResponseJson(string $filename)
    {
        return file_get_contents(__DIR__ . '/mock_data/' . $filename);
    }
}
