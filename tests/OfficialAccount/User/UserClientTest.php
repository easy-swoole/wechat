<?php

namespace EasySwoole\WeChat\Tests\OfficialAccount\User;


use EasySwoole\WeChat\Kernel\ServiceContainer;
use EasySwoole\WeChat\OfficialAccount\User\UserClient;
use EasySwoole\WeChat\Tests\Mock\Message\Status;
use EasySwoole\WeChat\Tests\TestCase;
use Psr\Http\Message\ServerRequestInterface;

class UserClientTest extends TestCase
{
    public function testGet()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('user_info.json'));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('GET', $request->getMethod());
            $this->assertEquals('/cgi-bin/user/info', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token&openid=otvxTs4dckWG7imySrJd6jSi0CWE&lang=zh_CN', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new UserClient($app);
        $this->assertIsArray($client->get('otvxTs4dckWG7imySrJd6jSi0CWE'));
        $this->assertEquals(json_decode($this->readMockResponseJson('user_info.json'), true), $client->get('otvxTs4dckWG7imySrJd6jSi0CWE'));
    }

    public function testSelect()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('user_select.json'));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/user/info/batchget', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new UserClient($app);
        $this->assertIsArray($client->select(['otvxTs4dckWG7imySrJd6jSi0CWE', 'otvxTs_JZ6SEiP0imdhpi50fuSZg']));
        $this->assertEquals(json_decode($this->readMockResponseJson('user_select.json'), true), $client->select(['otvxTs4dckWG7imySrJd6jSi0CWE', 'otvxTs_JZ6SEiP0imdhpi50fuSZg']));
    }


    public function testList()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('user_list.json'));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('GET', $request->getMethod());
            $this->assertEquals('/cgi-bin/user/get', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new UserClient($app);
        $this->assertIsArray($client->list());
        $this->assertEquals(json_decode($this->readMockResponseJson('user_list.json'), true), $client->list());
    }

    public function testRemark()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('user_remark.json'));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/user/info/updateremark', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new UserClient($app);
        $this->assertTrue($client->remark('oDF3iY9ffA-hqb2vVvbr7qxf6A0Q', 'pangzi'));
    }

    public function testBlacklist()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('user_blacklist.json'));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/tags/members/getblacklist', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new UserClient($app);
        $this->assertIsArray($client->blacklist('OPENID1'));
        $this->assertEquals(json_decode($this->readMockResponseJson('user_blacklist.json'), true), $client->blacklist('OPENID1'));
    }

    public function testBlock()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('user_block.json'));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/tags/members/batchblacklist', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new UserClient($app);
        $this->assertTrue($client->block(['OPENID1', 'OPENID2']));
    }


    public function testUnblock()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('user_unblock.json'));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/tags/members/batchunblacklist', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new UserClient($app);
        $this->assertTrue($client->unblock(['OPENID1', 'OPENID2']));
    }


    public function testChangeOpenid()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('user_changeopenid.json'));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/changeopenid', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new UserClient($app);
        $this->assertIsArray($client->changeOpenid('OPENID1', ["oEmYbwN-n24jxvk4Sox81qedINkQ", "oEmYbwH9uVd4RKJk7ZZg6SzL6tTo"]));
        $this->assertEquals(json_decode($this->readMockResponseJson('user_changeopenid.json'), true), $client->changeOpenid('OPENID1', ["oEmYbwN-n24jxvk4Sox81qedINkQ", "oEmYbwH9uVd4RKJk7ZZg6SzL6tTo"]));
    }

    private function readMockResponseJson(string $file): string
    {
        return file_get_contents(dirname(__FILE__) . '/mock_data/' . $file);
    }
}