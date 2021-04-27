<?php
/**
 * Created by PhpStorm.
 * User: XueSi
 * Email: <1592328848@qq.com>
 * Date: 2021/4/24
 * Time: 21:49
 */

namespace EasySwoole\WeChat\Tests\Work\ExternalContact;


use EasySwoole\WeChat\Kernel\Exceptions\InvalidArgumentException;
use EasySwoole\WeChat\Kernel\ServiceContainer;
use EasySwoole\WeChat\Tests\Mock\Message\Status;
use EasySwoole\WeChat\Tests\TestCase;
use EasySwoole\WeChat\Work\ExternalContact\MessageClient;
use Psr\Http\Message\ServerRequestInterface;

class MessageTest extends TestCase
{
    public function testSubmit()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('submit.json'));
        $app = $this->mockAccessToken(new ServiceContainer([
            'corpId' => 'mock_corpId',
            'corpSecret' => 'mock_corpSecret',
        ]));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/externalcontact/add_msg_template', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new MessageClient($app);

        $msg = [
            'chat_type' => 'single',
            'external_userid' => [
                'woAJ2GCAAAXtWyujaWJHDDGi0mACAAAA',
                'wmqfasd1e1927831123109rBAAAA',
            ],
            'sender' => 'zhangsan',
            'text' => [
                'content' => '文本消息内容',
            ],
            'attachments' => [
                [
                    'msgtype' => 'image',
                    'image' => [
                        'media_id' => 'MEDIA_ID',
                        'pic_url' => 'http://p.qpic.cn/pic_wework/3474110808/7a6344sdadfwehe42060/0',
                    ],
                ],
                [
                    'msgtype' => 'link',
                    'link' => [
                        'title' => '消息标题',
                        'picurl' => 'https://example.pic.com/path',
                        'desc' => '消息描述',
                        'url' => 'https://example.link.com/path',
                    ],
                ],
                [
                    'msgtype' => 'miniprogram',
                    'miniprogram' => [
                        'title' => '消息标题',
                        'pic_media_id' => 'MEDIA_ID',
                        'appid' => 'wx8bd80126147dfAAA',
                        'page' => '/path/index.html',
                    ],
                ],
                [
                    'msgtype' => 'video',
                    'video' => [
                        'media_id' => 'MEDIA_ID',
                    ],
                ],
            ],
        ];

        $this->assertIsArray($client->submit($msg));

        $this->assertSame(json_decode($this->readMockResponseJson('submit.json'), true), $client->submit($msg));
    }

    public function testSubmitWithoutTextContent()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('submit.json'));
        $app = $this->mockAccessToken(new ServiceContainer([
            'corpId' => 'mock_corpId',
            'corpSecret' => 'mock_corpSecret',
        ]));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/externalcontact/add_msg_template', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new MessageClient($app);

        $msg = [
            'text' => [
                'test',
            ],
        ];

        try {
            $client->submit($msg);
        } catch (\Exception $exception) {
            $this->assertInstanceOf(InvalidArgumentException::class, $exception);
            $this->assertSame('Attribute "content" can not be empty!', $exception->getMessage());
        }
    }

    public function testSubmitWithoutImageMediaId()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('submit.json'));
        $app = $this->mockAccessToken(new ServiceContainer([
            'corpId' => 'mock_corpId',
            'corpSecret' => 'mock_corpSecret',
        ]));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/externalcontact/add_msg_template', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new MessageClient($app);

        $msg = [
            'image' => [
                'test',
            ],
        ];

        try {
            $client->submit($msg);
        } catch (\Exception $exception) {
            $this->assertInstanceOf(InvalidArgumentException::class, $exception);
            $this->assertSame('Attribute "media_id" can not be empty!', $exception->getMessage());
        }
    }

    public function testSubmitWithoutLinkField()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('submit.json'));
        $app = $this->mockAccessToken(new ServiceContainer([
            'corpId' => 'mock_corpId',
            'corpSecret' => 'mock_corpSecret',
        ]));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/externalcontact/add_msg_template', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new MessageClient($app);

        try {
            $client->submit([
                'link' => [
                    'test',
                ],
            ]);
        } catch (\Exception $exception) {
            $this->assertInstanceOf(InvalidArgumentException::class, $exception);
            $this->assertSame('Attribute "title" can not be empty!', $exception->getMessage());
        }

        try {
            $client->submit([
                'link' => [
                    'title' => 'mock-title',
                ],
            ]);
        } catch (\Exception $exception) {
            $this->assertInstanceOf(InvalidArgumentException::class, $exception);
            $this->assertSame('Attribute "url" can not be empty!', $exception->getMessage());
        }
    }

    public function testSubmitWithoutMiniprogramField()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('submit.json'));
        $app = $this->mockAccessToken(new ServiceContainer([
            'corpId' => 'mock_corpId',
            'corpSecret' => 'mock_corpSecret',
        ]));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/externalcontact/add_msg_template', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new MessageClient($app);

        try {
            $client->submit([
                'miniprogram' => [
                    'test',
                ],
            ]);
        } catch (\Exception $exception) {
            $this->assertInstanceOf(InvalidArgumentException::class, $exception);
            $this->assertSame('Attribute "title" can not be empty!', $exception->getMessage());
        }

        try {
            $client->submit([
                'miniprogram' => [
                    'title' => 'mock-title',
                ],
            ]);
        } catch (\Exception $exception) {
            $this->assertInstanceOf(InvalidArgumentException::class, $exception);
            $this->assertSame('Attribute "pic_media_id" can not be empty!', $exception->getMessage());
        }

        try {
            $client->submit([
                'miniprogram' => [
                    'title' => 'mock-title',
                    'pic_media_id' => 'mock-pic_media_id',
                ],
            ]);
        } catch (\Exception $exception) {
            $this->assertInstanceOf(InvalidArgumentException::class, $exception);
            $this->assertSame('Attribute "appid" can not be empty!', $exception->getMessage());
        }

        try {
            $client->submit([
                'miniprogram' => [
                    'title' => 'mock-title',
                    'pic_media_id' => 'mock-pic_media_id',
                    'appid' => 'mock-appid',
                ],
            ]);
        } catch (\Exception $exception) {
            $this->assertInstanceOf(InvalidArgumentException::class, $exception);
            $this->assertSame('Attribute "page" can not be empty!', $exception->getMessage());
        }

        $this->assertSame(json_decode($this->readMockResponseJson('submit.json'), true), $client->submit([
            'miniprogram' => [
                'title' => 'mock-title',
                'pic_media_id' => 'mock-pic_media_id',
                'appid' => 'mock-appid',
                'page' => 'mock-page',
            ],
        ]));
    }

    public function testGetGroupMsgResult()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('get.json'));
        $app = $this->mockAccessToken(new ServiceContainer([
            'corpId' => 'mock_corpId',
            'corpSecret' => 'mock_corpSecret',
        ]));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/externalcontact/get_group_msg_result', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new MessageClient($app);

        $this->assertIsArray($client->get('msgGCAAAXtWyujaWJHDDGi0mACAAAA'));

        $this->assertSame(json_decode($this->readMockResponseJson('get.json'), true), $client->get('msgGCAAAXtWyujaWJHDDGi0mACAAAA'));
    }

    public function testSendWelcome()
    {
        $response = $this->buildResponse(Status::CODE_OK, '{"errcode":0,"errmsg":"ok"}');
        $app = $this->mockAccessToken(new ServiceContainer([
            'corpId' => 'mock_corpId',
            'corpSecret' => 'mock_corpSecret',
        ]));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/externalcontact/send_welcome_msg', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new MessageClient($app);

        $msg = [
            'text' => [
                'content' => '文本消息内容'
            ],
            'attachments' => [
                [
                    'msgtype' => 'image',
                    'image' => [
                        'media_id' => 'MEDIA_ID',
                        'pic_url' => 'http://p.qpic.cn/pic_wework/3474110808/7a6344sdadfwehe42060/0',
                    ]
                ],
                [
                    'msgtype' => 'link',
                    'link' => [
                        'title' => '消息标题',
                        'picurl' => 'https://example.pic.com/path',
                        'desc' => '消息描述',
                        'url' => 'https://example.link.com/path',
                    ]
                ],
                [
                    'msgtype' => 'miniprogram',
                    'miniprogram' => [
                        'title' => '消息标题',
                        'pic_media_id' => 'MEDIA_ID',
                        'appid' => 'wx8bd80126147dfAAA',
                        'page' => '/path/index.html'
                    ]
                ],
                [
                    'msgtype' => 'video',
                    'video' => [
                        'media_id' => 'MEDIA_ID'
                    ]
                ],
            ]
        ];

        $this->assertTrue($client->sendWelcome('CALLBACK_CODE', $msg));
    }

    protected function readMockResponseJson(string $filename): string
    {
        return file_get_contents(__DIR__ . '/mock_data/Message/' . $filename);
    }
}