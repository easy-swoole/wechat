<?php
/**
 * Created by PhpStorm.
 * User: XueSi
 * Email: <1592328848@qq.com>
 * Date: 2021/4/25
 * Time: 1:17
 */

namespace EasySwoole\WeChat\Tests\Work\Menu;


use EasySwoole\WeChat\Kernel\ServiceContainer;
use EasySwoole\WeChat\Tests\Mock\Message\Status;
use EasySwoole\WeChat\Tests\TestCase;
use EasySwoole\WeChat\Work\Menu\Client;
use Psr\Http\Message\ServerRequestInterface;

class ClientTest extends TestCase
{
    public function testGet()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('get.json'));

        $app = $this->mockAccessToken(new ServiceContainer([
            'corpId' => 'mock_corpId',
            'corpSecret' => 'mock_corpSecret',
            'agentId' => 'mock_agentId'
        ]));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('GET', $request->getMethod());
            $this->assertEquals('/cgi-bin/menu/get', $request->getUri()->getPath());
            $this->assertEquals('agentid=mock_agentId&access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        $this->assertIsArray($client->get());

        $this->assertSame(json_decode($this->readMockResponseJson('get.json'), true), $client->get());
    }

    public function testCreate()
    {
        $response = $this->buildResponse(Status::CODE_OK, '{"errcode":0,"errmsg":"ok"}');

        $app = $this->mockAccessToken(new ServiceContainer([
            'corpId' => 'mock_corpId',
            'corpSecret' => 'mock_corpSecret',
            'agentId' => 'mock_agentId'
        ]));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/menu/create', $request->getUri()->getPath());
            $this->assertEquals('agentid=mock_agentId&access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        $data1 = [
            'button' => [
                [
                    'type' => 'click',
                    'name' => '今日歌曲',
                    'key' => 'V1001_TODAY_MUSIC',
                ],
                [
                    'name' => '菜单',
                    'sub_button' => [
                        [
                            'type' => 'view',
                            'name' => '搜索',
                            'url' => 'http://www.soso.com/'],
                        [
                            'type' => 'click',
                            'name' => '赞一下我们',
                            'key' => 'V1001_GOOD',
                        ]

                    ]
                ]
            ]
        ];

        $this->assertTrue($client->create($data1));

        $data2 = [
            'button' => [
                [
                    'name' => '扫码',
                    'sub_button' => [
                        [
                            'type' => 'scancode_waitmsg',
                            'name' => '扫码带提示',
                            'key' => 'rselfmenu_0_0',
                            'sub_button' => []
                        ],
                        [
                            'type' => 'scancode_push',
                            'name' => '扫码推事件',
                            'key' => 'rselfmenu_0_1',
                            'sub_button' => []
                        ],
                        [
                            'type' => 'view_miniprogram',
                            'name' => '小程序',
                            'pagepath' => 'pages/lunar/index',
                            'appid' => 'wx4389ji4kAAA'
                        ]
                    ]
                ],
                [
                    'name' => '发图',
                    'sub_button' => [
                        [
                            'type' => 'pic_sysphoto',
                            'name' => '系统拍照发图',
                            'key' => 'rselfmenu_1_0',
                            'sub_button' => []
                        ],
                        [
                            'type' => 'pic_photo_or_album',
                            'name' => '拍照或者相册发图',
                            'key' => 'rselfmenu_1_1',
                            'sub_button' => []
                        ],
                        [
                            'type' => 'pic_weixin',
                            'name' => '微信相册发图',
                            'key' => 'rselfmenu_1_2',
                            'sub_button' => []
                        ]
                    ]
                ],
                [
                    'name' => '发送位置',
                    'type' => 'location_select',
                    'key' => 'rselfmenu_2_0',
                ]
            ]
        ];

        $this->assertTrue($client->create($data2));
    }

    public function testDelete()
    {
        $response = $this->buildResponse(Status::CODE_OK, '{"errcode":0,"errmsg":"ok"}');

        $app = $this->mockAccessToken(new ServiceContainer([
            'corpId' => 'mock_corpId',
            'corpSecret' => 'mock_corpSecret',
            'agentId' => 'mock_agentId'
        ]));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('GET', $request->getMethod());
            $this->assertEquals('/cgi-bin/menu/delete', $request->getUri()->getPath());
            $this->assertEquals('agentid=mock_agentId&access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        $this->assertTrue($client->delete());
    }

    protected function readMockResponseJson(string $filename): string
    {
        return file_get_contents(__DIR__ . '/mock_data/' . $filename);
    }
}