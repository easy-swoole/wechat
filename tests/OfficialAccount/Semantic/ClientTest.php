<?php


namespace EasySwoole\WeChat\Tests\OfficialAccount\Semantic;


use EasySwoole\WeChat\Kernel\ServiceContainer;
use EasySwoole\WeChat\OfficialAccount\Semantic\Client;
use EasySwoole\WeChat\Tests\Mock\Message\Status;
use EasySwoole\WeChat\Tests\TestCase;
use Psr\Http\Message\ServerRequestInterface;

class ClientTest extends TestCase
{
    public function testQuery()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('query.json'));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/semantic/semproxy/search', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);
        $this->assertIsArray($client->query('查一下明天从北京到上海的南航机票','flight,hotel',['city' => '北京','uid' => 123456]));
        $this->assertEquals(json_decode($this->readMockResponseJson('query.json'), true), $client->query('查一下明天从北京到上海的南航机票','flight,hotel',['city' => '北京','uid' => 123456]));
    }

    protected function readMockResponseJson(string $file): string
    {
        return file_get_contents(dirname(__FILE__) . '/mock_data/' . $file);
    }
}