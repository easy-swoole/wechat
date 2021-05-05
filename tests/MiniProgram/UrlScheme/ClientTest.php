<?php
/**
 * Created by PhpStorm.
 * User: XueSi
 * Email: <1592328848@qq.com>
 * Date: 2021/5/5
 * Time: 21:09
 */

namespace EasySwoole\WeChat\Tests\MiniProgram\UrlScheme;


use EasySwoole\WeChat\Kernel\ServiceContainer;
use EasySwoole\WeChat\Tests\Mock\Message\Status;
use EasySwoole\WeChat\Tests\TestCase;
use Psr\Http\Message\ServerRequestInterface;
use EasySwoole\WeChat\MiniProgram\UrlScheme\Client;

class ClientTest extends TestCase
{
    public function testGenerate()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('generate.json'));

        $app = $this->mockAccessToken(new ServiceContainer([
            'appId' => 'mock_appid',
            'appSecret' => 'mock_secret'
        ]));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/wxa/generatescheme', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        $params = [
            'jump_wxa' => [
                'path' => '/pages/publishHomework/publishHomework',
                'query' => ''
            ],
            'is_expire' => true,
            'expire_time' => 1606737600
        ];

        $this->assertIsArray($client->generate($params));

        $this->assertSame(json_decode($this->readMockResponseJson('generate.json'), true), $client->generate($params));
    }

    private function readMockResponseJson($filename)
    {
        return file_get_contents(__DIR__ . '/mock_data/' . $filename);
    }
}