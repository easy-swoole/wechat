<?php


namespace EasySwoole\WeChat\Tests\OfficialAccount\Card;


use EasySwoole\WeChat\Kernel\ServiceContainer;
use EasySwoole\WeChat\OfficialAccount\Card\InvoiceClient;
use EasySwoole\WeChat\Tests\Mock\Message\Status;
use EasySwoole\WeChat\Tests\TestCase;
use Psr\Http\Message\ServerRequestInterface;


class InvoiceClientTest extends TestCase
{
    public function testSet()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJsonByFunction(__FUNCTION__));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/card/invoice/setbizattr', $request->getUri()->getPath());
            $this->assertEquals('action=set_pay_mch&access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new InvoiceClient($app);
        $this->assertTrue($client->set('1234', 'wxabcd'));
    }

    public function testGet()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJsonByFunction(__FUNCTION__));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/card/invoice/setbizattr', $request->getUri()->getPath());
            $this->assertEquals('action=get_pay_mch&access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new InvoiceClient($app);
        $this->assertIsArray($client->get());
        $this->assertEquals($this->readMockResponseJsonByFunction(__FUNCTION__, true), $client->get());
    }

    public function testSetAuthField()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJsonByFunction(__FUNCTION__));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/card/invoice/setbizattr', $request->getUri()->getPath());
            $this->assertEquals('action=set_auth_field&access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $userData = [
            "require_phone" => 1,
            "custom_field" => [
                [
                    "is_require" => 1,
                    "key" => "field1"
                ]
            ],
            "show_email" => 1,
            "show_title" => 1,
            "show_phone" => 1,
            "require_email" => 1
        ];

        $bizData = [
            "require_phone" => 0,
            "custom_field" => [
                [
                    "is_require" => 0,
                    "key" => "field2"
                ]
            ],
            "require_bank_type" => 0,
            "require_tax_no" => 0,
            "show_addr" => 1,
            "require_addr" => 0,
            "show_title" => 1,
            "show_tax_no" => 1,
            "show_phone" => 1,
            "show_bank_type" => 1,
            "show_bank_no" => 1,
            "require_bank_no" => 0
        ];

        $client = new InvoiceClient($app);
        $this->assertTrue($client->setAuthField($userData, $bizData));
    }


    public function testGetAuthField()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJsonByFunction(__FUNCTION__));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/card/invoice/setbizattr', $request->getUri()->getPath());
            $this->assertEquals('action=get_auth_field&access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new InvoiceClient($app);
        $this->assertIsArray($client->getAuthField());
        $this->assertEquals($this->readMockResponseJsonByFunction(__FUNCTION__, true), $client->getAuthField());
    }

    public function testGetAuthData()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJsonByFunction(__FUNCTION__));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/card/invoice/getauthdata', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new InvoiceClient($app);
        $this->assertIsArray($client->getAuthData('xxx', 'xxx'));
        $this->assertEquals($this->readMockResponseJsonByFunction(__FUNCTION__, true), $client->getAuthData('xxx', 'xxx'));
    }

    protected function readMockResponseJsonByFunction(string $func, bool $jsonDecode = false)
    {
        $fileName = strtolower(preg_replace('/(.)(?=[A-Z])/u', '$1' . '_', ltrim($func, 'test'))) . '.json';
        $ret = file_get_contents(dirname(__FILE__) . '/mock_data/invoice_' . $fileName);
        return $jsonDecode ? json_decode($ret, true) : $ret;
    }
}