<?php
/**
 * Created by PhpStorm.
 * User: XueSi
 * Email: <1592328848@qq.com>
 * Date: 2021/4/25
 * Time: 2:01
 */

namespace EasySwoole\WeChat\Tests\Work\MiniProgram\Auth;



use EasySwoole\WeChat\Kernel\ServiceContainer;
use EasySwoole\WeChat\Tests\Mock\Message\Status;
use EasySwoole\WeChat\Tests\TestCase;
use EasySwoole\WeChat\Work\MiniProgram\Auth\Client;
use Psr\Http\Message\ServerRequestInterface;

class ClientTest extends TestCase
{
    public function testGetSessionKey()
    {
//        $client = $this->mockApiClient(Client::class);
//
//        $client->expects()->httpGet('cgi-bin/miniprogram/jscode2session', [
//            'js_code' => 'js-code',
//            'grant_type' => 'authorization_code',
//        ])->andReturn('mock-result');
//
//        $this->assertSame('mock-result', $client->session('js-code'));

        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('session.json'));

        $app = $this->mockAccessToken(new ServiceContainer([
            'corpId' => 'mock_corpId',
            'corpSecret' => 'mock_corpSecret'
        ]));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('GET', $request->getMethod());
            $this->assertEquals('/cgi-bin/miniprogram/jscode2session', $request->getUri()->getPath());
            $this->assertEquals('js_code=mock_js-code&grant_type=authorization_code&access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        $this->assertIsArray($client->session('mock_js-code'));

        $this->assertSame(json_decode($this->readMockResponseJson('session.json'), true), $client->session('mock_js-code'));

    }

    protected function readMockResponseJson(string $filename): string
    {
        return file_get_contents(__DIR__ . '/mock_data/' . $filename);
    }
}