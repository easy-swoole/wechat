<?php


namespace EasySwoole\WeChat\Tests\OfficialAccount\ShakeAround;


use EasySwoole\WeChat\Kernel\ServiceContainer;
use EasySwoole\WeChat\OfficialAccount\ShakeAround\RelationClient;
use EasySwoole\WeChat\Tests\Mock\Message\Status;
use EasySwoole\WeChat\Tests\TestCase;
use Psr\Http\Message\ServerRequestInterface;

class RelationClientTest extends TestCase
{

    public function testBindPages()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('stats_pages_summary.json'));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/shakearound/device/bindpage', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $data = [
            'device_id' => 10011,
            'uuid' => 'FDA50693-A4E2-4FB1-AFCF-C6EB07647825',
            'major' => 1002,
            'minor' => 1223,
        ];

        $client = new RelationClient($app);
        $this->assertIsArray($client->bindPages($data, [12345, 23456, 334567]));
        $this->assertEquals(json_decode($this->readMockResponseJson('stats_pages_summary.json'), true), $client->bindPages($data, [12345, 23456, 334567]));
    }

    public function testListByDeviceId()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('relation_search.json'));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/shakearound/relation/search', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $data = [
            'device_id' => 10011,
            'uuid' => 'FDA50693-A4E2-4FB1-AFCF-C6EB07647825',
            'major' => 1002,
            'minor' => 1223,
        ];

        $client = new RelationClient($app);
        $this->assertIsArray($client->listByDeviceId($data));
        $this->assertEquals(json_decode($this->readMockResponseJson('relation_search.json'), true), $client->listByDeviceId($data));
    }

    public function testListByPageId()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('relation_search.json'));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/shakearound/relation/search', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new RelationClient($app);
        $this->assertIsArray($client->listByPageId(11101,0,3));
        $this->assertEquals(json_decode($this->readMockResponseJson('relation_search.json'), true), $client->listByPageId(11101,0,3));
    }

    private function readMockResponseJson(string $file): string
    {
        return file_get_contents(dirname(__FILE__) . '/mock_data/' . $file);
    }
}
