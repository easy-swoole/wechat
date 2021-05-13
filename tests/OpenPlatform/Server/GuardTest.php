<?php
/**
 * Created by PhpStorm.
 * User: XueSi
 * Email: <1592328848@qq.com>
 * Date: 2021/5/11
 * Time: 2:52
 */

namespace EasySwoole\WeChat\Tests\OpenPlatform\Server;


use EasySwoole\WeChat\Kernel\Encryptor;
use EasySwoole\WeChat\Kernel\ServiceContainer;
use EasySwoole\WeChat\Kernel\ServiceProviders;
use EasySwoole\WeChat\OpenPlatform\Server\Guard;
use EasySwoole\WeChat\Tests\Mock\Message\Status;
use EasySwoole\WeChat\Tests\TestCase;
use Psr\Http\Message\ResponseInterface;

class GuardTest extends TestCase
{
    public function testServer1()
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
            'aesKey' => 'abcdefghijklmnopqrstuvwxyz0123456789ABCDEFG',
            'appId' => 'wxb11529c136998cb6',
            'token' => 'pamtest'
        ]);

        $app->rebind(ServiceProviders::Encryptor, new Encryptor());

        $guard = new Guard($app);

        $response = $guard->serve($mockRequest);

        $this->assertInstanceOf(ResponseInterface::class, $response);

        $this->assertSame(Status::CODE_OK, $response->getStatusCode());

        $this->assertSame(Guard::SUCCESS_EMPTY_RESPONSE, $response->getBody()->__toString());

        $this->assertSame(['Content-Type' => ['application/text']], $response->getHeaders());
    }

    public function testServer2()
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
            'appId' => 'wxb11529c136998cb6',
            'token' => 'pamtest'
        ]);

        $app->rebind(ServiceProviders::Encryptor, new Encryptor());

        $guard = new Guard($app);

        $response = $guard->serve($mockRequest);

        $this->assertInstanceOf(ResponseInterface::class, $response);

        $this->assertSame(Status::CODE_OK, $response->getStatusCode());

        $this->assertSame(Guard::SUCCESS_EMPTY_RESPONSE, $response->getBody()->__toString());

        $this->assertSame(['Content-Type' => ['application/text']], $response->getHeaders());
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