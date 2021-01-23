<?php


namespace EasySwoole\WeChat\Tests\OfficialAccount\Card;


use EasySwoole\WeChat\Kernel\ServiceContainer;
use EasySwoole\WeChat\OfficialAccount\Card\GiftCardClient;
use EasySwoole\WeChat\Tests\Mock\Message\Status;
use EasySwoole\WeChat\Tests\TestCase;
use Psr\Http\Message\ServerRequestInterface;

class GiftCardClientTest extends TestCase
{

    public function testAdd()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('gift_card_add.json'));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/card/giftcard/pay/whitelist/add', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new GiftCardClient($app);
        $this->assertIsArray($client->add('1900015421'));
        $this->assertEquals(json_decode($this->readMockResponseJson('gift_card_add.json'), true), $client->add('1900015421'));
    }


    public function testBind()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('gift_card_bind.json'));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/card/giftcard/pay/submch/bind', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new GiftCardClient($app);
        $this->assertTrue($client->bind('1900015421', 'wx8638fbedaf138a87'));
    }

    public function testSet()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('gift_card_set.json'));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/card/giftcard/wxa/set', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new GiftCardClient($app);
        $this->assertTrue($client->set('1900015421', 'asdasdjkafkjaslfjasl'));
    }

    protected function readMockResponseJson(string $file): string
    {
        return file_get_contents(dirname(__FILE__) . '/mock_data/' . $file);
    }
}
