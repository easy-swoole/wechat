<?php

namespace EasySwoole\WeChat\Tests\OfficialAccount\Base;

use EasySwoole\WeChat\Kernel\Exceptions\HttpException;
use EasySwoole\WeChat\Kernel\ServiceContainer;
use EasySwoole\WeChat\OfficialAccount\Base\Client;
use EasySwoole\WeChat\Tests\Mock\Message\Status;
use EasySwoole\WeChat\Tests\TestCase;
use Psr\Http\Message\ServerRequestInterface;

class ClientTest extends TestCase
{
    /**
     * @throws HttpException
     */
    public function testClearQuota()
    {
        $response = $this->buildResponse(Status::CODE_OK, '{"errcode":0,"errmsg":"ok"}');
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/clear_quota', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);
        $this->assertTrue($client->clearQuota());
    }

    /**
     * @throws HttpException
     */
    public function testGetValidIps()
    {
        $body = $this->readMockResponseJson('getValidIps.json');
        $response = $this->buildResponse(Status::CODE_OK, $body);
        $app = $this->mockAccessToken(new ServiceContainer());
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('GET', $request->getMethod());
            $this->assertEquals('/cgi-bin/getcallbackip', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        $ret = $client->getValidIps();

        $this->assertIsArray($ret);
        $this->assertSame(json_decode($this->readMockResponseJson('getValidIps.json'), true), $ret);
        $this->assertEqualsCanonicalizing(json_decode($body, true), $ret);
    }

    /**
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\InvalidArgumentException
     */
    public function testCheckCallbackUrl()
    {
        $body = $this->readMockResponseJson('checkCallbackUrl.json');
        $response = $this->buildResponse(Status::CODE_OK, $body);
        $app = $this->mockAccessToken(new ServiceContainer());
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/callback/check', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        $action = 'all';
        $operator = 'DEFAULT';

        $ret = $client->checkCallbackUrl($action, $operator);

        $this->assertIsArray($ret);
        $this->assertSame(json_decode($this->readMockResponseJson('checkCallbackUrl.json'), true), $ret);
        $this->assertEqualsCanonicalizing(json_decode($body, true), $ret);
    }

    /**
     * @return string
     */
    private function readMockResponseJson(string $filename):string
    {
        return file_get_contents(dirname(__FILE__). '/mock_data/' . $filename);
    }
}