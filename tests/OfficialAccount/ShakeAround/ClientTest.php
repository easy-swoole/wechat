<?php


namespace EasySwoole\WeChat\Tests\OfficialAccount\ShakeAround;


use EasySwoole\WeChat\Kernel\ServiceContainer;
use EasySwoole\WeChat\OfficialAccount\ShakeAround\Client;
use EasySwoole\WeChat\Tests\Mock\Message\Status;
use EasySwoole\WeChat\Tests\TestCase;
use Psr\Http\Message\ServerRequestInterface;

class ClientTest extends TestCase
{

    public function testRegister()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('register.json'));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/shakearound/account/register', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $data = [
            'name' => 'zhang_san',
            'phone_number' => '13512345678',
            'email' => 'weixin123@qq.com',
            'industry_id' => '0118',
            'qualification_cert_urls' => [
                'http://shp.qpic.cn/wx_shake_bus/0/1428565236d03d864b7f43db9ce34df5f720509d0e/0',
                'http://shp.qpic.cn/wx_shake_bus/0/1428565236d03d864b7f43db9ce34df5f720509d0e/0',
            ],
            'apply_reason' => 'test',
        ];
        $client = new Client($app);
        $this->assertIsArray($client->register($data));
        $this->assertEquals(json_decode($this->readMockResponseJson('register.json'), true), $client->register($data));
    }


    public function testStatus()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('status.json'));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('GET', $request->getMethod());
            $this->assertEquals('/shakearound/account/auditstatus', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);
        $this->assertIsArray($client->status());
        $this->assertEquals(json_decode($this->readMockResponseJson('status.json'), true), $client->status());
    }

    public function testUser()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('user.json'));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/shakearound/user/getshakeinfo', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);
        $this->assertIsArray($client->user('6ab3d8465166598a5f4e8c1b44f44645'));
        $this->assertEquals(json_decode($this->readMockResponseJson('user.json'), true), $client->user('6ab3d8465166598a5f4e8c1b44f44645'));
    }


    public function testUserWithPoi()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('user.json'));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/shakearound/user/getshakeinfo', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);
        $this->assertIsArray($client->userWithPoi('6ab3d8465166598a5f4e8c1b44f44645'));
        $this->assertEquals(json_decode($this->readMockResponseJson('user.json'), true), $client->userWithPoi('6ab3d8465166598a5f4e8c1b44f44645'));
    }

    private function readMockResponseJson(string $file): string
    {
        return file_get_contents(dirname(__FILE__) . '/mock_data/' . $file);
    }
}