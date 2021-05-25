<?php
/**
 * Created by PhpStorm.
 * User: XueSi
 * Email: <1592328848@qq.com>
 * Date: 2021/5/10
 * Time: 23:06
 */

namespace EasySwoole\WeChat\Tests\OpenPlatform\Authorizer\MiniProgram\Material;

use EasySwoole\WeChat\Kernel\Psr\StreamResponse;
use EasySwoole\WeChat\Tests\Mock\Message\Status;
use EasySwoole\WeChat\Tests\TestCase;
use EasySwoole\WeChat\OpenPlatform\Application;
use Psr\Http\Message\ServerRequestInterface;
use EasySwoole\WeChat\OpenPlatform\Authorizer\MiniProgram\Material\Client;

class ClientTest extends TestCase
{
    // 获取图文素材
    public function testGet1()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('get1.json'));

        /** @var Application $component */
        $component = $this->mockAccessToken(new Application([
            'appId' => 'COMPONENT_APPID',
            'token' => 'COMPONENT_TOKEN'
        ]));

        $officialAccount = $component->officialAccount(
            'mock_app_id', 'mock_refresh_token'
        );
        $officialAccount = $this->mockAccessToken($officialAccount);

        $officialAccount = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/material/get_material', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $officialAccount);

        $client = new Client($officialAccount);

        $ret = $client->get('MEDIA_ID');

        $this->assertIsArray($ret);

        $this->assertSame(json_decode($this->readMockResponseJson('get1.json'), true), $ret);
    }

    // 获取视频消息素材
    public function testGet2()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('get2.json'));

        /** @var Application $component */
        $component = $this->mockAccessToken(new Application([
            'appId' => 'COMPONENT_APPID',
            'token' => 'COMPONENT_TOKEN'
        ]));

        $officialAccount = $component->officialAccount(
            'mock_app_id', 'mock_refresh_token'
        );
        $officialAccount = $this->mockAccessToken($officialAccount);

        $officialAccount = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/material/get_material', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $officialAccount);

        $client = new Client($officialAccount);

        $ret = $client->get('MEDIA_ID');

        $this->assertIsArray($ret);

        $this->assertSame(json_decode($this->readMockResponseJson('get2.json'), true), $ret);
    }

    public function testGet3()
    {
        $response = $this->buildResponse(Status::CODE_OK, file_get_contents(__DIR__ . '/mock_data/MEDIA_ID.jpg'), [
            'Content-disposition' => [
                'attachment',
                'filename="MEDIA_ID.jpg'
            ]
        ]);

        /** @var Application $component */
        $component = $this->mockAccessToken(new Application([
            'appId' => 'COMPONENT_APPID',
            'token' => 'COMPONENT_TOKEN'
        ]));

        $officialAccount = $component->officialAccount(
            'mock_app_id', 'mock_refresh_token'
        );
        $officialAccount = $this->mockAccessToken($officialAccount);

        $officialAccount = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/material/get_material', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $officialAccount);

        $client = new Client($officialAccount);

        $ret = $client->get('MEDIA_ID');

        $this->assertInstanceOf(StreamResponse::class, $ret);
    }

    protected function readMockResponseJson(string $filename): string
    {
        return file_get_contents(__DIR__ . '/mock_data/' . $filename);
    }
}
