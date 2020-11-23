<?php

namespace EasySwoole\WeChat\Tests\OfficialAccount\WiFi;


use EasySwoole\WeChat\Kernel\ServiceContainer;
use EasySwoole\WeChat\OfficialAccount\WiFi\CardClient;
use EasySwoole\WeChat\Tests\Mock\Message\Status;
use EasySwoole\WeChat\Tests\TestCase;
use Psr\Http\Message\ServerRequestInterface;

class CardClientTest extends TestCase
{
    public function testSet()
    {

        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('couponput_set.json'));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/bizwifi/couponput/set', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new CardClient($app);
        $this->assertTrue($client->set([
            'shop_id' => 429620,
            'card_id' => 'pBnTrjvZJXkZsPGwfq9F0Hl0WqE',
            'card_describe' => '10元代金券',
            'start_time' => 1457280000,
            'end_time' => 1457712000
        ]));
    }

    public function testGet()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('couponput_get.json'));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/bizwifi/couponput/get', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new CardClient($app);
        $this->assertIsArray($client->get(429620));
        $this->assertEquals(json_decode($this->readMockResponseJson('couponput_get.json'), true), $client->get(429620));

    }

    private function readMockResponseJson(string $file): string
    {
        return file_get_contents(dirname(__FILE__) . '/mock_data/' . $file);
    }
}