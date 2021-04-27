<?php
/**
 * User: XueSi
 * Date: 2021/4/26 13:06
 * Author: XueSi <1592328848@qq.com>
 */

namespace EasySwoole\WeChat\Tests\Work\User;


use EasySwoole\WeChat\Kernel\ServiceContainer;
use EasySwoole\WeChat\Tests\Mock\Message\Status;
use EasySwoole\WeChat\Tests\TestCase;
use EasySwoole\WeChat\Work\User\LinkedCorpClient;
use Psr\Http\Message\ServerRequestInterface;

class LinkedCorpClientTest extends TestCase
{
    public function testGetAgentPermissions()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('getAgentPermissions.json'));

        $app = $this->mockAccessToken(new ServiceContainer([
            'corpId' => 'mock_corpId',
            'corpSecret' => 'mock_corpSecret'
        ]));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/linkedcorp/agent/get_perm_list', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new LinkedCorpClient($app);

        $this->assertIsArray($client->getAgentPermissions());

        $this->assertSame(json_decode($this->readMockResponseJson('getAgentPermissions.json'), true), $client->getAgentPermissions());
    }

    public function testGetUser()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('getUser.json'));

        $app = $this->mockAccessToken(new ServiceContainer([
            'corpId' => 'mock_corpId',
            'corpSecret' => 'mock_corpSecret'
        ]));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/linkedcorp/user/get', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new LinkedCorpClient($app);

        $this->assertIsArray($client->getUser('CORPID/USERID'));

        $this->assertSame(json_decode($this->readMockResponseJson('getUser.json'), true), $client->getUser('CORPID/USERID'));
    }

    public function testGetUsers()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('getUsers.json'));

        $app = $this->mockAccessToken(new ServiceContainer([
            'corpId' => 'mock_corpId',
            'corpSecret' => 'mock_corpSecret'
        ]));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/linkedcorp/user/simplelist', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new LinkedCorpClient($app);

        $this->assertIsArray($client->getUsers('LINKEDID/DEPARTMENTID'));

        $this->assertSame(json_decode($this->readMockResponseJson('getUsers.json'), true), $client->getUsers('LINKEDID/DEPARTMENTID'));
    }

    public function testGetDetailedUsers()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('getDetailedUsers.json'));

        $app = $this->mockAccessToken(new ServiceContainer([
            'corpId' => 'mock_corpId',
            'corpSecret' => 'mock_corpSecret'
        ]));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/linkedcorp/user/list', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new LinkedCorpClient($app);

        $this->assertIsArray($client->getDetailedUsers('LINKEDID/DEPARTMENTID'));

        $this->assertSame(json_decode($this->readMockResponseJson('getDetailedUsers.json'), true), $client->getDetailedUsers('LINKEDID/DEPARTMENTID'));
    }

    public function testGetDepartments()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('getDepartments.json'));

        $app = $this->mockAccessToken(new ServiceContainer([
            'corpId' => 'mock_corpId',
            'corpSecret' => 'mock_corpSecret'
        ]));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/linkedcorp/department/list', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new LinkedCorpClient($app);

        $this->assertIsArray($client->getDepartments('LINKEDID/DEPARTMENTID'));

        $this->assertSame(json_decode($this->readMockResponseJson('getDepartments.json'), true), $client->getDepartments('LINKEDID/DEPARTMENTID'));
    }

    protected function readMockResponseJson(string $filename)
    {
        return file_get_contents(__DIR__ . '/mock_data/LinkedCorpClient/' . $filename);
    }
}
