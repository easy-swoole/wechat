<?php
/**
 * Created by PhpStorm.
 * User: XueSi
 * Email: <1592328848@qq.com>
 * Date: 2021/5/6
 * Time: 1:17
 */

namespace EasySwoole\WeChat\Tests\MiniProgram\Mall;


use EasySwoole\WeChat\Tests\TestCase;
use EasySwoole\WeChat\Kernel\ServiceContainer;
use EasySwoole\WeChat\Tests\Mock\Message\Status;
use Psr\Http\Message\ServerRequestInterface;
use EasySwoole\WeChat\MiniProgram\Mall\ProductClient;

class ProductClientTest extends TestCase
{
    public function testImport()
    {
        $response = $this->buildResponse(Status::CODE_OK, '{"errcode":0,"errmsg":"success"}');

        $app = $this->mockAccessToken(new ServiceContainer([
            'appId' => 'mock_appid',
            'appSecret' => 'mock_secret'
        ]));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/mall/importproduct', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token&is_test=0', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new ProductClient($app);

        $params = [
            'product_list' => [
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
                    'version' => 200,
                    'sku_list' => [
                        [
                            'sku_id' => 'sku_id1',
                            'price' => 10000,
                            'original_price' => 20010,
                            'status' => 1,
                            'sku_attr_list' => [
                                [
                                    'name' => '颜色',
                                    'value' => '白色',
                                ],
                                [
                                    'name' => '码数',
                                    'value' => 'L',
                                ],
                            ],
                            'version' => 1200,
                            'poi_list' => [
                                [
                                    'longitude' => 116.32676,
                                    'latitude' => 40.003305,
                                    'radius' => 4,
                                    'business_name' => '肯德基',
                                    'branch_name' => '珠江新城店',
                                    'address' => '新港中路123号',
                                ],
                                [
                                    'longitude' => 117.32676,
                                    'latitude' => 41.003305,
                                    'radius' => 5,
                                    'business_name' => '肯德基',
                                    'branch_name' => '客村店',
                                    'address' => '新港中路123号',
                                ],
                            ],
                            'bar_code_info' => [
                                'barcode_type' => 'ean8',
                                'barcode' => '12345678',
                            ],
                        ],
                        [
                            'sku_id' => 'sku_id2',
                            'price' => 10010,
                            'status' => 1,
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
                            'poi_list' => [
                                [
                                    'longitude' => 116.32676,
                                    'latitude' => 40.003305,
                                    'radius' => 4,
                                    'business_name' => '肯德基',
                                    'branch_name' => '珠江新城店',
                                    'address' => '新港中路123号',
                                ],
                                [
                                    'longitude' => 117.32676,
                                    'latitude' => 41.003305,
                                    'radius' => 5,
                                    'business_name' => '肯德基',
                                    'branch_name' => '客村店',
                                    'address' => '新港中路123号',
                                ],
                            ],
                            'bar_code_info' => [
                                'barcode_type' => 'ean13',
                                'barcode' => '0123456789123',
                            ],
                        ],
                    ],
                ],
            ],
        ];

        $this->assertTrue($client->import($params));
    }

    public function testQuery()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('query.json'));

        $app = $this->mockAccessToken(new ServiceContainer([
            'appId' => 'mock_appid',
            'appSecret' => 'mock_secret'
        ]));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/mall/queryproduct', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token&type=batchquery', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new ProductClient($app);

        $params = [
            'key_list' => [
                [
                    'item_code' => '00003563372839_0000xxxxxxxx'
                ],
                [
                    'item_code' => '00003563372839_0000xxxxxxxx'
                ]
            ]
        ];

        $this->assertIsArray($client->query($params));

        $this->assertSame(json_decode($this->readMockResponseJson('query.json'), true), $client->query($params));
    }

    public function testSetSeacrchable()
    {
        $response = $this->buildResponse(Status::CODE_OK, '{"errcode":0,"errmsg":"success"}');

        $app = $this->mockAccessToken(new ServiceContainer([
            'appId' => 'mock_appid',
            'appSecret' => 'mock_secret'
        ]));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/mall/brandmanage', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token&action=set_biz_can_be_search', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new ProductClient($app);

        $this->assertTrue($client->setSearchable('true'));
    }

    private function readMockResponseJson($filename)
    {
        return file_get_contents(__DIR__ . '/mock_data/ProductClient/' . $filename);
    }
}