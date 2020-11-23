<?php


namespace EasySwoole\WeChat\Tests\OfficialAccount\User;


use EasySwoole\WeChat\Kernel\ServiceContainer;
use EasySwoole\WeChat\Kernel\ServiceProviders;
use EasySwoole\WeChat\OfficialAccount\User\TagClient;
use EasySwoole\WeChat\Tests\Mock\Message\Status;
use EasySwoole\WeChat\Tests\TestCase;
use Psr\Http\Message\ServerRequestInterface;

class TagClientTest extends TestCase
{
    public function testCreate()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('tag_create.json'));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/tags/create', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new TagClient($app);
        $this->assertIsArray($client->create('上海'));
        $this->assertEquals(json_decode($this->readMockResponseJson('tag_create.json'), true), $client->create('上海'));
    }

    public function testList()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('tag_list.json'));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('GET', $request->getMethod());
            $this->assertEquals('/cgi-bin/tags/get', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new TagClient($app);
        $this->assertIsArray($client->list());
        $this->assertEquals(json_decode($this->readMockResponseJson('tag_list.json'), true), $client->list());
    }


    public function testUpdate()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('tag_update.json'));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/tags/update', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new TagClient($app);
        $this->assertTrue($client->update(134, '北京'));
    }


    public function testDelete()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('tag_delete.json'));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/tags/delete', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new TagClient($app);
        $this->assertTrue($client->delete(134));
    }


    public function testUserTags()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('tag_usertags.json'));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/tags/getidlist', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new TagClient($app);
        $this->assertIsArray($client->userTags('ocYxcuBt0mRugKZ7tGAHPnUaOW7Y'));
        $this->assertEquals(json_decode($this->readMockResponseJson('tag_usertags.json'), true), $client->userTags('ocYxcuBt0mRugKZ7tGAHPnUaOW7Y'));
    }


    public function testUsersOfTag()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('tag_useroftags.json'));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/user/tag/get', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new TagClient($app);
        $this->assertIsArray($client->usersOfTag(134));
        $this->assertEquals(json_decode($this->readMockResponseJson('tag_useroftags.json'), true), $client->usersOfTag(134));
    }

    public function testTagUsers()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('tag_tagusers.json'));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/tags/members/batchtagging', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new TagClient($app);
        $this->assertTrue($client->tagUsers(
            [
                "ocYxcuAEy30bX0NXmGn4ypqx3tI0",
                "ocYxcuBt0mRugKZ7tGAHPnUaOW7Y"
            ], 134));
    }


    public function testUntagUsers()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('tag_untagusers.json'));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/tags/members/batchuntagging', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new TagClient($app);
        $this->assertTrue($client->untagUsers(
            [
                "ocYxcuAEy30bX0NXmGn4ypqx3tI0",
                "ocYxcuBt0mRugKZ7tGAHPnUaOW7Y"
            ], 134));
    }

    private function readMockResponseJson(string $file): string
    {
        return file_get_contents(dirname(__FILE__) . '/mock_data/' . $file);
    }
}