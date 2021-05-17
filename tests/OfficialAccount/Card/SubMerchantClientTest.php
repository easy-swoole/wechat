<?php

namespace EasySwoole\WeChat\Tests\OfficialAccount\Card;

use EasySwoole\WeChat\Kernel\ServiceContainer;
use EasySwoole\WeChat\OfficialAccount\Card\SubMerchantClient;
use EasySwoole\WeChat\Tests\Mock\Message\Status;
use EasySwoole\WeChat\Tests\TestCase;
use Psr\Http\Message\ServerRequestInterface;

class SubMerchantClientTest extends TestCase
{
    public function testCreate()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('sub_merchant_create.json'));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/card/submerchant/submit', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $info = [
            "brand_name" => "aaaaaa",
            "app_id" => "xxxxxxxxxxx",
            "logo_url" => "http://mmbiz.xxxx",
            "protocol" => "xxxxxxxxxx",
            "agreement_media_id" => "xxxxxxxxxx",
            "operator_media_id" => "xxxxxxxx",
            "end_time" => 1438990559,
            "primary_category_id" => 1,
            "secondary_category_id" => 101
        ];

        $client = new SubMerchantClient($app);
        $this->assertIsArray($client->create($info));
        $this->assertEquals(json_decode($this->readMockResponseJson('sub_merchant_create.json'), true), $client->create($info));
    }

    public function testUpdate()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('sub_merchant_update.json'));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/card/submerchant/update', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $info = [
            "app_id" => "xxxxxxxxxxxxx",
            "brand_name" => "aaaaaa",
            "logo_url" => "http://mmbiz.xxxx",
            "protocol" => "media_id",
            "agreement_media_id" => "xxxxxxxxxx",
            "operator_media_id" => "xxxxxxxx",
            "end_time" => 1438990559,
            "primary_category_id" => 1,
            "secondary_category_id" => 101
        ];

        $client = new SubMerchantClient($app);
        $this->assertIsArray($client->update(12, $info));
        $this->assertEquals(json_decode($this->readMockResponseJson('sub_merchant_update.json'), true), $client->update(12, $info));
    }

    public function testGet()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('sub_merchant_get.json'));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/card/submerchant/get', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new SubMerchantClient($app);
        $this->assertIsArray($client->get(12));
        $this->assertEquals(json_decode($this->readMockResponseJson('sub_merchant_get.json'), true), $client->get(12));
    }

    public function testList()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('sub_merchant_list.json'));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/card/submerchant/batchget', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new SubMerchantClient($app);
        $this->assertIsArray($client->list(0, 50));
        $this->assertEquals(json_decode($this->readMockResponseJson('sub_merchant_list.json'), true), $client->list(0, 50));
    }

    protected function readMockResponseJson(string $file): string
    {
        return file_get_contents(dirname(__FILE__) . '/mock_data/' . $file);
    }
}
