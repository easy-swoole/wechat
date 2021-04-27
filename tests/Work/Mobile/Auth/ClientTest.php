<?php
/**
 * Created by PhpStorm.
 * User: XueSi
 * Email: <1592328848@qq.com>
 * Date: 2021/4/25
 * Time: 2:19
 */

namespace EasySwoole\WeChat\Tests\Work\Mobile\Auth;


use EasySwoole\WeChat\Kernel\ServiceContainer;
use EasySwoole\WeChat\Tests\Mock\Message\Status;
use EasySwoole\WeChat\Tests\TestCase;
use EasySwoole\WeChat\Work\Mobile\Auth\Client;
use Psr\Http\Message\ServerRequestInterface;

class ClientTest extends TestCase
{
    public function testGetUserinfo()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('getUserinfo.json'));

        $app = $this->mockAccessToken(new ServiceContainer([
            'corpId' => 'mock_corpId',
            'corpSecret' => 'mock_corpSecret'
        ]));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('GET', $request->getMethod());
            $this->assertEquals('/cgi-bin/user/getuserinfo', $request->getUri()->getPath());
            $this->assertEquals('code=mock_code&access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        $this->assertIsArray($client->getUser('mock_code'));

        $this->assertSame(json_decode($this->readMockResponseJson('getUserinfo.json'), true), $client->getUser('mock_code'));
    }

    protected function readMockResponseJson(string $filename): string
    {
        return file_get_contents(__DIR__ . '/mock_data/' . $filename);
    }
}