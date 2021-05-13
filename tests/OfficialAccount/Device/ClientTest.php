<?php


namespace EasySwoole\WeChat\Tests\OfficialAccount\Device;


use EasySwoole\WeChat\Kernel\ServiceContainer;
use EasySwoole\WeChat\OfficialAccount\Device\Client;
use EasySwoole\WeChat\Tests\Mock\Message\Status;
use EasySwoole\WeChat\Tests\TestCase;
use Psr\Http\Message\ServerRequestInterface;


class ClientTest extends TestCase
{

    public function message()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJsonByFunction(__FUNCTION__));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/card/giftcard/order/get', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);
        $this->assertIsArray($client->message('DEVICEID', 'OPEN_ID', 'BASE64编码内容'));
        $this->assertEquals($this->readMockResponseJsonByFunction(__FUNCTION__, true), $client->message('DEVICEID', 'OPEN_ID', 'BASE64编码内容'));
    }


    public function testQrCode()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJsonByFunction(__FUNCTION__));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/device/create_qrcode', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);
        $this->assertIsArray($client->qrCode(["01234", "56789"]));
        $this->assertEquals($this->readMockResponseJsonByFunction(__FUNCTION__, true), $client->qrCode(["01234", "56789"]));
    }

    public function testAuthorize()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJsonByFunction(__FUNCTION__));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/device/authorize_device', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $list = [
            [
                "id" => "dev1",
                "mac" => "123456789ABC",
                "connect_protocol" => "3",
                "auth_key" => "",
                "close_strategy" => "1",
                "conn_strategy" => "1",
                "crypt_method" => "0",
                "auth_ver" => "1",
                "manu_mac_pos" => "-1",
                "ser_mac_pos" => "-2",
                "ble_simple_protocol" => "0"
            ]
        ];
        $client = new Client($app);
        $this->assertIsArray($client->authorize($list, 12222));
        $this->assertEquals($this->readMockResponseJsonByFunction(__FUNCTION__, true), $client->authorize($list, 12222));
    }


    public function testCreateId()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJsonByFunction(__FUNCTION__));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('GET', $request->getMethod());
            $this->assertEquals('/device/getqrcode', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token&product_id=122222', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);
        $this->assertIsArray($client->createId(122222));
        $this->assertEquals($this->readMockResponseJsonByFunction(__FUNCTION__, true), $client->createId(122222));
    }

    public function testBind()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJsonByFunction(__FUNCTION__));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/device/bind', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);
        $this->assertTrue($client->bind('OPEN_ID', 'DEVICE_ID', 'TICKER'));
    }


    public function testUnbind()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJsonByFunction(__FUNCTION__));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/device/unbind', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);
        $this->assertTrue($client->unbind('OPEN_ID', 'DEVICE_ID', 'TICKER'));
    }

    public function testForceBind()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJsonByFunction(__FUNCTION__));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/device/compel_bind', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);
        $this->assertTrue($client->forceBind('OPEN_ID', 'DEVICE_ID'));
    }

    public function testForceUnbind()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJsonByFunction(__FUNCTION__));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/device/compel_unbind', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);
        $this->assertTrue($client->forceUnbind('OPEN_ID', 'DEVICE_ID'));
    }

    public function testStatus()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJsonByFunction(__FUNCTION__));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('GET', $request->getMethod());
            $this->assertEquals('/device/get_stat', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token&device_id=DEVICE_ID', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);
        $this->assertIsArray($client->status('DEVICE_ID'));
        $this->assertEquals($this->readMockResponseJsonByFunction(__FUNCTION__, true), $client->status('DEVICE_ID'));
    }


    public function testVerify()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJsonByFunction(__FUNCTION__));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/device/verify_qrcode', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);
        $this->assertIsArray($client->verify('QRCODE_TICKET'));
        $this->assertEquals($this->readMockResponseJsonByFunction(__FUNCTION__, true), $client->verify('QRCODE_TICKET'));
    }

    public function testOpenid()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJsonByFunction(__FUNCTION__));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('GET', $request->getMethod());
            $this->assertEquals('/device/get_openid', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token&device_id=DEVICE_ID', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);
        $this->assertIsArray($client->openid('DEVICE_ID'));
        $this->assertEquals($this->readMockResponseJsonByFunction(__FUNCTION__, true), $client->openid('DEVICE_ID'));
    }


    public function testListByOpenid()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJsonByFunction(__FUNCTION__));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('GET', $request->getMethod());
            $this->assertEquals('/device/get_bind_device', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token&openid=OPEN_ID', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);
        $this->assertIsArray($client->listByOpenid('OPEN_ID'));
        $this->assertEquals($this->readMockResponseJsonByFunction(__FUNCTION__, true), $client->listByOpenid('OPEN_ID'));
    }

    protected function readMockResponseJsonByFunction(string $func, bool $jsonDecode = false)
    {
        $fileName = strtolower(preg_replace('/(.)(?=[A-Z])/u', '$1' . '_', ltrim($func, 'test'))) . '.json';
        $ret = file_get_contents(dirname(__FILE__) . '/mock_data/' . $fileName);
        return $jsonDecode ? json_decode($ret, true) : $ret;
    }
}