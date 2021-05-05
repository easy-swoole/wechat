<?php
/**
 * Created by PhpStorm.
 * User: XueSi
 * Email: <1592328848@qq.com>
 * Date: 2021/5/5
 * Time: 22:49
 */

namespace EasySwoole\WeChat\Tests\MiniProgram\Union;

use EasySwoole\WeChat\Kernel\Exceptions\InvalidArgumentException;
use EasySwoole\WeChat\Tests\TestCase;
use EasySwoole\WeChat\Kernel\ServiceContainer;
use EasySwoole\WeChat\Tests\Mock\Message\Status;
use Psr\Http\Message\ServerRequestInterface;
use EasySwoole\WeChat\MiniProgram\Union\Client;

class ClientTest extends TestCase
{
    public function testCreatePromotion()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('createPromotion.json'));

        $app = $this->mockAccessToken(new ServiceContainer([
            'appId' => 'mock_appid',
            'appSecret' => 'mock_secret'
        ]));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/union/promoter/promotion/add', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        $this->assertIsArray($client->createPromotion('推广位名称'));

        $this->assertSame(json_decode($this->readMockResponseJson('createPromotion.json'), true), $client->createPromotion('推广位名称'));
    }

    public function testDeletePromotion()
    {
        $response = $this->buildResponse(Status::CODE_OK, '{"errcode":0,"errmsg":""}');

        $app = $this->mockAccessToken(new ServiceContainer([
            'appId' => 'mock_appid',
            'appSecret' => 'mock_secret'
        ]));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/union/promoter/promotion/del', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        $this->assertTrue($client->deletePromotion('oUnIc49z', '推广位名称'));
    }

    public function testUpdatePromotion()
    {
        $response = $this->buildResponse(Status::CODE_OK, '{"errcode":0,"errmsg":""}');

        $app = $this->mockAccessToken(new ServiceContainer([
            'appId' => 'mock_appid',
            'appSecret' => 'mock_secret'
        ]));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/union/promoter/promotion/upd', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        $previousPromotionInfo = [
            'promotionSourcePid' => 'oUnIc49z',
            'promotionSourceName' => 'delete'
        ];

        $promotionInfo = [
            'promotionSourceName' => 'upd after22'
        ];

        $this->assertTrue($client->updatePromotion($previousPromotionInfo, $promotionInfo));
    }

    public function testGetPromotionSourceList()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('getPromotionSourceList.json'));

        $app = $this->mockAccessToken(new ServiceContainer([
            'appId' => 'mock_appid',
            'appSecret' => 'mock_secret'
        ]));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('GET', $request->getMethod());
            $this->assertEquals('/union/promoter/promotion/list', $request->getUri()->getPath());
            $this->assertEquals('start=0&limit=20&access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        $this->assertIsArray($client->getPromotionSourceList(0, 20));

        $this->assertSame(json_decode($this->readMockResponseJson('getPromotionSourceList.json'), true), $client->getPromotionSourceList(0, 20));
    }

    /********** 商品推广接口 *******************/
    public function testGetProductCategory()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('getProductCategory.json'));

        $app = $this->mockAccessToken(new ServiceContainer([
            'appId' => 'mock_appid',
            'appSecret' => 'mock_secret'
        ]));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('GET', $request->getMethod());
            $this->assertEquals('/union/promoter/product/category', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        $this->assertIsArray($client->getProductCategory());

        $this->assertSame(json_decode($this->readMockResponseJson('getProductCategory.json'), true), $client->getProductCategory());
    }

    public function testGetProductList()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('getProductList.json'));

        $app = $this->mockAccessToken(new ServiceContainer([
            'appId' => 'mock_appid',
            'appSecret' => 'mock_secret'
        ]));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('GET', $request->getMethod());
            $this->assertEquals('/union/promoter/product/list', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        $this->assertIsArray($client->getProductList([]));

        $this->assertSame(json_decode($this->readMockResponseJson('getProductList.json'), true), $client->getProductList([]));
    }

    public function testGetProductMaterial()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('getProductMaterial.json'));

        $app = $this->mockAccessToken(new ServiceContainer([
            'appId' => 'mock_appid',
            'appSecret' => 'mock_secret'
        ]));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/union/promoter/product/generate', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        $productList = [
            [
                'productId' => '14495788',
                'appId' => 'wxb82530c28'
            ]
        ];

        $this->assertIsArray($client->getProductMaterial('oUnIc49zinb1mtlfB5K-NfGJxxNE_341161518', $productList));

        $this->assertSame(json_decode($this->readMockResponseJson('getProductMaterial.json'), true), $client->getProductMaterial('oUnIc49zinb1mtlfB5K-NfGJxxNE_341161518', $productList));
    }

    /*************** 查询订单明细接口 ******************/
    public function testGetOrderInfo()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('getOrderInfo.json'));

        $app = $this->mockAccessToken(new ServiceContainer([
            'appId' => 'mock_appid',
            'appSecret' => 'mock_secret'
        ]));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/union/promoter/order/info', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        $this->assertIsArray($client->getOrderInfo([]));

        $this->assertSame(json_decode($this->readMockResponseJson('getOrderInfo.json'), true), $client->getOrderInfo([]));
    }

    public function testSearchOrder()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('searchOrder.json'));

        $app = $this->mockAccessToken(new ServiceContainer([
            'appId' => 'mock_appid',
            'appSecret' => 'mock_secret'
        ]));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('GET', $request->getMethod());
            $this->assertEquals('/union/promoter/order/search', $request->getUri()->getPath());
            $this->assertEquals('page=1&startTimestamp=&endTimestamp=&commissionStatus=&access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        $this->assertIsArray($client->searchOrder(1));

        $this->assertSame(json_decode($this->readMockResponseJson('searchOrder.json'), true), $client->searchOrder(1));
    }

    private function readMockResponseJson($filename)
    {
        return file_get_contents(__DIR__ . '/mock_data/' . $filename);
    }
}