<?php
/**
 * Created by PhpStorm.
 * User: XueSi
 * Email: <1592328848@qq.com>
 * Date: 2021/5/6
 * Time: 0:26
 */

namespace EasySwoole\WeChat\Tests\MiniProgram\Mall;

use EasySwoole\WeChat\Kernel\ServiceContainer;
use EasySwoole\WeChat\Tests\Mock\Message\Status;
use EasySwoole\WeChat\Tests\TestCase;
use Psr\Http\Message\ServerRequestInterface;
use EasySwoole\WeChat\MiniProgram\Mall\CartClient;

class CartClientTest extends TestCase
{
    public function testAdd()
    {
        $response = $this->buildResponse(Status::CODE_OK, '{"errcode":0,"errmsg":"success"}');

        $app = $this->mockAccessToken(new ServiceContainer([
            'appId' => 'mock_appid',
            'appSecret' => 'mock_secret'
        ]));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/mall/addshoppinglist', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token&is_test=0', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new CartClient($app);

        $params = [
            'user_open_id' => 'user_open_id',
            'sku_product_list' => [
                [
                    'item_code' => 'here_is_spu_id',
                    'title' => 'product_name',
                    'desc' => 'product_description',
                    'category_list' => [
                        '服装',
                        '上衣',
                        '短袖衬衫',
                    ],
                    'image_list' => [
                        'image_url1',
                        'image_url2',
                    ],
                    'src_wxapp_path' => '/detail?item_code=xxxx',
                    'attr_list' => [
                        [
                            'name' => '材质',
                            'value' => '纯棉',
                        ],
                        [
                            'name' => '款式',
                            'value' => '短袖',
                        ],
                        [
                            'name' => '季度',
                            'value' => '2018年秋',
                        ],
                    ],
                    'version' => 100,
                    'update_time' => 1542868721,
                    'platform_category_list' => [
                        [
                            'category_id' => 4342,
                            'category_name' => '运动裤',
                        ],
                    ],
                    'sku_info' => [
                        'sku_id' => 'sku_id2',
                        'price' => 10010,
                        'original_price' => 20010,
                        'bar_code_info' => [
                            'barcode_type' => 'ean8',
                            'barcode' => '12345678',
                        ],
                        'status' => 1,
                        'poi_list' => [
                            [
                                'longitude' => 116.32676,
                                'latitude' => 40.003305,
                                'radius' => 4,
                                'business_name' => '外婆家',
                                'branch_name' => '珠江新城店',
                                'address' => '新港中路123号',
                            ],
                            [
                                'longitude' => 117.32676,
                                'latitude' => 41.003305,
                                'radius' => 5,
                                'business_name' => '外婆家',
                                'branch_name' => '客村店',
                                'address' => '新港中路123号',
                            ],
                        ],
                        'sku_attr_list' => [
                            [
                                'name' => '颜色',
                                'value' => '黑色',
                            ],
                            [
                                'name' => '码数',
                                'value' => 'XXL',
                            ],
                        ],
                        'version' => 1200,
                    ],
                    'can_be_search' => true,
                    'brand_info' => [
                        'logo' => 'http://xxx.jpg',
                        'name' => '外婆家',
                    ],
                ],
            ],
        ];

        $this->assertTrue($client->add($params));
    }

    // type=batchquery
    public function testQuery()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('query.json'));

        $app = $this->mockAccessToken(new ServiceContainer([
            'appId' => 'mock_appid',
            'appSecret' => 'mock_secret'
        ]));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/mall/queryshoppinglist', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token&type=batchquery', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new CartClient($app);

        $params = [
            'user_open_id' => 'user_open_id',
            'key_list' => [
                [
                   'item_code'=> '00003563372839_0000xxxxxxxx'
                ],
                [
                    'item_code' => '00003563372839_0000xxxxxxxx'
                ]
            ]
        ];

        $this->assertIsArray($client->query($params));

        $this->assertSame(json_decode($this->readMockResponseJson('query.json'), true), $client->query($params));
    }

    // type=getbypage
    public function testQueryByPage()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('query.json'));

        $app = $this->mockAccessToken(new ServiceContainer([
            'appId' => 'mock_appid',
            'appSecret' => 'mock_secret'
        ]));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/mall/queryshoppinglist', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token&type=getbypage', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new CartClient($app);

        $params = [
            'user_open_id' => 'user_open_id',
            'offset' => 0,
            'count' => 20
        ];

        $this->assertIsArray($client->queryByPage($params));

        $this->assertSame(json_decode($this->readMockResponseJson('query.json'), true), $client->queryByPage($params));
    }

    public function testDeleteWithProducts()
    {
        $response = $this->buildResponse(Status::CODE_OK, '{"errcode":0,"errmsg":"success"}');

        $app = $this->mockAccessToken(new ServiceContainer([
            'appId' => 'mock_appid',
            'appSecret' => 'mock_secret'
        ]));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/mall/deleteshoppinglist', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new CartClient($app);

        $products = [
            [
                'item_code' => 'here_is_spu_id',
                'sku_id' => 'here_is_sku_id'
            ]
        ];

        $this->assertTrue($client->delete('user_open_id', $products));
    }

    public function testDeleteWithoutProducts()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('delete.json'));

        $app = $this->mockAccessToken(new ServiceContainer([
            'appId' => 'mock_appid',
            'appSecret' => 'mock_secret'
        ]));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/mall/deletebizallshoppinglist', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new CartClient($app);

        $this->assertIsArray($client->delete('user_open_id'));

        $this->assertSame(json_decode($this->readMockResponseJson('delete.json'), true), $client->delete('user_open_id'));
    }

    private function readMockResponseJson($filename)
    {
        return file_get_contents(__DIR__ . '/mock_data/CartClient/' . $filename);
    }
}