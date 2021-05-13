<?php
/**
 * Created by PhpStorm.
 * User: 67066
 * Date: 2020/11/25
 * Time: 23:16
 */

namespace EasySwoole\WeChat\Tests\OfficialAccount\Menu;

use EasySwoole\WeChat\Kernel\ServiceContainer;
use EasySwoole\WeChat\OfficialAccount\Menu\Client;
use EasySwoole\WeChat\Tests\Mock\Message\Status;
use EasySwoole\WeChat\Tests\TestCase;
use Psr\Http\Message\ServerRequestInterface;

class ClientTest extends TestCase
{
    // 创建自定义菜单 - 创建 click 和 view 类型菜单的测试示例
    public function testCreate1()
    {
        $response = $this->buildResponse(Status::CODE_OK, '{"errcode":0,"errmsg":"ok"}');
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => 'mock_appId']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/menu/create', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        $buttons = [
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
                        'url' => 'http://www.soso.com/',
                    ],
                    [
                        'type' => 'miniprogram',
                        'name' => 'wxa',
                        'url' => 'http://mp.weixin.qq.com',
                        'appid' => 'wx286b93c14bbf93aa',
                        'pagepath' => 'pages/lunar/index',
                    ],
                    [
                        'type' => 'click',
                        'name' => '赞一下我们',
                        'key' => 'V1001_GOOD',
                    ],
                ],
            ],
        ];

        $this->assertTrue($client->create($buttons));
    }

    // 创建自定义菜单 - 创建其他新增按钮类型的测试示例
    public function testCreate2()
    {
        $response = $this->buildResponse(Status::CODE_OK, '{"errcode":0,"errmsg":"ok"}');
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => 'mock_appId']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/menu/create', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        $buttons = [
            [
                'name' => '扫码',
                'sub_button' => [
                    [
                        'type' => 'scancode_waitmsg',
                        'name' => '扫码带提示',
                        'key' => 'rselfmenu_0_0',
                        'sub_button' => [],
                    ],
                    [
                        'type' => 'scancode_push',
                        'name' => '扫码推事件',
                        'key' => 'rselfmenu_0_1',
                        'sub_button' => [],
                    ],
                ],
            ],
            [
                'name' => '发图',
                'sub_button' => [
                    [
                        'type' => 'pic_sysphoto',
                        'name' => '系统拍照发图',
                        'key' => 'rselfmenu_1_0',
                        'sub_button' => [],
                    ],
                    [
                        'type' => 'pic_photo_or_album',
                        'name' => '拍照或者相册发图',
                        'key' => 'rselfmenu_1_1',
                        'sub_button' => [],
                    ],
                    [
                        'type' => 'pic_weixin',
                        'name' => '微信相册发图',
                        'key' => 'rselfmenu_1_2',
                        'sub_button' => [],
                    ],
                ],
            ],
            [
                'name' => '发送位置',
                'type' => 'location_select',
                'key' => 'rselfmenu_2_0',
            ],
            [
                'type' => 'media_id',
                'name' => '图片',
                'media_id' => 'MEDIA_ID1',
            ],
            [
                'type' => 'view_limited',
                'name' => '图文消息',
                'media_id' => 'MEDIA_ID2',
            ],
        ];

        $this->assertTrue($client->create($buttons));
    }

    // 创建个性化菜单
    public function testCreate3()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('create3.json'));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => 'mock_appId']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/menu/addconditional', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        $buttons = [
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
                        'url' => 'http://www.soso.com/',
                    ],
                    [
                        'type' => 'miniprogram',
                        'name' => 'wxa',
                        'url' => 'http://mp.weixin.qq.com',
                        'appid' => 'wx286b93c14bbf93aa',
                        'pagepath' => 'pages/lunar/index',
                    ],
                    [
                        'type' => 'click',
                        'name' => '赞一下我们',
                        'key' => 'V1001_GOOD',
                    ],
                ],
            ],
        ];

        $matchRule = [
            'tag_id' => '2',
            'sex' => '1',
            'country' => '中国',
            'province' => '广东',
            'city' => '广州',
            'client_platform_type' => '2',
            'language' => 'zh_CN',
        ];

        $ret = $client->create($buttons, $matchRule);

        $this->assertIsArray($ret);

        $this->assertSame($this->readJsonToArray('create3.json'), $ret);
    }

    // 自定义菜单 - 查询接口 - 1.如果公众号是在公众平台官网通过网站功能发布菜单
    public function testCurrent1()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('current1.json'));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => 'mock_appId']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('GET', $request->getMethod());
            $this->assertEquals('/cgi-bin/get_current_selfmenu_info', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        $ret = $client->current();

        $this->assertIsArray($ret);

        $this->assertSame($this->readJsonToArray('current1.json'), $ret);
    }

    // 自定义菜单 - 查询接口 - 2.如果公众号是通过API调用设置的菜单
    // 如果公众号是在公众平台官网通过网站功能发布菜单
    public function testCurrent2()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('current2.json'));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => 'mock_appId']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('GET', $request->getMethod());
            $this->assertEquals('/cgi-bin/get_current_selfmenu_info', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        $ret = $client->current();

        $this->assertIsArray($ret);

        $this->assertSame($this->readJsonToArray('current2.json'), $ret);
    }

    // 删除所有菜单
    public function testDelete1()
    {
        $response = $this->buildResponse(Status::CODE_OK, '{"errcode":0,"errmsg":"ok"}');
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => 'mock_appId']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('GET', $request->getMethod());
            $this->assertEquals('/cgi-bin/menu/delete', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        $this->assertTrue($client->delete());
    }

    // 删除个性化菜单
    public function testDelete2()
    {
        $response = $this->buildResponse(Status::CODE_OK, '{"errcode":0,"errmsg":"ok"}');
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => 'mock_appId']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/menu/delconditional', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        $this->assertTrue($client->delete('208379533'));
    }

    // 测试个性化菜单匹配结果
    public function testMatch()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('match.json'));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => 'mock_appId']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/menu/trymatch', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        $ret = $client->match('weixin');

        $this->assertIsArray($ret);

        $this->assertSame($this->readJsonToArray('match.json'), $ret);
    }

    // 获取自定义菜单配置（无个性化菜单时）
    public function testList1()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('list1.json'));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => 'mock_appId']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('GET', $request->getMethod());
            $this->assertEquals('/cgi-bin/menu/get', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        $ret = $client->list();

        $this->assertIsArray($ret);

        $this->assertSame($this->readJsonToArray('list1.json'), $ret);
    }

    // 获取自定义菜单配置（有个性化菜单时）
    public function testList2()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('list1.json'));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => 'mock_appId']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('GET', $request->getMethod());
            $this->assertEquals('/cgi-bin/menu/get', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        $ret = $client->list();

        $this->assertIsArray($ret);

        $this->assertSame($this->readJsonToArray('list1.json'), $ret);
    }

    protected function readMockResponseJson(string $filename): string
    {
        return file_get_contents(dirname(__FILE__) . '/mock_data/' . $filename);
    }

    protected function readJsonToArray(string $filename): array
    {
        $json = $this->readMockResponseJson($filename);
        return json_decode($json, true);
    }
}