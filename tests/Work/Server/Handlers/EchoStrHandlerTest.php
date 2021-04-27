<?php
/**
 * Created by PhpStorm.
 * User: XueSi
 * Email: <1592328848@qq.com>
 * Date: 2021/4/26
 * Time: 1:11
 */

namespace EasySwoole\WeChat\Tests\Work\Server\Handlers;


use EasySwoole\WeChat\Kernel\Messages\Raw;
use EasySwoole\WeChat\Tests\Mock\Message\Request;
use EasySwoole\WeChat\Tests\TestCase;
use EasySwoole\WeChat\Work\Server\Handlers\EchoStrHandler;

class EchoStrHandlerTest extends TestCase
{
    public function testHandle()
    {
        $mockRequest = $this->buildRequest(
            "POST",
            "https://test.com?echostr=mock-echostr"
        );

        $handle = new EchoStrHandler();
        $result = $handle->handle($mockRequest);

        $this->assertInstanceOf(Raw::class, $result);
        $this->assertSame("mock-echostr", $result->getContent());
    }

    public function testHandleWithoutEchoStr()
    {
        $mockRequest = $this->buildRequest(
            "POST",
            "https://test.com?signature=xxx"
        );

        $handle = new EchoStrHandler();

        $this->assertSame(null, $handle->handle($mockRequest));
    }

    public function testHandleInvalidRequest()
    {
        $handle = new EchoStrHandler();

        $this->assertSame(null, $handle->handle(new Request()));
    }
}