<?php
/**
 * User: XueSi
 * Date: 2021/4/27 20:12
 * Author: XueSi <1592328848@qq.com>
 */

namespace EasySwoole\WeChat\Tests\Work\QrConnect;

use EasySwoole\WeChat\Kernel\ServiceContainer;
use EasySwoole\WeChat\Tests\Mock\Message\Status;
use EasySwoole\WeChat\Tests\TestCase;
use EasySwoole\WeChat\Work\QrConnect\Client;
use EasySwoole\WeChat\Work\QrConnect\User\ExternalUser;
use EasySwoole\WeChat\Work\QrConnect\User\User;
use Psr\Http\Message\ServerRequestInterface;

class ClientTest extends TestCase
{
    public function testRedirect()
    {
        $response = $this->buildResponse(Status::CODE_OK, '{"errcode":0,"errmsg":""}');

        $app = $this->mockAccessToken(new ServiceContainer([
            'corpId' => 'wxCorpId',
            'agentId' => '1000000'
        ]));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
        }, $response, $app);

        $client = new Client($app);

        $mockUrl = 'https://open.work.weixin.qq.com/wwopen/sso/qrConnect?appid=wxCorpId&agentid=1000000&redirect_uri=http%3A%2F%2Fapi.3dept.com&state=weblogin%40gyoss9';

        $this->assertSame($mockUrl, $client->redirect('http://api.3dept.com', 'weblogin@gyoss9'));
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
    }

    protected function readMockResponseJson(string $filename)
    {
        return file_get_contents(__DIR__ . '/mock_data/' . $filename);
    }
}
