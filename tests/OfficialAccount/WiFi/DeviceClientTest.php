<?php

namespace EasySwoole\WeChat\Tests\OfficialAccount\WiFi;


use EasySwoole\WeChat\Kernel\ServiceContainer;
use EasySwoole\WeChat\OfficialAccount\WiFi\DeviceClient;
use EasySwoole\WeChat\Tests\Mock\Message\Status;
use EasySwoole\WeChat\Tests\TestCase;
use Psr\Http\Message\ServerRequestInterface;

class DeviceClientTest extends TestCase
{

    public function testAddPasswordDevice()
    {

        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('device_add.json'));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/bizwifi/device/add', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new DeviceClient($app);
        $this->assertTrue($client->addPasswordDevice(429620, 'WX123', '12345689'));
    }


    public function testAddPortalDevice()
    {

        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('apportal_register.json'));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/bizwifi/apportal/register', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new DeviceClient($app);
        $this->assertIsArray($client->addPortalDevice(429620, 'WX123', false));
        $this->assertEquals(json_decode($this->readMockResponseJson('apportal_register.json'), true), $client->addPortalDevice(429620, 'WX123', false));
    }

    public function testDelete()
    {

        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('device_delete.json'));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/bizwifi/device/delete', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new DeviceClient($app);
        $this->assertTrue($client->delete('00:1f:7a:ad:5c:a8'));
    }

    public function testList()
    {

        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('device_list.json'));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/bizwifi/device/list', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new DeviceClient($app);
        $this->assertIsArray($client->list(1, 10));
        $this->assertEquals(json_decode($this->readMockResponseJson('device_list.json'), true), $client->list(1, 10));
    }


    public function testListByShopId()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('device_list.json'));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/bizwifi/device/list', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new DeviceClient($app);
        $this->assertIsArray($client->listByShopId(429620, 1, 10));
        $this->assertEquals(json_decode($this->readMockResponseJson('device_list.json'), true), $client->listByShopId(429620, 1, 10));
    }

    private function readMockResponseJson(string $file): string
    {
        return file_get_contents(dirname(__FILE__) . '/mock_data/' . $file);
    }
}