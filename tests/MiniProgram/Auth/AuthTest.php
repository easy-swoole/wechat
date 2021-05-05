<?php
/**
 * Created by PhpStorm.
 * User: XueSi
 * Email: <1592328848@qq.com>
 * Date: 2021/5/5
 * Time: 15:19
 */

namespace EasySwoole\WeChat\Tests\MiniProgram\Auth;


use EasySwoole\WeChat\Kernel\ServiceContainer;
use EasySwoole\WeChat\Tests\Mock\Message\Status;
use EasySwoole\WeChat\Tests\TestCase;
use EasySwoole\WeChat\MiniProgram\Auth\Client;
use Psr\Http\Message\ServerRequestInterface;

class AuthTest extends TestCase
{
    public function testGetSessionKey()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('session.json'));

        $app = $this->mockAccessToken(new ServiceContainer([
            'appId' => 'mock_appid',
            'appSecret' => 'mock_secret'
        ]));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('GET', $request->getMethod());
            $this->assertEquals('/sns/jscode2session', $request->getUri()->getPath());
            $this->assertEquals('appid=mock_appid&secret=mock_secret&js_code=mock_jscode&grant_type=authorization_code', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        $this->assertIsArray($client->session('mock_jscode'));

        $this->assertSame(json_decode($this->readMockResponseJson('session.json'), true), $client->session('mock_jscode'));
    }

    private function readMockResponseJson($filename)
    {
        return file_get_contents(__DIR__ . '/mock_data/' . $filename);
    }
}