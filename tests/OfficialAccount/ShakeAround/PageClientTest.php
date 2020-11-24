<?php


namespace EasySwoole\WeChat\Tests\OfficialAccount\ShakeAround;


use EasySwoole\WeChat\Kernel\ServiceContainer;
use EasySwoole\WeChat\OfficialAccount\ShakeAround\PageClient;
use EasySwoole\WeChat\Tests\Mock\Message\Status;
use EasySwoole\WeChat\Tests\TestCase;
use Psr\Http\Message\ServerRequestInterface;


class PageClientTest extends TestCase
{

    public function testCreate()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('page_create.json'));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/shakearound/page/add', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $data = [
            'title' => '主标题',
            'description' => '副标题',
            'page_url' => ' https://zb.weixin.qq.com ',
            'comment' => '数据示例',
            'icon_url' => 'http://3gimg.qq.com/shake_nearby/dy/icon ',
        ];

        $client = new PageClient($app);
        $this->assertIsArray($client->create($data));
        $this->assertEquals(json_decode($this->readMockResponseJson('page_create.json'), true), $client->create($data));
    }

    public function testUpdate()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('page_update.json'));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/shakearound/page/update', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $data = [
            'title' => '主标题',
            'description' => '副标题',
            'page_url' => ' https://zb.weixin.qq.com ',
            'comment' => '数据示例',
            'icon_url' => 'http://3gimg.qq.com/shake_nearby/dy/icon ',
        ];

        $client = new PageClient($app);
        $this->assertIsArray($client->update(12306, $data));
        $this->assertEquals(json_decode($this->readMockResponseJson('page_update.json'), true), $client->update(12306, $data));
    }


    public function testListByIds()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('page_search.json'));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/shakearound/page/search', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new PageClient($app);
        $this->assertIsArray($client->listByIds([12345, 23456, 34567]));
        $this->assertEquals(json_decode($this->readMockResponseJson('page_search.json'), true), $client->listByIds([12345, 23456, 34567]));
    }


    public function testList()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('page_search.json'));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/shakearound/page/search', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new PageClient($app);
        $this->assertIsArray($client->list(0, 3));
        $this->assertEquals(json_decode($this->readMockResponseJson('page_search.json'), true), $client->list(0, 3));
    }


    public function testDelete()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('page_delete.json'));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/shakearound/page/delete', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new PageClient($app);
        $this->assertIsArray($client->delete(34567));
        $this->assertEquals(json_decode($this->readMockResponseJson('page_delete.json'), true), $client->delete(34567));
    }

    private function readMockResponseJson(string $file): string
    {
        return file_get_contents(dirname(__FILE__) . '/mock_data/' . $file);
    }
}
