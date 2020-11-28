<?php

namespace EasySwoole\WeChat\Tests\OfficialAccount\POI;


use EasySwoole\WeChat\Kernel\ServiceContainer;
use EasySwoole\WeChat\OfficialAccount\POI\Client;
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
            $this->assertEquals('/cgi-bin/poi/getwxcategory', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);
        $this->assertIsArray($client->categories());
        $this->assertEquals(json_decode($this->readMockResponseJson('categories.json'), true), $client->categories());
    }


    public function testGet()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('get.json'));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/poi/getpoi', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);
        $this->assertIsArray($client->get(271262077));
        $this->assertEquals(json_decode($this->readMockResponseJson('get.json'), true), $client->get(271262077));
    }


    public function testList()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('list.json'));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/poi/getpoilist', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);
        $this->assertIsArray($client->list(0, 10));
        $this->assertEquals(json_decode($this->readMockResponseJson('list.json'), true), $client->list(0, 10));
    }

    public function testCreate()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('create.json'));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/poi/addpoi', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $data = [
            'sid' => '33788392',
            'business_name' => '15个汉字或30个英文字符内',
            'branch_name' => '不超过10个字，不能含有括号和特殊字符',
            'province' => '不超过10个字',
            'city' => '不超过30个字',
            'district' => '不超过10个字',
            'address' => '门店所在的详细街道地址（不要填写省市信息）：不超过80个字',
            'telephone' => '不超53个字符（不可以出现文字）',
            'categories' => [
                '美食,小吃快餐',
            ],
            'offset_type' => 1,
            'longitude' => 115.32375,
            'latitude' => 25.097486,
            'photo_list' => [
                [
                    'photo_url' => 'https:// 不超过20张.com',
                ],
                [
                    'photo_url' => 'https://XXX.com',
                ],
            ],
            'recommend' => '不超过200字。麦辣鸡腿堡套餐，麦乐鸡，全家桶',
            'special' => '不超过200字。免费wifi，外卖服务',
            'introduction' => '不超过300字。麦当劳是全球大型跨国连锁餐厅，1940 年创立于美国，在世界上大约拥有3 万间分店。主要售卖汉堡包，以及薯条、炸鸡、汽水、冰品、沙拉、 水果等快餐食品',
            'open_time' => '8:00-20:00',
            'avg_price' => 35
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
            $this->assertEquals('/cgi-bin/poi/updatepoi', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $data = [
            'poi_id ' => '271864249',
            'sid' => 'A00001',
            'telephone ' => '020-12345678',
            'photo_list' => [
                [
                    'photo_url' => 'https:// XXX.com',
                ],
                [
                    'photo_url' => 'https://XXX.com',
                ],
            ],
            'recommend' => '麦辣鸡腿堡套餐，麦乐鸡，全家桶',
            'special' => '免费wifi，外卖服务',
            'introduction' => '麦当劳是全球大型跨国连锁餐厅，1940 年创立于美国，在世界上大约拥有3 万间分店。主要售卖汉堡包，以及薯条、炸鸡、汽水、冰品、沙拉、水果等快餐食品',
            'open_time' => '8:00-20:00',
            'avg_price' => 35,
        ];

        $client = new Client($app);
        $this->assertTrue($client->update(271864249, $data));
    }


    public function testDelete()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('delete.json'));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/poi/delpoi', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);
        $this->assertTrue($client->delete(271864249));
    }

    protected function readMockResponseJson(string $file): string
    {
        return file_get_contents(dirname(__FILE__) . '/mock_data/' . $file);
    }
}