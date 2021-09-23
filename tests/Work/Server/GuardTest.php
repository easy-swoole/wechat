<?php
/**
 * Created by PhpStorm.
 * User: XueSi
 * Email: <1592328848@qq.com>
 * Date: 2021/4/26
 * Time: 1:14
 */

namespace EasySwoole\WeChat\Tests\Work\Server;

use EasySwoole\WeChat\Kernel\Contracts\MessageInterface;
use EasySwoole\WeChat\Kernel\Encryptor;
use EasySwoole\WeChat\Kernel\Exceptions\BadRequestException;
use EasySwoole\WeChat\Kernel\Messages\Message;
use EasySwoole\WeChat\Kernel\Messages\Text;
use EasySwoole\WeChat\Kernel\ServiceContainer;
use EasySwoole\WeChat\Kernel\ServiceProviders;
use EasySwoole\WeChat\Tests\Mock\Message\Status;
use EasySwoole\WeChat\Tests\TestCase;
use EasySwoole\WeChat\Work\Server\Guard;
use EasySwoole\WeChat\Work\Server\Handlers\EchoStrHandler;
use Psr\Http\Message\ResponseInterface;
use ReflectionProperty;

class GuardTest extends TestCase
{
    /**
     * 【验证回调URL】
     * 企业开启回调模式时，企业号会向验证url发送一个get请求
     * 假设点击验证时，企业收到类似请求：
     * GET /cgi-bin/wxpush?msg_signature=5c45ff5e21c57e6ad56bac8758b79b1d9ac89fd3&timestamp=1409659589&nonce=263014780&echostr=P9nAzCzyDtyTWESHep1vC5X9xho%2FqYX3Zpb4yKa9SKld1DsH3Iyt3tP3zNdtp%2B4RPcs8TgAE7OaBO%2BFZXvnaqQ%3D%3D
     * HTTP/1.1 Host: qy.weixin.qq.com
     *
     * @throws BadRequestException
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\InvalidArgumentException
     * @throws \Throwable
     */
    public function testServerForValidateCallbackUrl()
    {
        $mockData = $this->readMockData('echostr_validate_request.json');
        $mockData = json_decode($mockData, true);
        $mockRequest = $this->buildRequest(
            "GET",
            "https://qy.weixin.qq.com/cgi-bin/wxpush?" . urldecode(http_build_query($mockData['query'])),
            [],
            $mockData['body']
        );

        $app = new ServiceContainer([
            'corpId' => 'wx5823bf96d3bd56c7',
            'corpSecret' => 'mock_corpSecret',
            'token' => 'QDG6eK',
            'aesKey' => 'jWmYm7qr5nMoAUwZRjGtBxmz3KA1tkAj3ykkR6q2B2C',
        ]);

        $app->rebind(ServiceProviders::Encryptor, new Encryptor());

        $guard = new Guard($app);

        $guard->push(new EchoStrHandler($app), Message::VALIDATE);

        $response = $guard->serve($mockRequest);

        $this->assertInstanceOf(ResponseInterface::class, $response);
        $this->assertSame(Status::CODE_OK, $response->getStatusCode());
        $this->assertSame('1616140317555161061', $response->getBody()->__toString());
        $this->assertSame(['Content-Type' => ['application/xml']], $response->getHeaders());
    }

    /**
     * 【对用户回复的消息解密、企业回复用户消息的加密】
     *
     * @throws BadRequestException
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\InvalidArgumentException
     * @throws \Throwable
     */
    public function testServerForMessageRequest()
    {
        $mockData = $this->readMockData('message_request.json');
        $mockData = json_decode($mockData, true);
        $mockRequest = $this->buildRequest(
            "GET",
            "https://qy.weixin.qq.com/cgi-bin/wxpush?" . urldecode(http_build_query($mockData['query'])),
            [],
            $mockData['body']
        );

        $app = new ServiceContainer([
            'corpId' => 'wx5823bf96d3bd56c7',
            'corpSecret' => 'mock_corpSecret',
            'token' => 'QDG6eK',
            'aesKey' => 'jWmYm7qr5nMoAUwZRjGtBxmz3KA1tkAj3ykkR6q2B2C',
        ]);

        $app->rebind(ServiceProviders::Encryptor, new Encryptor());

        $guard = new Guard($app);

        $guard->push(function (MessageInterface $message) {
            return new Text('Hello EasySwooleWeChat!');
        }, Message::TEXT);

        $response = $guard->serve($mockRequest);

        $this->assertInstanceOf(ResponseInterface::class, $response);
        $this->assertSame(Status::CODE_OK, $response->getStatusCode());
        $this->assertIsString($response->getBody()->__toString());
        $this->assertSame(['Content-Type' => ['application/xml']], $response->getHeaders());
    }

    /**
     * @throws \ReflectionException
     */
    public function testForceValidate()
    {
        $app = new ServiceContainer([
            'corpId' => 'mock_corpId',
            'corpSecret' => 'mock_corpSecret',
            'token' => 'mock_token'
        ]);

        $guard = new Guard($app);

        $reflectionProperty = new ReflectionProperty($guard, 'alwaysValidate');
        $reflectionProperty->setAccessible(true);

        $this->assertFalse($reflectionProperty->getValue($guard));

        $guard->forceValidate();

        $this->assertTrue($reflectionProperty->getValue($guard));
    }

    public function testIsSafeMode()
    {
        $mockRequest = $this->buildRequest(
            "POST",
            "https://qy.weixin.qq.com?msg_signature=ASDFQWEXZCVAQFASDFASDFSS&timestamp=13500001234&nonce=123412323"
        );

        $app = new ServiceContainer([
            'corpId' => 'mock_corpId',
            'corpSecret' => 'mock_corpSecret',
            'token' => 'mock_token'
        ]);
        $guard = new Guard($app);

        $this->assertTrue($guard->isSafeMode($mockRequest));
    }

    /**
     * @param string $filename
     * @return string
     */
    private function readMockData(string $filename): string
    {
        return file_get_contents(__DIR__ . '/mock_data/' . $filename);
    }
}
