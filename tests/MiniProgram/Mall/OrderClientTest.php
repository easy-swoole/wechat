<?php
/**
 * Created by PhpStorm.
 * User: XueSi
 * Email: <1592328848@qq.com>
 * Date: 2021/5/6
 * Time: 0:59
 */

namespace EasySwoole\WeChat\Tests\MiniProgram\Mall;


use EasySwoole\WeChat\Tests\TestCase;
use EasySwoole\WeChat\Kernel\ServiceContainer;
use EasySwoole\WeChat\Tests\Mock\Message\Status;
use Psr\Http\Message\ServerRequestInterface;
use EasySwoole\WeChat\MiniProgram\Mall\OrderClient;


class OrderClientTest extends TestCase
{
    public function testAdd()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('add.json'));

        $app = $this->mockAccessToken(new ServiceContainer([
            'appId' => 'mock_appid',
            'appSecret' => 'mock_secret'
        ]));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/mall/importorder', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token&action=add-order&is_history=0', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new OrderClient($app);

        $params = [
            'order_list' => [
                [
                    'order_id' => 'AQAATGagQ7KQCxMJEj7kHuUjTxxx',
                    'create_time' => 1527584231,
                    'pay_finish_time' => 1527584244,
                    'desc' => 'xx微主页',
                    'fee' => 1,
                    'trans_id' => '4200000144201807116521229xxx',
                    'status' => 3,
                    'ext_info' => [
                        'product_info' => [
                            'item_list' =>
                                [
                                    [
                                        'item_code' => '00003563372839_00000010001xxx',
                                        'sku_id' => '00003563372839_10000010014xxx',
                                        'amount' => 1,
                                        'total_fee' => 1,
                                        'thumb_url' => 'https://shp.qpic.cn/wechat_bs/0/4eb3dcee0edcd34939b87f232e9fxxxx',
                                        'title' => '肯德基XX',
                                        'desc' => 'xxxx',
                                        'unit_price' => 1,
                                        'original_price' => 2,
                                        'poi_list' =>
                                            [
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
                                        'stock_attr_info' => [
                                            [
                                                'attr_name' => [
                                                    'name' => '尺码',
                                                ],
                                                'attr_value' => [
                                                    'name' => 'L',
                                                ],
                                            ],
                                        ],
                                        'category_list' => [
                                            '衣服',
                                            'T-shirt',
                                        ],
                                        'item_detail_page' => [
                                            'path' => '/portal/xxxx/detail?code=00003563372839_00000010001xxx',
                                        ],
                                        'bar_code_info' => [
                                            'barcode_type' => 'ean8',
                                            'barcode' => '12345678',
                                        ],
                                        'platform_category_list' => [
                                            [
                                                'category_id' => 4342,
                                                'category_name' => '运动裤',
                                            ],
                                        ],
                                    ],
                                ],
                        ],
                        'express_info' => [
                            'name' => '测试用户',
                            'phone' => '158xxxxxx',
                            'address' => '广东省广州市tit创意园品牌街腾讯微信总部',
                            'price' => 0,
                            'national_code' => '440105',
                            'country' => '中国',
                            'province' => '广东省',
                            'city' => '广州市',
                            'district' => '海珠区',
                            'express_package_info_list' => [
                                [
                                    'express_company_id' => 2001,
                                    'express_company_name' => '圆通',
                                    'express_code' => '88627337387xxx',
                                    'ship_time' => 1517713509,
                                    'express_page' => [
                                        'path' => '/libs/xxxxx/portal/express-detail/xxxxx',
                                    ],
                                    'express_goods_info_list' => [
                                        [
                                            'item_code' => '00003563372839_00000010001xxx',
                                            'sku_id' => '00003563372839_10000010014xxx',
                                        ],
                                    ],
                                ],
                            ],
                        ],
                        'promotion_info' => [
                            'discount_fee' => 1,
                        ],
                        'brand_info' => [
                            'id' => 'qwertyui',
                            'name' => '外婆家',
                            'phone' => '12345678',
                            'contact_detail_page' => [
                                'path' => '/libs/xxxxx/portal/contact_detail/xxxx',
                            ],
                        ],
                        'invoice_info' => [
                            'type' => 0,
                            'title' => 'xxxxxx',
                            'tax_number' => 'xxxxxx',
                            'company_address' => 'xxxxxx',
                            'telephone' => '020-xxxxxx',
                            'bank_name' => '招商银行',
                            'bank_account' => 'xxxxxxxx',
                            'invoice_detail_page' => [
                                'path' => '/libs/xxxxx/portal/invoice-detail/xxxxx',
                            ],
                        ],
                        'payment_method' => 1,
                        'user_open_id' => 'xxxxxxx',
                        'order_detail_page' => [
                            'path' => '/libs/xxxxx/portal/order-detail/xxxxx',
                            'kf_type' => 3,
                        ],
                        'follow_buy_info' => [
                            'wxapp_fb_key' => 'BgA****K7b',
                        ],
                    ],
                ],
            ],
        ];

        $this->assertIsArray($client->add($params));

        $this->assertSame(json_decode($this->readMockResponseJson('add.json'), true), $client->add($params));
    }

    public function testUpdate()
    {
        $response = $this->buildResponse(Status::CODE_OK, '{"errcode":0,"errmsg":"success"}');

        $app = $this->mockAccessToken(new ServiceContainer([
            'appId' => 'mock_appid',
            'appSecret' => 'mock_secret'
        ]));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/mall/importorder', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token&action=update-order&is_history=0', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new OrderClient($app);

        $params = [
            'order_list' => [
                [
                    'order_id' => 'AQAATGagQ7KQCxMJEj7kHuUjTxxx',
                    'trans_id' => '4200000144201807116521229xxx',
                    'status' => 4,
                    'desc' => 'xx微主页',
                    'ext_info' => [
                        'express_info' => [
                            'name' => '测试用户',
                            'phone' => '158xxxxxx',
                            'address' => '广东省广州市tit创意园品牌街腾讯微信总部',
                            'price' => 0,
                            'national_code' => '440105',
                            'country' => '中国',
                            'province' => '广东省',
                            'city' => '广州市',
                            'district' => '海珠区',
                            'express_package_info_list' => [
                                [
                                    'express_company_id' => 2001,
                                    'express_company_name' => '圆通',
                                    'express_code' => '88627337387xxx',
                                    'ship_time' => 1517713509,
                                    'express_page' => [
                                        'path' => '/libs/xxxxx/portal/express-detail/xxxxx',
                                    ],
                                    'express_goods_info_list' => [
                                        [
                                            'item_code' => '00003563372839_00000010001xxx',
                                            'sku_id' => '00003563372839_10000010014xxx',
                                        ],
                                    ],
                                ],
                            ],
                        ],
                        'invoice_info' => [
                            'type' => 0,
                            'title' => 'xxxxxx',
                            'tax_number' => 'xxxxxx',
                            'company_address' => 'xxxxxx',
                            'telephone' => '020-xxxxxx',
                            'bank_name' => '招商银行',
                            'bank_account' => 'xxxxxxxx',
                            'invoice_detail_page' => [
                                'path' => '/libs/xxxxx/portal/invoice-detail/xxxxx',
                            ],
                        ],
                        'user_open_id' => 'xxxxxxx',
                        'order_detail_page' => [
                            'path' => '/libs/xxxxx/portal/order-detail/xxxxx',
                        ],
                    ],
                ],
            ],
        ];

        $this->assertTrue($client->update($params));
    }

    public function testDelete()
    {
        $response = $this->buildResponse(Status::CODE_OK, '{"errcode":0,"errmsg":"success"}');

        $app = $this->mockAccessToken(new ServiceContainer([
            'appId' => 'mock_appid',
            'appSecret' => 'mock_secret'
        ]));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/mall/deleteorder', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new OrderClient($app);

        $this->assertTrue($client->delete('mock_openid','mock_orderid'));
    }

    private function readMockResponseJson($filename)
    {
        return file_get_contents(__DIR__ . '/mock_data/OrderClient/' . $filename);
    }
}