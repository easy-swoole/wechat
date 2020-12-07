<?php


namespace EasySwoole\WeChat\Tests\OfficialAccount\CustomerService;


use EasySwoole\WeChat\Kernel\ServiceContainer;
use EasySwoole\WeChat\OfficialAccount\CustomerService\SessionClient;
use EasySwoole\WeChat\Tests\Mock\Message\Status;
use EasySwoole\WeChat\Tests\TestCase;
use Psr\Http\Message\ServerRequestInterface;

class SessionClientTest extends TestCase
{
    public function testList()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('session_list.json'));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('GET', $request->getMethod());
            $this->assertEquals('/customservice/kfsession/getsessionlist', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token&kf_account=xxx%40xxx', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new SessionClient($app);
        $this->assertIsArray($client->list('xxx@xxx'));
        $this->assertEquals(json_decode($this->readMockResponseJson('session_list.json'), true), $client->list('xxx@xxx'));
    }

    public function testWaiting()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('session_waiting.json'));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('GET', $request->getMethod());
            $this->assertEquals('/customservice/kfsession/getwaitcase', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new SessionClient($app);
        $this->assertIsArray($client->waiting());
        $this->assertEquals(json_decode($this->readMockResponseJson('session_waiting.json'), true), $client->waiting());
    }


    public function testCreate()
    {
        $response = $this->buildResponse(Status::CODE_OK, '{}');
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/customservice/kfsession/create', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new SessionClient($app);
        $this->assertTrue($client->create('test1@test','OPENID'));
    }


    public function testClose()
    {
        $response = $this->buildResponse(Status::CODE_OK, '{}');
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/customservice/kfsession/close', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new SessionClient($app);
        $this->assertTrue($client->close('test1@test','OPENID'));
    }

    public function testGet()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('session_get.json'));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('GET', $request->getMethod());
            $this->assertEquals('/customservice/kfsession/getsession', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token&openid=OPENID', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new SessionClient($app);
        $this->assertIsArray($client->get('OPENID'));
        $this->assertEquals(json_decode($this->readMockResponseJson('session_get.json'), true), $client->get('OPENID'));
    }

    protected function readMockResponseJson(string $file): string
    {
        return file_get_contents(dirname(__FILE__) . '/mock_data/' . $file);
    }
}