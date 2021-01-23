<?php


namespace EasySwoole\WeChat\Tests\OfficialAccount\Broadcasting;


use EasySwoole\WeChat\Kernel\ServiceContainer;
use EasySwoole\WeChat\OfficialAccount\Broadcasting\Client;
use EasySwoole\WeChat\Tests\Mock\Message\Status;
use EasySwoole\WeChat\Tests\TestCase;
use Psr\Http\Message\ServerRequestInterface;

class ClientTest extends TestCase
{
    public function testSend()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('send.json'));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/message/mass/sendall', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);
        $this->assertIsArray($client->send([]));
        $this->assertEquals(json_decode($this->readMockResponseJson('send.json'), true), $client->send([]));
    }


    public function testStatus()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('status.json'));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/message/mass/get', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);
        $this->assertIsArray($client->status('201053012'));
        $this->assertEquals(json_decode($this->readMockResponseJson('status.json'), true), $client->status('201053012'));
    }


    public function testDelete()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('delete.json'));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/message/mass/delete', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);
        $this->assertTrue($client->delete('30124', 2));
    }

    protected function readMockResponseJson(string $file): string
    {
        return file_get_contents(dirname(__FILE__) . '/mock_data/' . $file);
    }
}
