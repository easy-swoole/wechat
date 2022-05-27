<?php
/**
 * Created by PhpStorm.
 * Author: hlh XueSi
 * Email: 1592328848@qq.com
 * Date: 2022/5/18 9:28:04
 */
declare(strict_types=1);

namespace EasySwoole\WeChat\Tests\OpenPlatform\Authorizer\MiniProgram\PrivacyInterface;

use EasySwoole\WeChat\Kernel\BaseClient;
use EasySwoole\WeChat\Kernel\ServiceContainer;
use EasySwoole\WeChat\OpenPlatform\Application;
use EasySwoole\WeChat\OpenPlatform\Authorizer\MiniProgram\PrivacyInterface\Client;
use EasySwoole\WeChat\Tests\Mock\Message\Status;
use EasySwoole\WeChat\Tests\TestCase;
use Psr\Http\Message\ServerRequestInterface;

class ClientTest extends TestCase
{
    public function testGet()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('get.json'));

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
            $this->assertEquals('/wxa/security/get_privacy_interface', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $miniProgram);

        $client = new Client($miniProgram);

        $ret = $client->get();

        $this->assertIsArray($ret);
        $this->assertSame(json_decode($this->readMockResponseJson('get.json'), true), $ret);
    }

    public function testApply()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('apply.json'));

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
            $this->assertEquals('/wxa/security/apply_privacy_interface', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $miniProgram);

        $client = new Client($miniProgram);

        $params = [
            "api_name"   => "wx.test",
            "content"    => "1312",
            "pic_list"   => [
                "pic_url1",
                "pic_url2"
            ],
            "video_list" => ["video_url1", "video_ul2"],
            "url_list"   => ["url1", "url2"]
        ];

        $ret = $client->apply($params);

        $this->assertIsArray($ret);
        $this->assertSame(json_decode($this->readMockResponseJson('apply.json'), true), $ret);
    }

    protected function readMockResponseJson(string $filename): string
    {
        return file_get_contents(__DIR__ . '/mock_data/' . $filename);
    }
}