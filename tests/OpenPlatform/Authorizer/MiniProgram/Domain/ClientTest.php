<?php
/**
 * Created by PhpStorm.
 * User: XueSi
 * Email: <1592328848@qq.com>
 * Date: 2021/5/10
 * Time: 22:37
 */

namespace EasySwoole\WeChat\Tests\OpenPlatform\Authorizer\MiniProgram\Domain;

use EasySwoole\WeChat\Tests\Mock\Message\Status;
use EasySwoole\WeChat\Tests\TestCase;
use EasySwoole\WeChat\OpenPlatform\Application;
use Psr\Http\Message\ServerRequestInterface;
use EasySwoole\WeChat\OpenPlatform\Authorizer\MiniProgram\Domain\Client;

class ClientTest extends TestCase
{
    public function testModify()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('modify.json'));

        /** @var Application $component */
        $component = $this->mockAccessToken(new Application([
            'appId' => 'COMPONENT_APPID',
            'token' => 'COMPONENT_TOKEN'
        ]));

        $miniProgram = $component->miniProgram(
            'mock_app_id', 'mock_refresh_token'
        );
        $miniProgram = $this->mockAccessToken($miniProgram);

        $miniProgram = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/wxa/modify_domain', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $miniProgram);

        $client = new Client($miniProgram);

        $params = [
            'action' => 'add',
            'requestdomain' => ['https://www.qq.com', 'https://www.qq.com'],
            'wsrequestdomain' => ['wss://www.qq.com', 'wss://www.qq.com'],
            'uploaddomain' => ['https://www.qq.com', 'https://www.qq.com'],
            'downloaddomain' => ['https://www.qq.com', 'https://www.qq.com']
        ];

        $ret = $client->modify($params);

        $this->assertIsArray($ret);

        $this->assertSame(json_decode($this->readMockResponseJson('modify.json'), true), $ret);
    }

    public function testSetWebviewDomain()
    {
        $response = $this->buildResponse(Status::CODE_OK, '{"errcode":0,"errmsg":"ok"}');

        /** @var Application $component */
        $component = $this->mockAccessToken(new Application([
            'appId' => 'COMPONENT_APPID',
            'token' => 'COMPONENT_TOKEN'
        ]));

        $miniProgram = $component->miniProgram(
            'mock_app_id', 'mock_refresh_token'
        );
        $miniProgram = $this->mockAccessToken($miniProgram);

        $miniProgram = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/wxa/setwebviewdomain', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $miniProgram);

        $client = new Client($miniProgram);

        $params = [
            'https://www.qq.com',
            'https://m.qq.com',
        ];

        $this->assertTrue($client->setWebviewDomain($params));
    }

    protected function readMockResponseJson(string $filename): string
    {
        return file_get_contents(__DIR__ . '/mock_data/' . $filename);
    }
}
