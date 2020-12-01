<?php

namespace EasySwoole\WeChat\Tests\OfficialAccount\Goods;


use EasySwoole\WeChat\Kernel\ServiceContainer;
use EasySwoole\WeChat\OfficialAccount\Goods\Client;
use EasySwoole\WeChat\Tests\Mock\Message\Status;
use EasySwoole\WeChat\Tests\TestCase;
use Psr\Http\Message\ServerRequestInterface;

class ClientTest extends TestCase
{
    public function testAdd()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('add.json'));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/scan/product/v2/add', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $data = [
            [
                'pid' => 'pid001',
                'image_info' => [
                    'main_image_list' => [
                        [
                            'url' => 'http://www.google.com/a.jpg',
                        ],
                        [
                            'url' => 'http://www.google.com/b.jpg',
                        ],
                    ],
                ],
                'category_info' => [
                    'category_item' => [
                        [
                            'category_name' => '图书',
                        ],
                        [
                            'category_name' => '少儿图书',
                        ],
                    ],
                ],
                'official_category_info' => [
                    'category_item' => [
                        [
                            'category_name' => '图书',
                        ],
                    ],
                ],
                'link_info' => [
                    'url' => 'pages/index/index',
                    'wxa_appid' => 'wxa0x01adx3423566',
                    'link_type' => 'wxa',
                ],
                'title' => 'test title',
                'sub_title' => 'test sub_title',
                'brand' => 'test brand',
                'shop_info' => [
                    'source' => 2,
                ],
                'desc' => 'test desc',
                'price_info' => [
                    'min_price' => 250,
                    'max_price' => 250.22,
                    'min_ori_price' => 300.1,
                    'max_ori_price' => 320.15,
                ],
                'sale_info' => [
                    'sale_status' => 'on',
                    'stock' => 1000,
                ],
                'custom_info' => [
                    'custom_list' => [
                        [
                            'key' => 'book_desc',
                            'value' => '“熊猫先生”通过4个富有节律性、带有因果关系、幽默风趣，又有正反对比的故事，让小朋友明白礼仪的重要性。',
                        ],
                        [
                            'key' => 'author',
                            'value' => '史蒂夫•安东尼',
                        ],
                        [
                            'key' => 'publisher',
                            'value' => '中信出版社',
                        ],
                    ],
                ],
                'sku_info' => [
                    'sku_item' => [
                        [
                            'sku_id' => 'sku001',
                            'barcode_type' => 'ean13',
                            'barcode' => 2018032105140,
                            'image_info' => [
                                'main_image_list' => [
                                    [
                                        'url' => 'http://www.google.com/c.jpg',
                                    ],
                                    [
                                        'url' => 'http://www.google.com/d.jpg',
                                    ],
                                ],
                            ],
                            'link_url' => 'pages/index/index?a=b',
                            'price_info' => [
                                'min_price' => 250,
                                'max_price' => 250.22,
                                'min_ori_price' => 300.1,
                                'max_ori_price' => 320.15,
                            ],
                            'sale_info' => [
                                'sale_status' => 'on',
                                'stock' => 500,
                            ],
                            'shop_info' => [
                                'source' => 2,
                            ],
                        ],
                        [
                            'sku_id' => 'sku002',
                            'barcode_type' => 'ean13',
                            'barcode' => 2018032105140,
                            'image_info' => [
                                'main_image_list' => [
                                    [
                                        'url' => 'http://www.google.com/c.jpg',
                                    ],
                                    [
                                        'url' => 'http://www.google.com/d.jpg',
                                    ],
                                ],
                            ],
                            'link_url' => 'pages/index/index?a=b',
                            'price_info' => [
                                'min_price' => 250,
                                'max_price' => 250.22,
                                'min_ori_price' => 300.1,
                                'max_ori_price' => 320.15,
                            ],
                            'sale_info' => [
                                'sale_status' => 'on',
                                'stock' => 500,
                            ],
                            'shop_info' => [
                                'source' => 2,
                            ],
                        ],
                    ],
                ],
                'partial_update' => 1,
            ],
            [
                'pid' => 'pid002',
                'image_info' => [
                    'main_image_list' => [
                        [
                            'url' => 'http://www.google.com/a.jpg',
                        ],
                        [
                            'url' => 'http://www.google.com/b.jpg',
                        ],
                    ],
                ],
                'category_info' => [
                    'category_item' => [
                        [
                            'category_name' => '女装',
                        ],
                        [
                            'category_name' => '连衣裙',
                        ],
                    ],
                ],
                'official_category_info' => [
                    'category_item' => [
                        [
                            'category_name' => '女装',
                        ],
                    ],
                ],
                'link_info' => [
                    'url' => 'pages/index/index',
                    'wxa_appid' => 'wxa0x01adx3423566',
                    'link_type' => 'wxa',
                ],
                'title' => 'test title',
                'sub_title' => 'test sub_title',
                'brand' => 'test brand',
                'shop_info' => [
                    'source' => 2,
                ],
                'desc' => 'test desc',
                'price_info' => [
                    'min_price' => 250,
                    'max_price' => 250.22,
                    'min_ori_price' => 300.1,
                    'max_ori_price' => 320.15,
                ],
                'sale_info' => [
                    'sale_status' => 'on',
                    'stock' => 1000,
                ],
                'sku_info' => [
                    'sku_item' => [
                        [
                            'sku_id' => 'sku001',
                            'barcode_type' => 'ean13',
                            'barcode' => 2018032105140,
                            'image_info' => [
                                'main_image_list' => [
                                    [
                                        'url' => 'http://www.google.com/c.jpg',
                                    ],
                                    [
                                        'url' => 'http://www.google.com/d.jpg',
                                    ],
                                ],
                            ],
                            'link_url' => 'pages/index/index?a=b',
                            'price_info' => [
                                'min_price' => 250,
                                'max_price' => 250.22,
                                'min_ori_price' => 300.1,
                                'max_ori_price' => 320.15,
                            ],
                            'sale_info' => [
                                'sale_status' => 'on',
                                'stock' => 500,
                            ],
                            'shop_info' => [
                                'source' => 2,
                            ],
                        ],
                        [
                            'sku_id' => 'sku002',
                            'barcode_type' => 'ean13',
                            'barcode' => 2018032105140,
                            'image_info' => [
                                'main_image_list' => [
                                    [
                                        'url' => 'http://www.google.com/c.jpg',
                                    ],
                                    [
                                        'url' => 'http://www.google.com/d.jpg',
                                    ],
                                ],
                            ],
                            'link_url' => 'pages/index/index?a=b',
                            'price_info' => [
                                'min_price' => 250,
                                'max_price' => 250.22,
                                'min_ori_price' => 300.1,
                                'max_ori_price' => 320.15,
                            ],
                            'sale_info' => [
                                'sale_status' => 'on',
                                'stock' => 500,
                            ],
                            'shop_info' => [
                                'source' => 2,
                            ],
                        ],
                    ],
                ],
                'partial_update' => 1,
            ],
            [
                'pid' => 'pid003',
                'image_info' => [
                    'main_image_list' => [
                        [
                            'url' => 'http://www.google.com/a.jpg',
                        ],
                        [
                            'url' => 'http://www.google.com/b.jpg',
                        ],
                    ],
                ],
                'category_info' => [
                    'category_item' => [
                        [
                            'category_name' => '酒店',
                        ],
                    ],
                ],
                'official_category_info' => [
                    'category_item' => [
                        [
                            'category_name' => '酒店',
                        ],
                    ],
                ],
                'tag_info' => [
                    'tag_item' => [
                        [
                            'tag_name' => '酒店公寓',
                        ],
                    ],
                ],
                'link_info' => [
                    'url' => 'pages/index/index',
                    'wxa_appid' => 'wxa0x01adx3423566',
                    'link_type' => 'wxa',
                ],
                'title' => 'test title',
                'sub_title' => 'test sub_title',
                'brand' => 'test brand',
                'shop_info' => [
                    'source' => 2,
                ],
                'desc' => 'test desc',
                'price_info' => [
                    'min_price' => 250,
                    'max_price' => 250.22,
                    'min_ori_price' => 300.1,
                    'max_ori_price' => 320.15,
                ],
                'sale_info' => [
                    'sale_status' => 'on',
                    'stock' => 1000,
                ],
                'sku_info' => [
                    'sku_item' => [
                        [
                            'sku_id' => 'sku001',
                            'barcode_type' => 'ean13',
                            'barcode' => 2018032105140,
                            'image_info' => [
                                'main_image_list' => [
                                    [
                                        'url' => 'http://www.google.com/c.jpg',
                                    ],
                                    [
                                        'url' => 'http://www.google.com/d.jpg',
                                    ],
                                ],
                            ],
                            'link_url' => 'pages/index/index?a=b',
                            'price_info' => [
                                'min_price' => 250,
                                'max_price' => 250.22,
                                'min_ori_price' => 300.1,
                                'max_ori_price' => 320.15,
                            ],
                            'sale_info' => [
                                'sale_status' => 'on',
                                'stock' => 500,
                            ],
                            'shop_info' => [
                                'source' => 2,
                            ],
                            'attribute_info' => [
                                'attribute_item' => [
                                    [
                                        'attribute_key' => '酒店房型',
                                        'attribute_value' => '海景大床房',
                                    ],
                                ],
                            ],
                        ],
                    ],
                ],
                'custom_info' => [
                    'custom_list' => [
                        [
                            'key' => 'address',
                            'value' => '中国广东省广州市海珠区新港中路397号tit创意园',
                        ],
                        [
                            'key' => 'lng',
                            'value' => '116.010101',
                        ],
                        [
                            'key' => 'lat',
                            'value' => '23.242424',
                        ],
                        [
                            'key' => 'location_type',
                            'value' => '5',
                        ],
                        [
                            'key' => 'star',
                            'value' => '4',
                        ],
                    ],
                ],
                'partial_update' => 1,
            ],
        ];

        $client = new Client($app);
        $this->assertIsArray($client->add($data));
        $this->assertEquals(json_decode($this->readMockResponseJson('add.json'), true), $client->add($data));
    }

    public function testUpdate()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('update.json'));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/scan/product/v2/add', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $data = [
            'pid' => 'pid001',
            'image_info' => [
                'main_image_list' => [
                    [
                        'url' => 'http://www.google.com/a.jpg',
                    ],
                    [
                        'url' => 'http://www.google.com/b.jpg',
                    ],
                ],
            ],
        ];

        $client = new Client($app);
        $this->assertIsArray($client->update($data));
        $this->assertEquals(json_decode($this->readMockResponseJson('update.json'), true), $client->update($data));
    }


    public function testStatus()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('status.json'));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/scan/product/v2/status', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);
        $this->assertIsArray($client->status('115141102647330200'));
        $this->assertEquals(json_decode($this->readMockResponseJson('status.json'), true), $client->status('115141102647330200'));
    }

    public function testGet()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('get.json'));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/scan/product/v2/getinfo', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);
        $this->assertIsArray($client->get('pid001'));
        $this->assertEquals(json_decode($this->readMockResponseJson('get.json'), true), $client->get('pid001'));
    }

    public function testList()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('list.json'));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/scan/product/v2/getinfobypage', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);
        $this->assertIsArray($client->list('Uuls-grxWGsHmCGPcUQbtK0Da', 1, 10));
        $this->assertEquals(json_decode($this->readMockResponseJson('list.json'), true), $client->list('Uuls-grxWGsHmCGPcUQbtK0Da', 1, 10));
    }

    protected function readMockResponseJson(string $file): string
    {
        return file_get_contents(dirname(__FILE__) . '/mock_data/' . $file);
    }
}