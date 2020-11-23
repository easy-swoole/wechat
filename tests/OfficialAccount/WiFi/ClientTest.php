<?php

namespace EasySwoole\WeChat\Tests\OfficialAccount\WiFi;


use EasySwoole\WeChat\Kernel\ServiceContainer;
use EasySwoole\WeChat\OfficialAccount\WiFi\Client;
use EasySwoole\WeChat\Tests\Mock\Message\Status;
use EasySwoole\WeChat\Tests\TestCase;
use Psr\Http\Message\ServerRequestInterface;

class ClientTest extends TestCase
{
    public function testSummary()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('statistics_list.json'));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/bizwifi/statistics/list', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);
        $this->assertIsArray($client->summary('2015-05-01', '2015-05-02', -1));
        $this->assertEquals(json_decode($this->readMockResponseJson('statistics_list.json'), true), $client->summary('2015-05-01', '2015-05-02', -1));
    }

    public function testGetQrCodeUrl()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('qrcode_get.json'));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/bizwifi/qrcode/get', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);
        $this->assertIsArray($client->getQrCodeUrl(429620, 'WX567', 1));
        $this->assertEquals(json_decode($this->readMockResponseJson('qrcode_get.json'), true), $client->getQrCodeUrl(429620, 'WX567', 1));
    }

    public function testSetFinishPage()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('qrcode_get.json'));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/bizwifi/finishpage/set', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);
        $client->setFinishPage([
            'shop_id' => 429620,
            'finishpage_url' => '',
            'wxa_user_name' => 'gh_966b66e00888',
            'wxa_path' => 'pages/index/index',
            'finishpage_type' => 1,
        ]);
    }

    public function testSetHomePage()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('qrcode_get.json'));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/bizwifi/homepage/set', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);
        $client->setHomePage([
            'shop_id' => 2200766,
            'template_id' => 2,
            'struct' => [
                'wxa_user_name' => 'gh_5cb1b4334f3a',
                'wxa_path' => 'index.html?query=abc',
            ]
        ]);
    }

    private function readMockResponseJson(string $file): string
    {
        return file_get_contents(dirname(__FILE__) . '/mock_data/' . $file);
    }
}