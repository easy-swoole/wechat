<?php

namespace EasySwoole\WeChat\Tests\OfficialAccount\Store;


use EasySwoole\WeChat\Kernel\ServiceContainer;
use EasySwoole\WeChat\OfficialAccount\Store\Client;
use EasySwoole\WeChat\Tests\Mock\Message\Status;
use EasySwoole\WeChat\Tests\TestCase;
use Psr\Http\Message\ServerRequestInterface;

class ClientTest extends TestCase
{
    public function testCategories()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('categories.json'));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('GET', $request->getMethod());
            $this->assertEquals('/wxa/get_merchant_category', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);
        $this->assertIsArray($client->categories());
        $this->assertEquals(json_decode($this->readMockResponseJson('categories.json'), true), $client->categories());
    }

    public function testDistricts()
    {

        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('districts.json'));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('GET', $request->getMethod());
            $this->assertEquals('/wxa/get_district', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);
        $this->assertIsArray($client->districts());
        $this->assertEquals(json_decode($this->readMockResponseJson('districts.json'), true), $client->districts());
    }

    public function testSearchFromMap()
    {

        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('search_map.json'));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/wxa/search_map_poi', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);
        $this->assertIsArray($client->searchFromMap(440105, 'X'));
        $this->assertEquals(json_decode($this->readMockResponseJson('search_map.json'), true), $client->searchFromMap(440105, 'X'));

    }

    public function testGetStatus()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('get_status.json'));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('GET', $request->getMethod());
            $this->assertEquals('/wxa/get_merchant_audit_info', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);
        $this->assertIsArray($client->getStatus());
        $this->assertEquals(json_decode($this->readMockResponseJson('get_status.json'), true), $client->getStatus());
    }

    public function testCreateMerchant()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('create_merchant.json'));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/wxa/apply_merchant', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $data = [
            'first_catid' => 476,
            'second_catid' => 477,
            'qualification_list' => 'RTZgKZ386yFn5kQSWLTxe4bqxwgzGBjs3OE02cg9CVQk1wRVE3c8fjUFX7jvpi-P',
            'headimg_mediaid' => 'RTZgKZ386yFn5kQSWLTxe4bqxwgzGBjs3OE02cg9CVQk1wRVE3c8fjUFX7jvpi-P',
            'nickname' => 'hardenzhang308',
            'intro' => 'hardenzhangtest',
            'org_code' => '',
            'other_files' => '',
        ];
        $client = new Client($app);
        $this->assertTrue($client->createMerchant($data));
    }

    public function testUpdateMerchant()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('update_merchant.json'));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/wxa/modify_merchant', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $data = [
            'headimg_mediaid' => 'xxxxx',
            'intro' => 'x',
        ];
        $client = new Client($app);
        $this->assertTrue($client->updateMerchant($data));
    }

    public function testCreateFromMap()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('create_map.json'));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/wxa/create_map_poi', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $data = [
            'name' => 'hardenzhang',
            'longitude' => '113.323753357',
            'latitude' => '23.0974903107',
            'province' => '广东省',
            'city' => '广州市',
            'district' => '海珠区',
            'address' => 'TIT',
            'category' => '类目1:类目2',
            'telephone' => '12345678901',
            'photo' => 'http://mmbiz.qpic.cn/mmbiz_png/tW66AWE2K6ECFPcyAcIZTG8RlcR0sAqBibOm8gao5xOoLfIic9ZJ6MADAktGPxZI7MZLcadZUT36b14NJ2cHRHA/0?wx_fmt=png',
            'license' => 'http://mmbiz.qpic.cn/mmbiz_png/tW66AWE2K6ECFPcyAcIZTG8RlcR0sAqBibOm8gao5xOoLfIic9ZJ6MADAktGPxZI7MZLcadZUT36b14NJ2cHRHA/0?wx_fmt=png',
            'introduct' => 'test',
            'districtid' => '440105',
        ];

        $client = new Client($app);
        $this->assertIsArray($client->createFromMap($data));
        $this->assertEquals(json_decode($this->readMockResponseJson('create_map.json'), true), $client->createFromMap($data));
    }

    public function testCreate()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('create.json'));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/wxa/add_store', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $data = [
            'poi_id' => '',
            'map_poi_id' => '2880741500279549033',
            'pic_list' => '{"list":["http://mmbiz.qpic.cn/mmbiz_jpg/tW66AWvE2K4EJxIYOVpiaGOkfg0iayibiaP2xHOChvbmKQD5uh8ymibbEKlTTPmjTdQ8ia43sULLeG1pT2psOfPic4kTw/0?wx_fmt=jpeg"]}',
            'contract_phone' => '1111222222',
            'credential' => '22883878-0',
            'qualification_list' => 'RTZgKZ386yFn5kQSWLTxe4bqxwgzGBjs3OE02cg9CVQk1wRVE3c8fjUFX7jvpi-P',
        ];

        $client = new Client($app);
        $this->assertIsArray($client->create($data));
        $this->assertEquals(json_decode($this->readMockResponseJson('create.json'), true), $client->create($data));
    }

    public function testUpdate()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('update.json'));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/wxa/add_store', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $data = [
            'map_poi_id' => '5938314494307741153',
            'poi_id' => '472671857',
            'hour' => '10:00-21:00',
            'contract_phone' => '123456',
            'pic_list' => '{"list":["http://mmbiz.qpic.cn/mmbiz_jpg/tW66AWvE2K4EJxIYOVpiaGOkfg0iayibiaP2xHOChvbmKQD5uh8ymibbEKlTTPmjTdQ8ia43sULLeG1pT2psOfPic4kTw/0?wx_fmt=jpeg"]}',
        ];

        $client = new Client($app);
        $this->assertIsArray($client->update(472671857, $data));
        $this->assertEquals(json_decode($this->readMockResponseJson('update.json'), true), $client->update(472671857, $data));
    }

    public function testGet()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('get.json'));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/wxa/get_store_info', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);
        $this->assertIsArray($client->get(472671857));
        $this->assertEquals(json_decode($this->readMockResponseJson('get.json'), true), $client->get(472671857));
    }

    public function testList()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('list.json'));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/wxa/get_store_list', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);
        $this->assertIsArray($client->list(0, 10));
        $this->assertEquals(json_decode($this->readMockResponseJson('list.json'), true), $client->list(0, 10));
    }

    public function testDelete()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('delete.json'));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/wxa/del_store', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);
        $this->assertTrue($client->delete(472671857));
    }

    private function readMockResponseJson(string $file): string
    {
        return file_get_contents(dirname(__FILE__) . '/mock_data/' . $file);
    }
}