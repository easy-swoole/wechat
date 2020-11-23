<?php

namespace EasySwoole\WeChat\Tests\OfficialAccount\WiFi;


use EasySwoole\WeChat\Kernel\ServiceContainer;
use EasySwoole\WeChat\OfficialAccount\WiFi\ShopClient;
use EasySwoole\WeChat\Tests\Mock\Message\Status;
use EasySwoole\WeChat\Tests\TestCase;
use Psr\Http\Message\ServerRequestInterface;

class ShopClientTest extends TestCase
{
    public function testGet()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('shop_get.json'));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/bizwifi/shop/get', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new ShopClient($app);
        $this->assertIsArray($client->get(429620));
        $this->assertEquals(json_decode($this->readMockResponseJson('shop_get.json'), true), $client->get(429620));
    }


    public function testList()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('shop_list.json'));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/bizwifi/shop/list', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new ShopClient($app);
        $this->assertIsArray($client->list(1, 10));
        $this->assertEquals(json_decode($this->readMockResponseJson('shop_list.json'), true), $client->list(1, 10));
    }

    public function update()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('shop_update.json'));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/bizwifi/shop/update', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new ShopClient($app);
        $this->assertTrue($client->update(429620, [
            'old_ssid' => 'WX123',
            'ssid' => 'WX567'
        ]));
    }

    public function testClearDevice()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('shop_clean.json'));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/bizwifi/shop/clean', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new ShopClient($app);
        $this->assertTrue($client->clearDevice(429620));
    }

    private function readMockResponseJson(string $file): string
    {
        return file_get_contents(dirname(__FILE__) . '/mock_data/' . $file);
    }
}