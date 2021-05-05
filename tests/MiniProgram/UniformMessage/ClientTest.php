<?php
/**
 * Created by PhpStorm.
 * User: XueSi
 * Email: <1592328848@qq.com>
 * Date: 2021/5/5
 * Time: 22:31
 */

namespace EasySwoole\WeChat\Tests\MiniProgram\UniformMessage;


use EasySwoole\WeChat\Kernel\Exceptions\InvalidArgumentException;
use EasySwoole\WeChat\Tests\TestCase;
use EasySwoole\WeChat\Kernel\ServiceContainer;
use EasySwoole\WeChat\Tests\Mock\Message\Status;
use Psr\Http\Message\ServerRequestInterface;
use EasySwoole\WeChat\MiniProgram\UniformMessage\Client;

class ClientTest extends TestCase
{
    public function testSend()
    {
        $response = $this->buildResponse(Status::CODE_OK, '{"errcode":0,"errmsg":""}');

        $app = $this->mockAccessToken(new ServiceContainer([
            'appId' => 'mock_appid',
            'appSecret' => 'mock_secret'
        ]));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/message/wxopen/template/uniform_send', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        // mock FormatMessage
        $message = [
            'touser' => 'OPENID',
            'weapp_template_msg' => [
                'template_id' => 'TEMPLATE_ID',
                'page' => 'page/page/index',
                'form_id' => 'FORMID',
                'data' => [
                    'keyword1' => [
                        'value' => '339208499',
                    ],
                    'keyword2' => [
                        'value' => '2015年01月05日 12:30',
                    ],
                    'keyword3' => [
                        'value' => '腾讯微信总部',
                    ],
                    'keyword4' => [
                        'value' => '广州市海珠区新港中路397号',
                    ],
                ],
                'emphasis_keyword' => 'keyword1.DATA',
            ],
            'mp_template_msg' => [
                'appid' => 'APPID ',
                'template_id' => 'TEMPLATE_ID',
                'url' => 'http://weixin.qq.com/download',
                'miniprogram' => [
                    'appid' => 'xiaochengxuappid12345',
                    'pagepath' => 'index?foo=bar',
                ],
                'data' => [
                    'first' => [
                        'value' => '恭喜你购买成功！',
                        'color' => '#173177',
                    ],
                    'keyword1' => [
                        'value' => '巧克力',
                        'color' => '#173177',
                    ],
                    'keyword2' => [
                        'value' => '39.8元',
                        'color' => '#173177',
                    ],
                    'keyword3' => [
                        'value' => '2014年9月22日',
                        'color' => '#173177',
                    ],
                    'remark' => [
                        'value' => '欢迎再次购买！',
                        'color' => '#173177',
                    ],
                ],
            ],
        ];

        $this->assertTrue($client->send($message));

        try {
            $client->send([
                'touser' => '',
                'mp_template_msg' => [],
            ]);
        } catch (\Exception $exception) {
            $this->assertInstanceOf(InvalidArgumentException::class, $exception);
            $this->assertSame('Attribute "touser" can not be empty!', $exception->getMessage());
        }

        $this->assertTrue($client->send([
            'touser' => 'mock-user',
            'mp_template_msg' => [],
        ]));

        $this->assertTrue($client->send([
            'touser' => 'mock-user',
            'weapp_template_msg' => [],
        ]));
    }

