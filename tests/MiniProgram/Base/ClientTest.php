<?php
/**
 * Created by PhpStorm.
 * User: XueSi
 * Email: <1592328848@qq.com>
 * Date: 2021/5/6
 * Time: 0:18
 */

namespace EasySwoole\WeChat\Tests\MiniProgram\Base;


use EasySwoole\WeChat\Tests\TestCase;
use EasySwoole\WeChat\Kernel\ServiceContainer;
use EasySwoole\WeChat\Tests\Mock\Message\Status;
use Psr\Http\Message\ServerRequestInterface;
use EasySwoole\WeChat\MiniProgram\Base\Client;

class ClientTest extends TestCase
{
    // 使用微信支付订单号获取
    public function testGetPaidUnionid1()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('getPaidUnionid.json'));

        $app = $this->mockAccessToken(new ServiceContainer([
            'appId' => 'mock_appid',
            'appSecret' => 'mock_secret'
        ]));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('GET', $request->getMethod());
            $this->assertEquals('/wxa/getpaidunionid', $request->getUri()->getPath());
            $this->assertEquals('openid=mock_openid&transaction_id=mock_transaction_id&access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        $this->assertIsArray($client->getPaidUnionid('mock_openid', [
            'transaction_id' => 'mock_transaction_id'
        ]));

        $this->assertSame(json_decode($this->readMockResponseJson('getPaidUnionid.json'), true), $client->getPaidUnionid('mock_openid', [
            'transaction_id' => 'mock_transaction_id'
        ]));
    }

    // 使用微信支付商户订单号和微信支付商户号（out_trade_no 及 mch_id）获取
    public function testGetPaidUnionid2()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('getPaidUnionid.json'));

        $app = $this->mockAccessToken(new ServiceContainer([
            'appId' => 'mock_appid',
            'appSecret' => 'mock_secret'
        ]));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('GET', $request->getMethod());
            $this->assertEquals('/wxa/getpaidunionid', $request->getUri()->getPath());
            $this->assertEquals('openid=mock_openid&mch_id=mock_mch_id&out_trade_no=mock_out_trade_no&access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        $this->assertIsArray($client->getPaidUnionid('mock_openid', [
            'mch_id' => 'mock_mch_id',
            'out_trade_no' => 'mock_out_trade_no'
        ]));

        $this->assertSame(json_decode($this->readMockResponseJson('getPaidUnionid.json'), true), $client->getPaidUnionid('mock_openid', [
            'mch_id' => 'mock_mch_id',
            'out_trade_no' => 'mock_out_trade_no'
        ]));
    }

    private function readMockResponseJson($filename)
    {
        return file_get_contents(__DIR__ . '/mock_data/' . $filename);
    }
}