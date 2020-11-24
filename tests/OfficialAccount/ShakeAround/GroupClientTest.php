<?php


namespace EasySwoole\WeChat\Tests\OfficialAccount\ShakeAround;


use EasySwoole\WeChat\Kernel\ServiceContainer;
use EasySwoole\WeChat\OfficialAccount\ShakeAround\GroupClient;
use EasySwoole\WeChat\Tests\Mock\Message\Status;
use EasySwoole\WeChat\Tests\TestCase;
use Psr\Http\Message\ServerRequestInterface;

class GroupClientTest extends TestCase
{

    public function testCreate()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('group_create.json'));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/shakearound/device/group/add', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new GroupClient($app);
        $this->assertIsArray($client->create('test'));
        $this->assertEquals(json_decode($this->readMockResponseJson('group_create.json'), true), $client->create('test'));
    }


    public function testUpdate()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('group_update.json'));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/shakearound/device/group/update', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new GroupClient($app);
        $this->assertIsArray($client->update(123, 'test update'));
        $this->assertEquals(json_decode($this->readMockResponseJson('group_update.json'), true), $client->update(123, 'test_update'));
    }


    public function testDelete()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('group_delete.json'));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/shakearound/device/group/delete', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new GroupClient($app);
        $this->assertIsArray($client->delete(123));
        $this->assertEquals(json_decode($this->readMockResponseJson('group_delete.json'), true), $client->delete(123));
    }


    public function testList()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('group_list.json'));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/shakearound/device/group/getlist', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new GroupClient($app);
        $this->assertIsArray($client->list(0, 10));
        $this->assertEquals(json_decode($this->readMockResponseJson('group_list.json'), true), $client->list(0, 10));
    }


    public function testGet()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('group_get.json'));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/shakearound/device/group/getdetail', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new GroupClient($app);
        $this->assertIsArray($client->get(123, 0, 100));
        $this->assertEquals(json_decode($this->readMockResponseJson('group_get.json'), true), $client->get(123, 0, 100));
    }


    public function testAddDevices()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('group_add_devices.json'));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/shakearound/device/group/adddevice', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $data = [
            [
                'device_id' => 10100,
                'uuid' => 'FDA50693-A4E2-4FB1-AFCF-C6EB07647825',
                'major' => 10001,
                'minor' => 10002,
            ],
        ];

        $client = new GroupClient($app);
        $this->assertIsArray($client->addDevices(123, $data));
        $this->assertEquals(json_decode($this->readMockResponseJson('group_add_devices.json'), true), $client->addDevices(123, $data));
    }


    public function testAddRemoveDevices()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('group_remove_devices.json'));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/shakearound/device/group/deletedevice', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $data = [
            [
                'device_id' => 10100,
                'uuid' => 'FDA50693-A4E2-4FB1-AFCF-C6EB07647825',
                'major' => 10001,
                'minor' => 10002,
            ],
        ];

        $client = new GroupClient($app);
        $this->assertIsArray($client->removeDevices(123, $data));
        $this->assertEquals(json_decode($this->readMockResponseJson('group_remove_devices.json'), true), $client->removeDevices(123, $data));
    }

    private function readMockResponseJson(string $file): string
    {
        return file_get_contents(dirname(__FILE__) . '/mock_data/' . $file);
    }
}