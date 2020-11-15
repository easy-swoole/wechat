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
        $body = '{"ip_list":["127.0.0.1","127.0.0.2","101.226.103.0/25"]}';
        $response = $this->buildResponse(Status::CODE_OK, $body);
        $app = $this->mockAccessToken(new ServiceContainer());
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('GET', $request->getMethod());
            $this->assertEquals('/cgi-bin/getcallbackip', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);
        $this->assertEqualsCanonicalizing(json_decode($body, true), $client->getValidIps());
    }
}