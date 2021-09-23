<?php
/**
 * Created by PhpStorm.
 * User: XueSi
 * Email: <1592328848@qq.com>
 * Date: 2021/4/26
 * Time: 1:11
 */

namespace EasySwoole\WeChat\Tests\Work\Server\Handlers;


use EasySwoole\WeChat\Kernel\Encryptor;
use EasySwoole\WeChat\Kernel\Messages\Raw;
use EasySwoole\WeChat\Kernel\ServiceContainer;
use EasySwoole\WeChat\Kernel\ServiceProviders;
use EasySwoole\WeChat\Tests\Mock\Message\Request;
use EasySwoole\WeChat\Tests\TestCase;
use EasySwoole\WeChat\Work\Server\Handlers\EchoStrHandler;

class EchoStrHandlerTest extends TestCase
{
    public function testHandle()
    {
        $mockData = $this->readMockData('testHandle.json');
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

        $handle = new EchoStrHandler($app);
        $result = $handle->handle($mockRequest);

        $this->assertInstanceOf(Raw::class, $result);
        $this->assertSame("1616140317555161061", $result->getContent());
    }

    public function testHandleInvalidRequest()
    {
        $app = new ServiceContainer([
            'corpId' => 'wx5823bf96d3bd56c7',
            'corpSecret' => 'mock_corpSecret',
            'token' => 'QDG6eK',
            'aesKey' => 'jWmYm7qr5nMoAUwZRjGtBxmz3KA1tkAj3ykkR6q2B2C',
        ]);

        $app->rebind(ServiceProviders::Encryptor, new Encryptor());

        $handle = new EchoStrHandler($app);

        $this->assertSame(null, $handle->handle(new Request()));
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
