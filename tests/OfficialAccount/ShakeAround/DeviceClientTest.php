<?php

namespace EasySwoole\WeChat\Tests\OfficialAccount\ShakeAround;


use EasySwoole\WeChat\Kernel\ServiceContainer;
use EasySwoole\WeChat\OfficialAccount\ShakeAround\DeviceClient;
use EasySwoole\WeChat\Tests\Mock\Message\Status;
use EasySwoole\WeChat\Tests\TestCase;
use Psr\Http\Message\ServerRequestInterface;

class DeviceClientTest extends TestCase
{

    public function testApply()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('device_apply.json'));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/shakearound/device/applyid', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $data = [
            'quantity' => 3,
            'apply_reason' => '测试',
            'comment' => '测试专用',
            'poi_id' => 1234,
        ];

        $client = new DeviceClient($app);
        $this->assertIsArray($client->apply($data));
        $this->assertEquals(json_decode($this->readMockResponseJson('device_apply.json'), true), $client->apply($data));
    }


    public function testStatus()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('device_status.json'));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/shakearound/device/applystatus', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new DeviceClient($app);
        $this->assertIsArray($client->status(12345));
        $this->assertEquals(json_decode($this->readMockResponseJson('device_status.json'), true), $client->status(12345));
    }


    public function testUpdate()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('device_update.json'));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/shakearound/device/update', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $data = [
            'device_id' => 10011,
            'uuid' => 'FDA50693-A4E2-4FB1-AFCF-C6EB07647825',
            'major' => 1002,
            'minor' => 1223,
        ];

        $client = new DeviceClient($app);
        $this->assertIsArray($client->update($data, 'test'));
        $this->assertEquals(json_decode($this->readMockResponseJson('device_update.json'), true), $client->update($data, 'test'));
    }


    public function testBindPoi()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('device_bindpoi.json'));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/shakearound/device/bindlocation', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $data = [
            'device_id' => 10011,
            'uuid' => 'FDA50693-A4E2-4FB1-AFCF-C6EB07647825',
            'major' => 1002,
            'minor' => 1223,
        ];

        $client = new DeviceClient($app);
        $this->assertIsArray($client->bindPoi($data, 1231));
        $this->assertEquals(json_decode($this->readMockResponseJson('device_bindpoi.json'), true), $client->bindPoi($data, 1231));
    }


    public function testBindThirdPoi()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('device_bindthirdpoi.json'));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/shakearound/device/bindlocation', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $data = [
            'device_id' => 10011,
            'uuid' => 'FDA50693-A4E2-4FB1-AFCF-C6EB07647825',
            'major' => 1002,
            'minor' => 1223,
        ];

        $client = new DeviceClient($app);
        $this->assertIsArray($client->bindThirdPoi($data, 1231, 'wxappid'));
        $this->assertEquals(json_decode($this->readMockResponseJson('device_bindthirdpoi.json'), true), $client->bindThirdPoi($data, 1231, 'wxappid'));
    }


    public function testListByIds()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('device_search.json'));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/shakearound/device/search', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $data = [
            [
                'device_id' => 10100,
                'uuid' => 'FDA50693-A4E2-4FB1-AFCF-C6EB07647825',
                'major' => 10001,
                'minor' => 10002,
            ]
        ];

        $client = new DeviceClient($app);
        $this->assertIsArray($client->listByIds($data));
        $this->assertEquals(json_decode($this->readMockResponseJson('device_search.json'), true), $client->listByIds($data));
    }

    public function testList()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('device_search.json'));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/shakearound/device/search', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new DeviceClient($app);
        $this->assertIsArray($client->list(10097, 3));
        $this->assertEquals(json_decode($this->readMockResponseJson('device_search.json'), true), $client->list(10097, 3));
    }

    public function testListByApplyId()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('device_search.json'));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/shakearound/device/search', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new DeviceClient($app);
        $this->assertIsArray($client->listByApplyId(1231, 10097, 3));
        $this->assertEquals(json_decode($this->readMockResponseJson('device_search.json'), true), $client->listByApplyId(1231, 10097, 3));
    }


    public function testSearch()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('device_search.json'));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/shakearound/device/search', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $data = [
            'type' => 1,
            'device_identifiers' => [
                [
                    'device_id' => 10100,
                    'uuid' => 'FDA50693-A4E2-4FB1-AFCF-C6EB07647825',
                    'major' => 10001,
                    'minor' => 10002,
                ],
            ],
        ];

        $client = new DeviceClient($app);
        $this->assertIsArray($client->search($data));
        $this->assertEquals(json_decode($this->readMockResponseJson('device_search.json'), true), $client->search($data));
    }

    private function readMockResponseJson(string $file): string
    {
        return file_get_contents(dirname(__FILE__) . '/mock_data/' . $file);
    }
}
