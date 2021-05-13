<?php


namespace EasySwoole\WeChat\Tests\OfficialAccount\Card;


use EasySwoole\WeChat\Kernel\ServiceContainer;
use EasySwoole\WeChat\OfficialAccount\Card\GiftCardOrderClient;
use EasySwoole\WeChat\Tests\Mock\Message\Status;
use EasySwoole\WeChat\Tests\TestCase;
use Psr\Http\Message\ServerRequestInterface;

class GiftCardOrderClientTest extends TestCase
{
    public function testGet()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJsonByFunction(__FUNCTION__));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/card/giftcard/order/get', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new GiftCardOrderClient($app);
        $this->assertIsArray($client->get('Z2y2rY74ksZX1ceuGA'));
        $this->assertEquals($this->readMockResponseJsonByFunction(__FUNCTION__, true), $client->get('Z2y2rY74ksZX1ceuGA'));
    }

    public function testList()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJsonByFunction(__FUNCTION__));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/card/giftcard/order/batchget', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new GiftCardOrderClient($app);
        $this->assertIsArray($client->list(1472400000, 1472716604));
        $this->assertEquals($this->readMockResponseJsonByFunction(__FUNCTION__, true), $client->list(1472400000, 1472716604));
    }

    public function testRefund()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJsonByFunction(__FUNCTION__));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/card/giftcard/order/refund', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new GiftCardOrderClient($app);
        $this->assertTrue($client->refund('xxx'));
    }

    protected function readMockResponseJsonByFunction(string $func, bool $jsonDecode = false)
    {
        $fileName = strtolower(preg_replace('/(.)(?=[A-Z])/u', '$1' . '_', ltrim($func, 'test'))) . '.json';
        $ret = file_get_contents(dirname(__FILE__) . '/mock_data/gift_card_order_' . $fileName);
        return $jsonDecode ? json_decode($ret, true) : $ret;
    }
}