    public function testSendMpTemplateMsg()
    {
        $response = $this->buildResponse(Status::CODE_OK, '{"errcode":0,"errmsg":""}');

        $app = $this->mockAccessToken(new ServiceContainer([
            'appId' => 'mock_appid',
            'appSecret' => 'mock_secret'
        ]));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/message/wxopen/template/uniform_send', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        // mock FormatMpMessage
        $mpMessage = [
            'appid' => 'mock-appid',
            'template_id' => 'mock-template-id',
            'url' => 'mock-url',
            'miniprogram' => [
                'appid' => 'mock-mini-program-appid',
                'pagepath' => 'mock-page-path',
            ],
            'data' => [
                'foo' => 'string',
                'bar' => ['content', '#F00'],
                'baz' => ['value' => 'hello', 'color' => '#550038'],
                'zoo' => ['value' => 'hello'],
            ],
        ];

        $message = [
            'touser' => 'OPENID',
            'mp_template_msg' => $mpMessage,
        ];

        $this->assertTrue($client->send($message));

        // miss appid
        try {
            $client->send([
                'touser' => 'mock_touser',
                'mp_template_msg' => [
                    'appid' => '',
                    'template_id' => 'mock-template-id',
                    'url' => 'mock-url',
                    'miniprogram' => [
                        'appid' => 'mock-mini-program-appid',
                        'pagepath' => 'mock-page-path',
                    ],
                    'data' => [],
                ]
            ]);
        } catch (\Exception $exception) {
            $this->assertInstanceOf(InvalidArgumentException::class, $exception);
            $this->assertSame('Attribute "appid" can not be empty!', $exception->getMessage());
        }

        // miss template_id
        try {
            $client->send([
                'touser' => 'mock_touser',
                'mp_template_msg' => [
                    'appid' => 'mock-appid',
                    'template_id' => '',
                    'url' => 'mock-url',
                    'miniprogram' => [
                        'appid' => 'mock-mini-program-appid',
                        'pagepath' => 'mock-page-path',
                    ],
                    'data' => [],
                ]
            ]);
        } catch (\Exception $exception) {
            $this->assertInstanceOf(InvalidArgumentException::class, $exception);
            $this->assertSame('Attribute "template_id" can not be empty!', $exception->getMessage());
        }

        // miss miniprogram
        try {
            $client->send([
                'touser' => 'mock_touser',
                'mp_template_msg' => [
                    'appid' => 'mock-appid',
                    'template_id' => 'mock-template-id',
                    'url' => 'mock-url',
                    'miniprogram' => '',
                    'data' => [],
                ]
            ]);
        } catch (\Exception $exception) {
            $this->assertInstanceOf(InvalidArgumentException::class, $exception);
            $this->assertSame('Attribute "miniprogram" can not be empty!', $exception->getMessage());
        }
    }

    public function testSendWeappTemplateMsg()
    {
        $response = $this->buildResponse(Status::CODE_OK, '{"errcode":0,"errmsg":""}');

        $app = $this->mockAccessToken(new ServiceContainer([
            'appId' => 'mock_appid',
            'appSecret' => 'mock_secret'
        ]));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/message/wxopen/template/uniform_send', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        // mock FormatWeappMessage
        $weappMessage = [
            'template_id' => 'mock-template-id',
            'page' => 'mock-page',
            'form_id' => 'mock-form-id',
            'data' => [
                'foo' => 'string',
                'bar' => ['content', '#F00'],
                'baz' => ['value' => 'hello', 'color' => '#550038'],
                'zoo' => ['value' => 'hello'],
            ]
        ];

        $message = [
            'touser' => 'mock_touser',
            'weapp_template_msg' => $weappMessage,
            'mp_template_msg' => []
        ];

        $this->assertTrue($client->send($message));

        // miss template_id
        try {
            $client->send([
                'touser' => 'mock_touser',
                'weapp_template_msg' => [
                    'template_id' => '',
                    'page' => 'mock-page',
                    'form_id' => 'mock-from-id',
                    'data' => [],
                ],
                'mp_template_msg' => []
            ]);
        } catch (\Exception $exception) {
            $this->assertInstanceOf(InvalidArgumentException::class, $exception);
            $this->assertSame('Attribute "template_id" can not be empty!', $exception->getMessage());
        }

        // miss from_id
        try {
            $client->send([
                'touser' => 'mock_touser',
                'weapp_template_msg' => [
                    'template_id' => 'mock-template-id',
                    'page' => 'mock-page',
                    'form_id' => '',
                    'data' => [],
                ],
                'mp_template_msg' => []
            ]);
        } catch (\Exception $exception) {
            $this->assertInstanceOf(InvalidArgumentException::class, $exception);
            $this->assertSame('Attribute "form_id" can not be empty!', $exception->getMessage());
        }
    }
}