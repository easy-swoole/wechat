<?php
/**
 * User: XueSi
 * Date: 2021/9/14 17:09
 * Author: XueSi <1592328848@qq.com>
 */

namespace EasySwoole\WeChat\Tests\OpenPlatform\BetaMiniProgram;

use EasySwoole\WeChat\Kernel\ServiceContainer;
use EasySwoole\WeChat\OpenPlatform\BetaMiniProgram\Client;
use EasySwoole\WeChat\Tests\Mock\Message\Status;
use EasySwoole\WeChat\Tests\TestCase;
use Psr\Http\Message\ServerRequestInterface;

class ClientTest extends TestCase
{
    public function testFastRegisterBetaWeapp()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('fastRegisterBetaWeapp.json'));

        $app = $this->mockAccessToken(new ServiceContainer(['appId' => 'mock-componentAppId']));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/wxa/component/fastregisterbetaweapp', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
            $this->assertEquals('{"name":"小麦烤鸡","openid":"oK8Yg5YaUM-axuE_vVZmV_oIZxxx"}', $request->getBody()->getContents());
        }, $response, $app);

        $client = new Client($app);

        $ret = $client->fastRegisterBetaWeapp('小麦烤鸡', 'oK8Yg5YaUM-axuE_vVZmV_oIZxxx');

        $this->assertIsArray($ret);
        $this->assertSame(json_decode($this->readMockResponseJson('fastRegisterBetaWeapp.json'), true), $ret);
    }

    protected function readMockResponseJson(string $file): string
    {
        return file_get_contents(dirname(__FILE__) . '/mock_data/' . $file);
    }
}
