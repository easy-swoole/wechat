<?php
/**
 * User: XueSi
 * Date: 2021/6/17 19:54
 * Author: XueSi <1592328848@qq.com>
 */
declare(strict_types=1);

namespace EasySwoole\WeChat\Tests\MiniProgram\UrlLink;


use EasySwoole\WeChat\Kernel\ServiceContainer;
use EasySwoole\WeChat\MiniProgram\UrlLink\Client;
use EasySwoole\WeChat\Tests\Mock\Message\Status;
use EasySwoole\WeChat\Tests\TestCase;
use Psr\Http\Message\ServerRequestInterface;

class ClientTest extends TestCase
{
    public function testGeneralUrllink()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('generateUrllink.json'));

        $app = $this->mockAccessToken(new ServiceContainer([
            'appId' => 'mock_appid',
            'appSecret' => 'mock_secret'
        ]));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/wxa/generate_urllink', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        $params = [
            'path' => '/pages/publishHomework/publishHomework',
            'query' => '',
            'is_expire' => true,
            'expire_type' => 1,
            'expire_interval' => 1,
            'cloud_base' => [
                'env' => 'xxx',
                'domain' => 'xxx.xx',
                'path' => '/jump-wxa.html',
                'query' => 'a=1&b=2',
            ]
        ];

        $ret = $client->generate_urllink($params);

        $this->assertIsArray($ret);

        $this->assertSame(json_decode($this->readMockResponseJson('generateUrllink.json'), true), $ret);
    }

    private function readMockResponseJson($filename)
    {
        return file_get_contents(__DIR__ . '/mock_data/' . $filename);
    }
}
