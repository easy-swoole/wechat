<?php
/**
 * Created by PhpStorm.
 * User: XueSi
 * Email: <1592328848@qq.com>
 * Date: 2021/4/26
 * Time: 1:14
 */

namespace EasySwoole\WeChat\Tests\Work\Server;


use EasySwoole\WeChat\Kernel\Contracts\RequestMessageInterface;
use EasySwoole\WeChat\Kernel\Exceptions\BadRequestException;
use EasySwoole\WeChat\Kernel\ServiceContainer;
use EasySwoole\WeChat\Kernel\Utility\XML;
use EasySwoole\WeChat\Tests\Mock\Message\Status;
use EasySwoole\WeChat\Tests\TestCase;
use EasySwoole\WeChat\Work\Server\Guard;
use EasySwoole\WeChat\Work\Server\ServiceProvider;
use Psr\Http\Message\ResponseInterface;
use ReflectionProperty;

class GuardTest extends TestCase
{
    /**
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\BadRequestException
     * @throws \Throwable
     */
    public function testServer()
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
            'corpId' => 'mock_corpId',
            'corpSecret' => 'mock_corpSecret',
            'token' => 'mock_token'
        ]);
        $guard = new Guard($app);

        $response = $guard->serve($mockRequest);

        $this->assertInstanceOf(ResponseInterface::class, $response);
        $this->assertSame(Status::CODE_OK, $response->getStatusCode());
        $this->assertSame(Guard::SUCCESS_EMPTY_RESPONSE, $response->getBody()->__toString());
        $this->assertSame(['Content-Type' => ['application/text']], $response->getHeaders());
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
            "https://test.com?signature=xxx&encrypt_type=aes"
        );

        $app = new ServiceContainer([
            'corpId' => 'mock_corpId',
            'corpSecret' => 'mock_corpSecret',
            'token' => 'mock_token'
        ]);
        $guard = new Guard($app);
        $this->assertTrue($guard->isSafeMode($mockRequest));

        $mockRequest = $this->buildRequest(
            "POST",
            "https://test.com?signature=xxx"
        );
        $this->assertFalse($guard->isSafeMode($mockRequest));
    }

    public function testIsValidateRequest()
    {
        $mockRequest = $this->buildRequest(
            "POST",
            "https://test.com?echostr=mock-echostr"
        );

        $app = new ServiceContainer([
            'corpId' => 'mock_corpId',
            'corpSecret' => 'mock_corpSecret',
            'token' => 'mock_token'
        ]);
        $guard = new Guard($app);
        $this->assertTrue($guard->isValidateRequest($mockRequest));

        $mockRequest = $this->buildRequest(
            "POST",
            "https://test.com?signature=xxx"
        );
        $this->assertFalse($guard->isValidateRequest($mockRequest));
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
            'corpId' => 'mock_corpId',
            'corpSecret' => 'mock_corpSecret',
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
            'corpId' => 'mock_corpId',
            'corpSecret' => 'mock_corpSecret',
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
        return file_get_contents(__DIR__ . '/mock_data/' . $filename);
    }
}