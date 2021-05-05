<?php
/**
 * Created by PhpStorm.
 * User: XueSi
 * Email: <1592328848@qq.com>
 * Date: 2021/5/5
 * Time: 18:29
 */

namespace EasySwoole\WeChat\Tests\MiniProgram\Express;

use EasySwoole\WeChat\Kernel\ServiceContainer;
use EasySwoole\WeChat\Tests\Mock\Message\Status;
use EasySwoole\WeChat\Tests\TestCase;
use Psr\Http\Message\ServerRequestInterface;
use EasySwoole\WeChat\MiniProgram\Express\Client;

class ClientTest extends TestCase
{
    public function testCreateWaybill()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('createWaybill.json'));

        $app = $this->mockAccessToken(new ServiceContainer([
            'appId' => 'mock_appid',
            'appSecret' => 'mock_secret'
        ]));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/express/business/order/add', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        $data = [
            'add_source' => 0,
            'order_id' => '01234567890123456789',
            'openid' => 'oABC123456',
            'delivery_id' => 'SF',
            'biz_id' => 'xyz',
            'custom_remark' => '易碎物品',
            'sender' => [
                'name' => '张三',
                'tel' => '020-88888888',
                'mobile' => '18666666666',
                'company' => '公司名',
                'post_code' => '123456',
                'country' => '中国',
                'province' => '广东省',
                'city' => '广州市',
                'area' => '海珠区',
                'address' => 'XX路XX号XX大厦XX栋XX',
            ],
            'receiver' => [
                'name' => '王小蒙',
                'tel' => '020-77777777',
                'mobile' => '18610000000',
                'company' => '公司名',
                'post_code' => '654321',
                'country' => '中国',
                'province' => '广东省',
                'city' => '广州市',
                'area' => '天河区',
                'address' => 'XX路XX号XX大厦XX栋XX',
            ],
            'shop' => [
                'wxa_path' => '/index/index?from=waybill&id=01234567890123456789',
                'img_url' => 'https://mmbiz.qpic.cn/mmbiz_png/OiaFLUqewuIDNQnTiaCInIG8ibdosYHhQHPbXJUrqYSNIcBL60vo4LIjlcoNG1QPkeH5GWWEB41Ny895CokeAah8A/640',
                'goods_name' => '微信气泡狗抱枕&微信气泡狗钥匙扣',
                'goods_count' => 2,
            ],
            'cargo' => [
                'count' => 2,
                'weight' => 5.5,
                'space_x' => 30.5,
                'space_y' => 20,
                'space_z' => 20,
                'detail_list' => [
                    [
                        'name' => '微信气泡狗抱枕',
                        'count' => 1,
                    ],
                    [

                        'name' => '微信气泡狗钥匙扣',
                        'count' => 1,
                    ],
                ],
            ],
            'insured' => [
                'use_insured' => 1,
                'insured_value' => 10000,
            ],
            'service' => [
                'service_type' => 0,
                'service_name' => '标准快递',
            ]
        ];

        $this->assertIsArray($client->createWaybill($data));

        $this->assertSame(json_decode($this->readMockResponseJson('createWaybill.json'), true), $client->createWaybill($data));
    }

    public function testDeleteWaybill()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('deleteWaybill.json'));

        $app = $this->mockAccessToken(new ServiceContainer([
            'appId' => 'mock_appid',
            'appSecret' => 'mock_secret'
        ]));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/express/business/order/cancel', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        $data = [
            'order_id' => '01234567890123456789',
            'openid' => 'oABC123456',
            'delivery_id' => 'SF',
            'waybill_id' => '123456789',
        ];

        $this->assertIsArray($client->deleteWaybill($data));

        $this->assertSame(json_decode($this->readMockResponseJson('deleteWaybill.json'), true), $client->deleteWaybill($data));
    }

    public function testListProviders()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('listProviders.json'));

        $app = $this->mockAccessToken(new ServiceContainer([
            'appId' => 'mock_appid',
            'appSecret' => 'mock_secret'
        ]));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('GET', $request->getMethod());
            $this->assertEquals('/cgi-bin/express/business/delivery/getall', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        $this->assertIsArray($client->listProviders());

        $this->assertSame(json_decode($this->readMockResponseJson('listProviders.json'), true), $client->listProviders());
    }

    public function testGetWaybill()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('getWaybill.json'));

        $app = $this->mockAccessToken(new ServiceContainer([
            'appId' => 'mock_appid',
            'appSecret' => 'mock_secret'
        ]));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/express/business/order/get', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        $params = [
            'order_id' => '01234567890123456789',
            'openid' => 'oABC123456',
            'delivery_id' => 'SF',
            'waybill_id' => '123456789',
        ];

        $this->assertIsArray($client->getWaybill($params));

        $this->assertSame(json_decode($this->readMockResponseJson('getWaybill.json'), true), $client->getWaybill());
    }

    public function testGetWaybillTrack()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('getWaybillTrack.json'));

        $app = $this->mockAccessToken(new ServiceContainer([
            'appId' => 'mock_appid',
            'appSecret' => 'mock_secret'
        ]));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/express/business/path/get', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        $params = [
            'order_id' => '01234567890123456789',
            'openid' => 'oABC123456',
            'delivery_id' => 'SF',
            'waybill_id' => '123456789',
        ];

        $this->assertIsArray($client->getWaybillTrack($params));

        $this->assertSame(json_decode($this->readMockResponseJson('getWaybillTrack.json'), true), $client->getWaybillTrack($params));
    }

    public function testGetPrinter()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('getPrinter.json'));

        $app = $this->mockAccessToken(new ServiceContainer([
            'appId' => 'mock_appid',
            'appSecret' => 'mock_secret'
        ]));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('GET', $request->getMethod());
            $this->assertEquals('/cgi-bin/express/business/printer/getall', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        $this->assertIsArray($client->getPrinter());

        $this->assertSame(json_decode($this->readMockResponseJson('getPrinter.json'), true), $client->getPrinter());
    }

    public function testGetBalance()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('getBalance.json'));

        $app = $this->mockAccessToken(new ServiceContainer([
            'appId' => 'mock_appid',
            'appSecret' => 'mock_secret'
        ]));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/express/business/quota/get', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        $this->assertIsArray($client->getBalance('YTO', 'xyz'));

        $this->assertSame(json_decode($this->readMockResponseJson('getBalance.json'), true), $client->getBalance('YTO', 'xyz'));
    }

    public function testBindPrinter()
    {
        $response = $this->buildResponse(Status::CODE_OK, '{"errcode":0,"errmsg":"ok"}');

        $app = $this->mockAccessToken(new ServiceContainer([
            'appId' => 'mock_appid',
            'appSecret' => 'mock_secret'
        ]));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/express/business/printer/update', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        $this->assertTrue($client->bindPrinter('oJ4v0wRAfiXcnIbM3SgGEUkTw3Qw'));
    }

    public function testUnbindPrinter()
    {
        $response = $this->buildResponse(Status::CODE_OK, '{"errcode":0,"errmsg":"ok"}');

        $app = $this->mockAccessToken(new ServiceContainer([
            'appId' => 'mock_appid',
            'appSecret' => 'mock_secret'
        ]));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/express/business/printer/update', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        $this->assertTrue($client->unbindPrinter('oJ4v0wRAfiXcnIbM3SgGEUkTw3Qw'));
    }

    private function readMockResponseJson($filename)
    {
        return file_get_contents(__DIR__ . '/mock_data/' . $filename);
    }
}