<?php
/**
 * Created by PhpStorm.
 * User: XueSi
 * Email: <1592328848@qq.com>
 * Date: 2021/4/24
 * Time: 14:37
 */

namespace EasySwoole\WeChat\Tests\OpenPlatform\Authorizer\MiniProgram\OpenAuth;

use EasySwoole\WeChat\Tests\Mock\Message\Status;
use EasySwoole\WeChat\Tests\TestCase;
use EasySwoole\WeChat\OpenPlatform\Application;
use Psr\Http\Message\ServerRequestInterface;
use EasySwoole\WeChat\OpenPlatform\Authorizer\MiniProgram\OpenAuth\Client;

class ClientTest extends TestCase
{
    public function testSession()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('session.json'));

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
            $this->assertEquals('GET', $request->getMethod());
            $this->assertEquals('/sns/component/jscode2session', $request->getUri()->getPath());
            $this->assertEquals('appid=mock_app_id&js_code=JSCODE&grant_type=authorization_code&component_appid=COMPONENT_APPID&component_access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $miniProgram);

        $client = new Client($miniProgram, $component);

        $this->assertIsArray($client->session('JSCODE'));

        $this->assertSame(json_decode($this->readMockResponseJson('session.json'), true), $client->session('JSCODE'));
    }

    protected function readMockResponseJson(string $filename): string
    {
        return file_get_contents(__DIR__ . '/mock_data/' . $filename);
    }
}
