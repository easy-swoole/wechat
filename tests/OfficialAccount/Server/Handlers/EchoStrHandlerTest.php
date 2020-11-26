<?php


namespace EasySwoole\WeChat\Tests\OfficialAccount\Server\Handlers;


use EasySwoole\WeChat\Kernel\Messages\Raw;
use EasySwoole\WeChat\OfficialAccount\Server\Handlers\EchoStrHandler;
use EasySwoole\WeChat\Tests\Mock\Message\Request;
use EasySwoole\WeChat\Tests\TestCase;

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