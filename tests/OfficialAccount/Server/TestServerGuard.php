<?php


namespace EasySwoole\WeChat\Tests\OfficialAccount\Server;


use EasySwoole\WeChat\Kernel\Contracts\RequestMessageInterface;
use EasySwoole\WeChat\Kernel\Exceptions\BadRequestException;
use EasySwoole\WeChat\Kernel\ServiceContainer;
use EasySwoole\WeChat\Kernel\Utility\XML;
use EasySwoole\WeChat\OfficialAccount\Server\Guard;
use EasySwoole\WeChat\OfficialAccount\Server\ServiceProvider;
use EasySwoole\WeChat\Tests\TestCase;

class TestServerGuard extends TestCase
{
    public function testIsSafeMode()
    {
        $mockRequest = $this->buildRequest(
            "POST",
            "https://test.com?&signature=xxx&encrypt_type=aes"
        );

        $app = new ServiceContainer([
            'appId' => '123456',
            'token' => 'mock_token'
        ]);
        $guard = new Guard($app);
        $this->assertTrue($guard->isSafeMode($mockRequest));

        $mockRequest = $this->buildRequest(
            "POST",
            "https://test.com?&signature=xxx"
        );
        $this->assertFalse($guard->isSafeMode($mockRequest));
    }

    /**
     * @throws BadRequestException
     */
    public function testParseRequest()
    {
        $mockData = $this->readMockData('clear_mode_request.json');
        $mockData = json_decode($mockData, true);
        $mockRequest = $this->buildRequest(
            "POST",
            "https://test.com?" . http_build_query($mockData['query']),
            [],
            $mockData['body']
        );

        $app = new ServiceContainer([
            'appId' => '123456',
            'token' => 'dczmnau31ea9nzcn13i91uedjdal'
        ]);
        $guard = new Guard($app);

        $this->assertInstanceOf(RequestMessageInterface::class, $guard->parseRequest($mockRequest));

        $this->assertEquals($mockData['body'], $guard->parseRequest($mockRequest)->transformToXml());
        $this->assertEquals(XML::parse($mockData['body']), $guard->parseRequest($mockRequest)->transformForJsonRequest());
    }

    /**
     * @throws BadRequestException
     */
    public function testParseRequestWithSafeMode()
    {
        $mockData = $this->readMockData('safe_mode_request.json');
        $mockData = json_decode($mockData, true);
        $mockRequest = $this->buildRequest(
            "POST",
            "https://test.com?" . http_build_query($mockData['query']),
            [],
            $mockData['body']
        );

        $app = new ServiceContainer([
            'appId' => 'wxefe41fdee1714229',
            'token' => 'dczmnau31ea9nzcn13i91uedjdal',
            'aesKey' => 'pz2Zl2by0oZQ6AUV4EvnbF7A7VRUvrLN1vqnxsUjmTW'
        ]);
        $app->register(new ServiceProvider());
        $guard = new Guard($app);

        $this->assertInstanceOf(RequestMessageInterface::class, $guard->parseRequest($mockRequest));

        $this->assertEquals($mockData['clear_body'], $guard->parseRequest($mockRequest)->transformToXml());
        $this->assertEquals(XML::parse($mockData['clear_body']), $guard->parseRequest($mockRequest)->transformForJsonRequest());
    }

    /**
     * @param string $filename
     * @return string
     */
    private function readMockData(string $filename): string
    {
        return file_get_contents(dirname(__FILE__) . '/mock_data/' . $filename);
    }
}