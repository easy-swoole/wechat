<?php

namespace EasySwoole\WeChat\Tests\OfficialAccount\OCR;


use EasySwoole\WeChat\Kernel\Exceptions\HttpException;
use EasySwoole\WeChat\Kernel\ServiceContainer;
use EasySwoole\WeChat\OfficialAccount\OCR\Client;
use EasySwoole\WeChat\Tests\Mock\Message\Status;
use EasySwoole\WeChat\Tests\Mock\Message\Stream;
use EasySwoole\WeChat\Tests\TestCase;
use Psr\Http\Message\ServerRequestInterface;

class ClientTest extends TestCase
{

    /**
     * @throws HttpException
     */
    public function testIdCardByUrl()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('id_card.json'));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('GET', $request->getMethod());
            $this->assertEquals('/cv/ocr/idcard', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token&img_url=xxxxx', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);
        $this->assertIsArray($client->idCardByUrl('xxxxx'));
        $this->assertEquals(json_decode($this->readMockResponseJson('id_card.json'), true), $client->idCardByUrl('xxxxx'));
    }

    /**
     * @throws HttpException
     */
    public function testIdCardByStream()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('id_card.json'));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cv/ocr/idcard', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);
        $this->assertIsArray($client->idCardByStream(new Stream()));
        $this->assertEquals(json_decode($this->readMockResponseJson('id_card.json'), true), $client->idCardByStream(new Stream()));
    }

    /**
     * @throws HttpException
     */
    public function testBankCardByUrl()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('bank_card.json'));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('GET', $request->getMethod());
            $this->assertEquals('/cv/ocr/bankcard', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token&img_url=xxxxx', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);
        $this->assertIsArray($client->bankCardByUrl('xxxxx'));
        $this->assertEquals(json_decode($this->readMockResponseJson('bank_card.json'), true), $client->bankCardByUrl('xxxxx'));
    }

    /**
     * @throws HttpException
     */
    public function testBankCardByStream()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('bank_card.json'));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cv/ocr/bankcard', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);
        $this->assertIsArray($client->bankCardByStream(new Stream()));
        $this->assertEquals(json_decode($this->readMockResponseJson('bank_card.json'), true), $client->bankCardByStream(new Stream()));
    }

    /**
     * @throws HttpException
     */
    public function testVehicleLicenseByUrl()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('vehicle_license.json'));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('GET', $request->getMethod());
            $this->assertEquals('/cv/ocr/drivinglicense', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token&img_url=xxxxx', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);
        $this->assertIsArray($client->vehicleLicenseByUrl('xxxxx'));
        $this->assertEquals(json_decode($this->readMockResponseJson('vehicle_license.json'), true), $client->vehicleLicenseByUrl('xxxxx'));
    }

    /**
     * @throws HttpException
     */
    public function testVehicleLicenseByStream()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('vehicle_license.json'));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cv/ocr/drivinglicense', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);
        $this->assertIsArray($client->vehicleLicenseByStream(new Stream()));
        $this->assertEquals(json_decode($this->readMockResponseJson('vehicle_license.json'), true), $client->vehicleLicenseByStream(new Stream()));
    }

    protected function readMockResponseJson(string $file): string
    {
        return file_get_contents(dirname(__FILE__) . '/mock_data/' . $file);
    }
}
