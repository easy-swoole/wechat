<?php
/**
 * User: XueSi
 * Date: 2021/4/23 17:11
 * Author: XueSi <1592328848@qq.com>
 */

namespace EasySwoole\WeChat\Tests\OpenPlatform\Authorizer\Aggregate\Account;

use EasySwoole\WeChat\OpenPlatform\Application;
use EasySwoole\WeChat\Tests\Mock\Message\Status;
use EasySwoole\WeChat\Tests\TestCase;
use Psr\Http\Message\ServerRequestInterface;
use EasySwoole\WeChat\OpenPlatform\Authorizer\Aggregate\Account\Client;

class ClientTest extends TestCase
{
    // 测试创建开放平台账号并绑定公众号/小程序
    public function testCreate()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('create.json'));

        $app = new Application([
            'appId' => 'component-app-id',
            'appSecret' => 'component-secret',
            'token' => 'component-token',
            'aesKey' => 'Qqx2S6jV3mp5prWPg5x3eBmeU1kLayZio4Q9ZxWTbmf'
        ]);

        /** @var Application $app */
        $app = $this->mockAccessToken($app);

        // 创建开放平台账号并绑定公众号
        $officialAccount = $app->officialAccount('mock_app_id', 'mock_refresh_token');
        $officialAccount = $this->mockAccessToken($officialAccount);

        $officialAccount = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/open/create', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $officialAccount);

        $client = new Client($officialAccount, $app);

        $this->assertIsArray($client->create());

        $this->assertEquals(json_decode($this->readMockResponseJson('create.json'), true), $client->create());


        // 创建开放平台账号并绑定小程序
        $miniProgram = $app->miniProgram('mock_app_id', 'mock_refresh_token');
        $miniProgram = $this->mockAccessToken($miniProgram);

        $miniProgram = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/open/create', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $miniProgram);

        $client = new Client($miniProgram, $app);

        $this->assertIsArray($client->create());

        $this->assertEquals(json_decode($this->readMockResponseJson('create.json'), true), $client->create());
    }

    // 测试将公众号/小程序绑定到开放平台账号下
    public function testBindTo()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('bindTo.json'));

        $app = new Application([
            'appId' => 'component-app-id',
            'appSecret' => 'component-secret',
            'token' => 'component-token',
            'aesKey' => 'Qqx2S6jV3mp5prWPg5x3eBmeU1kLayZio4Q9ZxWTbmf'
        ]);

        /** @var Application $app */
        $app = $this->mockAccessToken($app);

        // 将公众号绑定到开放平台账号下
        $officialAccount = $app->officialAccount('mock_app_id', 'mock_refresh_token');
        $officialAccount = $this->mockAccessToken($officialAccount);

        $officialAccount = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/open/bind', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $officialAccount);

        $client = new Client($officialAccount, $app);

        $this->assertTrue($client->bindTo('open_appid_value'));


        // 将小程序绑定到开放平台账号下
        $miniProgram = $app->miniProgram('mock_app_id', 'mock_refresh_token');
        $miniProgram = $this->mockAccessToken($miniProgram);

        $miniProgram = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/open/bind', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $miniProgram);

        $client = new Client($miniProgram, $app);

        $this->assertTrue($client->bindTo('open_appid_value'));
    }

    // 测试将公众号/小程序从开放平台帐号下解绑
    public function testUnbindFrom()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('unbindFrom.json'));

        $app = new Application([
            'appId' => 'component-app-id',
            'appSecret' => 'component-secret',
            'token' => 'component-token',
            'aesKey' => 'Qqx2S6jV3mp5prWPg5x3eBmeU1kLayZio4Q9ZxWTbmf'
        ]);

        /** @var Application $app */
        $app = $this->mockAccessToken($app);

        // 将公众号从开放平台账号下解绑
        $officialAccount = $app->officialAccount('mock_app_id', 'mock_refresh_token');
        $officialAccount = $this->mockAccessToken($officialAccount);

        $officialAccount = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/open/unbind', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $officialAccount);

        $client = new Client($officialAccount, $app);

        $this->assertTrue($client->unbindFrom('open_appid_value'));


        // 将小程序从开放平台账号下解绑
        $miniProgram = $app->miniProgram('mock_app_id', 'mock_refresh_token');
        $miniProgram = $this->mockAccessToken($miniProgram);

        $miniProgram = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/open/unbind', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $miniProgram);

        $client = new Client($miniProgram, $app);

        $this->assertTrue($client->unbindFrom('open_appid_value'));
    }

    // 测试获取公众号/小程序所绑定的开放平台帐号
    public function testGetBinding()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('getBinding.json'));

        $app = new Application([
            'appId' => 'component-app-id',
            'appSecret' => 'component-secret',
            'token' => 'component-token',
            'aesKey' => 'Qqx2S6jV3mp5prWPg5x3eBmeU1kLayZio4Q9ZxWTbmf'
        ]);

        /** @var Application $app */
        $app = $this->mockAccessToken($app);

        // 获取公众号所绑定的开放平台帐号
        $officialAccount = $app->officialAccount('mock_app_id', 'mock_refresh_token');
        $officialAccount = $this->mockAccessToken($officialAccount);

        $officialAccount = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/open/get', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $officialAccount);

        $client = new Client($officialAccount, $app);

        $this->assertIsArray($client->getBinding());

        $this->assertEquals(json_decode($this->readMockResponseJson('getBinding.json'), true), $client->getBinding());


        // 获取公众号/小程序所绑定的开放平台帐号
        $miniProgram = $app->miniProgram('mock_app_id', 'mock_refresh_token');
        $miniProgram = $this->mockAccessToken($miniProgram);

        $miniProgram = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/open/get', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $miniProgram);

        $client = new Client($miniProgram, $app);

        $this->assertIsArray($client->getBinding());

        $this->assertEquals(json_decode($this->readMockResponseJson('getBinding.json'), true), $client->getBinding());
    }

    protected function readMockResponseJson(string $filename): string
    {
        return file_get_contents(__DIR__ . '/mock_data/' . $filename);
    }
}
