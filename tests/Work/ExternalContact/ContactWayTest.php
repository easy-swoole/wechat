<?php
/**
 * Created by PhpStorm.
 * User: XueSi
 * Email: <1592328848@qq.com>
 * Date: 2021/4/24
 * Time: 21:18
 */

namespace EasySwoole\WeChat\Tests\Work\ExternalContact;

use EasySwoole\WeChat\Kernel\ServiceContainer;
use EasySwoole\WeChat\Tests\Mock\Message\Status;
use EasySwoole\WeChat\Tests\TestCase;
use EasySwoole\WeChat\Work\ExternalContact\ContactWayClient;
use Psr\Http\Message\ServerRequestInterface;


class ContactWayTest extends TestCase
{
    public function testCreate()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('create.json'));
        $app = $this->mockAccessToken(new ServiceContainer([
            'corpId' => 'mock_corpId',
            'corpSecret' => 'mock_corpSecret',
        ]));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/externalcontact/add_contact_way', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new ContactWayClient($app);

        $config = [
            'style' => 1,
            'remark' => '渠道客户',
            'skip_verify' => true,
            'state' => 'teststate',
            'user' => [
                'zhangsan',
                'lisi',
                'wangwu',
            ],
            'party' => [
                2,
                3,
            ],
            'is_temp' => true,
            'expires_in' => 86400,
            'chat_expires_in' => 86400,
            'unionid' => 'oxTWIuGaIt6gTKsQRLau2M0AAAA',
            'conclusions' => [
                'text' => [
                    'content' => '文本消息内容',
                ],
                'image' => [
                    'media_id' => 'MEDIA_ID',
                ],
                'link' => [
                    'title' => '消息标题',
                    'picurl' => 'https://example.pic.com/path',
                    'desc' => '消息描述',
                    'url' => 'https://example.link.com/path',
                ],
                'miniprogram' => [
                    'title' => '消息标题',
                    'pic_media_id' => 'MEDIA_ID',
                    'appid' => 'wx8bd80126147dfAAA',
                    'page' => '/path/index.html',
                ],
            ],
        ];

        $this->assertIsArray($client->create(1, 1, $config));

        $this->assertSame(json_decode($this->readMockResponseJson('create.json'), true), $client->create(1, 1, $config));
    }

    public function testGet()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('get.json'));
        $app = $this->mockAccessToken(new ServiceContainer([
            'corpId' => 'mock_corpId',
            'corpSecret' => 'mock_corpSecret',
        ]));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/externalcontact/get_contact_way', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new ContactWayClient($app);

        $this->assertIsArray($client->get('42b34949e138eb6e027c123cba77fad7'));

        $this->assertSame(json_decode($this->readMockResponseJson('get.json'), true), $client->get('42b34949e138eb6e027c123cba77fad7'));
    }

    public function testUpdate()
    {
        $response = $this->buildResponse(Status::CODE_OK, '{"errcode":0,"errmsg":"ok"}');
        $app = $this->mockAccessToken(new ServiceContainer([
            'corpId' => 'mock_corpId',
            'corpSecret' => 'mock_corpSecret',
        ]));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/externalcontact/update_contact_way', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new ContactWayClient($app);

        $config = [
            'remark' => '渠道客户',
            'skip_verify' => true,
            'style' => 1,
            'state' => 'teststate',
            'user' => [
                'zhangsan',
                'lisi',
                'wangwu',
            ],
            'party' => [
                2,
                3,
            ],
            'expires_in' => 86400,
            'chat_expires_in' => 86400,
            'unionid' => 'oxTWIuGaIt6gTKsQRLau2M0AAAA',
            'conclusions' => [
                'text' => [
                    'content' => '文本消息内容',
                ],
                'image' => [
                    'media_id' => 'MEDIA_ID',
                ],
                'link' => [
                    'title' => '消息标题',
                    'picurl' => 'https://example.pic.com/path',
                    'desc' => '消息描述',
                    'url' => 'https://example.link.com/path',
                ],
                'miniprogram' => [
                    'title' => '消息标题',
                    'pic_media_id' => 'MEDIA_ID',
                    'appid' => 'wx8bd80126147dfAAA',
                    'page' => '/path/index',
                ],
            ],
        ];

        $this->assertTrue($client->update('42b34949e138eb6e027c123cba77fAAA', $config));
    }

    public function testDelete()
    {
        $response = $this->buildResponse(Status::CODE_OK, '{"errcode":0,"errmsg":"ok"}');
        $app = $this->mockAccessToken(new ServiceContainer([
            'corpId' => 'mock_corpId',
            'corpSecret' => 'mock_corpSecret',
        ]));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/externalcontact/del_contact_way', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new ContactWayClient($app);

        $this->assertTrue($client->delete('42b34949e138eb6e027c123cba77fAAA'));
    }

    protected function readMockResponseJson(string $filename): string
    {
        return file_get_contents(__DIR__ . '/mock_data/ContactWay/' . $filename);
    }
}