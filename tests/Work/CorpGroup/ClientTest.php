<?php
/**
 * Created by PhpStorm.
 * User: XueSi
 * Email: <1592328848@qq.com>
 * Date: 2021/4/24
 * Time: 18:30
 */

namespace EasySwoole\WeChat\Tests\Work\CorpGroup;


use EasySwoole\WeChat\Kernel\ServiceContainer;
use EasySwoole\WeChat\Tests\Mock\Message\Status;
use EasySwoole\WeChat\Tests\TestCase;
use Psr\Http\Message\ServerRequestInterface;
use EasySwoole\WeChat\Work\CorpGroup\Client;

class ClientTest extends TestCase
{
    public function testGetAppShareInfo()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('getAppShareInfo.json'));
        $app = $this->mockAccessToken(new ServiceContainer([
            'corpId' => 'mock_corpId',
            'corpSecret' => 'mock_corpSecret',
        ]));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/corpgroup/corp/list_app_share_info', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        $this->assertIsArray($client->getAppShareInfo(1111));
        $this->assertSame(json_decode($this->readMockResponseJson('getAppShareInfo.json'), true), $client->getAppShareInfo(1111));
    }

    public function testGetToken()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('getToken.json'));
        $app = $this->mockAccessToken(new ServiceContainer([
            'corpId' => 'mock_corpId',
            'corpSecret' => 'mock_corpSecret',
        ]));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/corpgroup/corp/gettoken', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);
        $this->assertIsArray($client->getToken('wwabc', 1111));
        $this->assertSame(json_decode($this->readMockResponseJson('getToken.json'), true), $client->getToken('wwabc', 1111));
    }

    public function testGetMiniProgramTransferSession()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('getMiniProgramTransferSession.json'));
        $app = $this->mockAccessToken(new ServiceContainer([
            'corpId' => 'mock_corpId',
            'corpSecret' => 'mock_corpSecret',
        ]));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/miniprogram/transfer_session', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);
        $this->assertIsArray($client->getMiniProgramTransferSession('wmAoNVCwAAUrSqEqz7oQpEIEMVWDrPeg', 'n8cnNEoyW1pxSRz6/Lwjwg=='));
        $this->assertSame(json_decode($this->readMockResponseJson('getMiniProgramTransferSession.json'), true), $client->getMiniProgramTransferSession('wmAoNVCwAAUrSqEqz7oQpEIEMVWDrPeg', 'n8cnNEoyW1pxSRz6/Lwjwg=='));
    }

    protected function readMockResponseJson(string $filename): string
    {
        return file_get_contents(__DIR__ . '/mock_data/' . $filename);
    }
}