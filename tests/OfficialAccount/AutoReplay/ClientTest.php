<?php

namespace EasySwoole\WeChat\Tests\OfficialAccount\AutoReplay;

use EasySwoole\WeChat\Kernel\Exceptions\HttpException;
use EasySwoole\WeChat\Kernel\ServiceContainer;
use EasySwoole\WeChat\OfficialAccount\AutoReplay\Client;
use EasySwoole\WeChat\Tests\Mock\Message\Status;
use EasySwoole\WeChat\Tests\TestCase;
use Psr\Http\Message\ServerRequestInterface;

class ClientTest extends TestCase
{
    /**
     * @throws HttpException
     */
    public function testCurrent()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson());
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('GET', $request->getMethod());
            $this->assertEquals('/cgi-bin/get_current_autoreply_info', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);
        $this->assertIsArray($client->current());
        $this->assertEquals(json_decode($this->readMockResponseJson(), true), $client->current());
    }

    /**
     * @return string
     */
    private function readMockResponseJson():string
    {
        return file_get_contents(dirname(__FILE__). '/mock_data/auto_replay.json');
    }
}