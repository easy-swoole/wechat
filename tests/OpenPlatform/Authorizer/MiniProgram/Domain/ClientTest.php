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

    public function testModifyServerDomainDirectly()
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
            $this->assertEquals('/wxa/modify_domain_directly', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $miniProgram);

        $client = new Client($miniProgram);

        $params = [
            'action' => 'add',
            'requestdomain' => ['https://www.qq.com', 'https://www.qq.com'],
            'wsrequestdomain' => ['wss://www.qq.com', 'wss://www.qq.com'],
            'uploaddomain' => ['https://www.qq.com', 'https://www.qq.com'],
            'downloaddomain' => ['https://www.qq.com', 'https://www.qq.com'],
            'udpdomain' => ['udp://melody.weixin.melody.com'],
            'tcpdomain' => ['tcp://melody.weixin.melody.com'],
        ];

        $this->assertTrue($client->modifyServerDomainDirectly($params));
    }

    public function testGetJumpDomainConfirmFile()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('getJumpDomainConfirmFile.json'));

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
            $this->assertEquals('/wxa/get_webviewdomain_confirmfile', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $miniProgram);

        $client = new Client($miniProgram);

        $ret = $client->getJumpDomainConfirmFile();

        $this->assertIsArray($ret);

        $this->assertSame(json_decode($this->readMockResponseJson('getJumpDomainConfirmFile.json'), true), $ret);
    }

    public function testModifyJumpDomainDirectly()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('modifyJumpDomainDirectly.json'));

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
            $this->assertEquals('/wxa/setwebviewdomain_directly', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $miniProgram);

        $client = new Client($miniProgram);

        $action = 'add';
        $domains = [
            'https://www.qq.com',
            'https://m.qq.com',
        ];

        $ret = $client->modifyJumpDomainDirectly($domains, $action);

        $this->assertIsArray($ret);

        $this->assertSame(json_decode($this->readMockResponseJson('modifyJumpDomainDirectly.json'), true), $ret);
    }

    public function testGetEffectiveServerDomain()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('getEffectiveServerDomain.json'));

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
            $this->assertEquals('/wxa/get_effective_domain', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $miniProgram);

        $client = new Client($miniProgram);

        $ret = $client->getEffectiveServerDomain();

        $this->assertIsArray($ret);

        $this->assertSame(json_decode($this->readMockResponseJson('getEffectiveServerDomain.json'), true), $ret);
    }

    public function testGetEffectiveJumpDomain()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('getEffectiveJumpDomain.json'));

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
            $this->assertEquals('/wxa/get_effective_webviewdomain', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $miniProgram);

        $client = new Client($miniProgram);

        $ret = $client->getEffectiveJumpDomain();

        $this->assertIsArray($ret);

        $this->assertSame(json_decode($this->readMockResponseJson('getEffectiveJumpDomain.json'), true), $ret);
    }

    public function testGetPrefetchDomain()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('getPrefetchDomain.json'));

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
            $this->assertEquals('/wxa/get_prefetchdnsdomain', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $miniProgram);

        $client = new Client($miniProgram);

        $ret = $client->getPrefetchDomain();

        $this->assertIsArray($ret);

        $this->assertSame(json_decode($this->readMockResponseJson('getPrefetchDomain.json'), true), $ret);
    }

    public function testSetPrefetchDomain()
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
            $this->assertEquals('/wxa/set_prefetchdnsdomain', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $miniProgram);

        $client = new Client($miniProgram);

        $prefetchDnsDomain = [
            [
                'url' => 'd1.com',
            ],
            [
                'url' => 'd2.com'
            ],
        ];

        $this->assertTrue($client->setPrefetchDomain($prefetchDnsDomain));
    }

    protected function readMockResponseJson(string $filename): string
    {
        return file_get_contents(__DIR__ . '/mock_data/' . $filename);
    }
}
