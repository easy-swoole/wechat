<?php
/**
 * User: XueSi
 * Date: 2021/4/26 13:18
 * Author: XueSi <1592328848@qq.com>
 */

namespace EasySwoole\WeChat\Tests\Work\User;


use EasySwoole\WeChat\Kernel\ServiceContainer;
use EasySwoole\WeChat\Tests\Mock\Message\Status;
use EasySwoole\WeChat\Tests\TestCase;
use EasySwoole\WeChat\Work\User\TagClient;
use Psr\Http\Message\ServerRequestInterface;

class TagClientTest extends TestCase
{
    public function testCreate()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('create.json'));

        $app = $this->mockAccessToken(new ServiceContainer([
            'corpId' => 'mock_corpId',
            'corpSecret' => 'mock_corpSecret'
        ]));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/tag/create', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new TagClient($app);

        $this->assertIsArray($client->create('UI'));

        $this->assertSame(json_decode($this->readMockResponseJson('create.json'), true), $client->create('UI'));

        // whith tagId
        $this->assertIsArray($client->create('UI', 12));

        $this->assertSame(json_decode($this->readMockResponseJson('create.json'), true), $client->create('UI', 12));
    }

    public function testUpdate()
    {
        $response = $this->buildResponse(Status::CODE_OK, '{"errcode":0,"errmsg":"updated"}');

        $app = $this->mockAccessToken(new ServiceContainer([
            'corpId' => 'mock_corpId',
            'corpSecret' => 'mock_corpSecret'
        ]));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/tag/update', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new TagClient($app);

        $this->assertTrue($client->update(12, 'UI design'));
    }

    public function testDelete()
    {
        $response = $this->buildResponse(Status::CODE_OK, '{"errcode":0,"errmsg":"deleted"}');

        $app = $this->mockAccessToken(new ServiceContainer([
            'corpId' => 'mock_corpId',
            'corpSecret' => 'mock_corpSecret'
        ]));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('GET', $request->getMethod());
            $this->assertEquals('/cgi-bin/tag/delete', $request->getUri()->getPath());
            $this->assertEquals('tagid=12&access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new TagClient($app);

        $this->assertTrue($client->delete(12));
    }

    public function testGet()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('get.json'));

        $app = $this->mockAccessToken(new ServiceContainer([
            'corpId' => 'mock_corpId',
            'corpSecret' => 'mock_corpSecret'
        ]));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('GET', $request->getMethod());
            $this->assertEquals('/cgi-bin/tag/get', $request->getUri()->getPath());
            $this->assertEquals('tagid=12&access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new TagClient($app);

        $this->assertIsArray($client->get(12));

        $this->assertSame(json_decode($this->readMockResponseJson('get.json'), true), $client->get(12));
    }

    public function testTagUsers()
    {
        $response = $this->buildResponse(Status::CODE_OK, '{"errcode":0,"errmsg":"ok"}');

        $app = $this->mockAccessToken(new ServiceContainer([
            'corpId' => 'mock_corpId',
            'corpSecret' => 'mock_corpSecret'
        ]));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/tag/addtagusers', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new TagClient($app);

        $userList = ['user1', 'user2'];

        $this->assertIsArray($client->tagUsers(12, $userList));

        $this->assertSame(json_decode('{"errcode":0,"errmsg":"ok"}', true), $client->tagUsers(12, $userList));
    }

    public function testTagDepartments()
    {
        $response = $this->buildResponse(Status::CODE_OK, '{"errcode":0,"errmsg":"ok"}');

        $app = $this->mockAccessToken(new ServiceContainer([
            'corpId' => 'mock_corpId',
            'corpSecret' => 'mock_corpSecret'
        ]));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/tag/addtagusers', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new TagClient($app);

        $partyList = [4];

        $this->assertIsArray($client->tagDepartments(12, $partyList));

        $this->assertSame(json_decode('{"errcode":0,"errmsg":"ok"}', true), $client->tagDepartments(12, $partyList));
    }

    public function testUntagUsers()
    {
        $response = $this->buildResponse(Status::CODE_OK, '{"errcode":0,"errmsg":"deleted"}');

        $app = $this->mockAccessToken(new ServiceContainer([
            'corpId' => 'mock_corpId',
            'corpSecret' => 'mock_corpSecret'
        ]));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/tag/deltagusers', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new TagClient($app);

        $userList = ['user1', 'user2'];

        $this->assertIsArray($client->untagUsers(12, $userList));

        $this->assertSame(json_decode('{"errcode":0,"errmsg":"deleted"}', true), $client->untagUsers(12, $userList));
    }

    public function testUntagDepartments()
    {
        $response = $this->buildResponse(Status::CODE_OK, '{"errcode":0,"errmsg":"deleted"}');

        $app = $this->mockAccessToken(new ServiceContainer([
            'corpId' => 'mock_corpId',
            'corpSecret' => 'mock_corpSecret'
        ]));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/tag/deltagusers', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new TagClient($app);

        $partylist = [2, 4];

        $this->assertIsArray($client->untagDepartments(12, $partylist));

        $this->assertSame(json_decode('{"errcode":0,"errmsg":"deleted"}', true), $client->untagDepartments(12, $partylist));
    }

    public function testList()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('list.json'));

        $app = $this->mockAccessToken(new ServiceContainer([
            'corpId' => 'mock_corpId',
            'corpSecret' => 'mock_corpSecret'
        ]));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('GET', $request->getMethod());
            $this->assertEquals('/cgi-bin/tag/list', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new TagClient($app);

        $this->assertIsArray($client->list());

        $this->assertSame(json_decode($this->readMockResponseJson('list.json'), true), $client->list());
    }

    protected function readMockResponseJson(string $filename)
    {
        return file_get_contents(__DIR__ . '/mock_data/TagClient/' . $filename);
    }
}
