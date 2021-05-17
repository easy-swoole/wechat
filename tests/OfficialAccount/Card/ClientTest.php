<?php

namespace EasySwoole\WeChat\Tests\OfficialAccount\Card;

use EasySwoole\WeChat\Kernel\ServiceContainer;
use EasySwoole\WeChat\OfficialAccount\Card\Client;
use EasySwoole\WeChat\Tests\Mock\Message\Status;
use EasySwoole\WeChat\Tests\TestCase;
use Psr\Http\Message\ServerRequestInterface;

class ClientTest extends TestCase
{
    public function testColors()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJsonByFunction(__FUNCTION__));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('GET', $request->getMethod());
            $this->assertEquals('/card/getcolors', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);
        $this->assertIsArray($client->colors());
        $this->assertEquals(json_decode($this->readMockResponseJsonByFunction(__FUNCTION__), true), $client->colors());
    }

    public function testCategories()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJsonByFunction(__FUNCTION__));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('GET', $request->getMethod());
            $this->assertEquals('/card/getapplyprotocol', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);
        $this->assertIsArray($client->categories());
        $this->assertEquals(json_decode($this->readMockResponseJsonByFunction(__FUNCTION__), true), $client->categories());
    }

    public function testCreate()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJsonByFunction(__FUNCTION__));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/card/create', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $params = [
            'base_info' => [
                'logo_url' => 'http://mmbiz.qpic.cn/mmbiz/iaL1LJM1mF9aRKPZJkmG8xXhiaHqkKSVMMWeN3hLut7X7hicFNjakmxibMLGWpXrEXB33367o7zHN0CwngnQY7zb7g/0',
                'brand_name' => '海底捞',
                'code_type' => 'CODE_TYPE_TEXT',
                'title' => '132元双人火锅套餐',
                'sub_title' => '周末狂欢必备',
                'color' => 'Color010',
                'notice' => '使用时向服务员出示此券',
                'service_phone' => '020-88888888',
                'description' => '不可与其他优惠同享
如需团购券发票，请在消费时向商户提出
店内均可使用，仅限堂食',
                'date_info' => [
                    'type' => 1,
                    'begin_timestamp' => 1397577600,
                    'end_timestamp' => 1422724261,
                ],
                'sku' => [
                    'quantity' => 50000000,
                ],
                'get_limit' => 3,
                'use_custom_code' => false,
                'bind_openid' => false,
                'can_share' => true,
                'can_give_friend' => true,
                'location_id_list' => [
                    123,
                    12321,
                    345345,
                ],
                'custom_url_name' => '立即使用',
                'custom_url' => 'http://www.qq.com',
                'custom_url_sub_title' => '6个汉字tips',
                'promotion_url_name' => '更多优惠',
                'promotion_url' => 'http://www.qq.com',
                'source' => '大众点评',
            ],
            'deal_detail' => '以下锅底2选1（有菌王锅、麻辣锅、大骨锅、番茄锅、清补凉锅、酸菜鱼锅可选）：
大锅1份 12元
小锅2份 16元 ',
        ];
        $client = new Client($app);
        $this->assertIsArray($client->create('GROUPON', $params));
        $this->assertEquals(json_decode($this->readMockResponseJsonByFunction(__FUNCTION__), true), $client->create('GROUPON', $params));
    }

    public function testGet()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJsonByFunction(__FUNCTION__));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/card/get', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);
        $this->assertIsArray($client->get('pFS7Fjg8kV1IdDz01r4SQwMkuCKc'));
        $this->assertEquals(json_decode($this->readMockResponseJsonByFunction(__FUNCTION__), true), $client->get('pFS7Fjg8kV1IdDz01r4SQwMkuCKc'));
    }

    public function testList()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJsonByFunction(__FUNCTION__));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/card/batchget', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);
        $this->assertIsArray($client->list());
        $this->assertEquals(json_decode($this->readMockResponseJsonByFunction(__FUNCTION__), true), $client->list());
    }

    public function testUpdate()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJsonByFunction(__FUNCTION__));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/card/update', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $params = [
            'base_info' => [
                'logo_url' => 'http://www.supadmin.cn/uploads/allimg/120216/1_120216214725_1.jpg',
                'color' => 'Color010',
                'notice' => '使用时向服务员出示此券',
                'service_phone' => '020-88888888',
                'description' => '不可与其他优惠同享
如需团购券发票，请在消费时向商户提出
店内均可使用，                   仅限堂食
餐前不可打包，餐后未吃完，可打包
本团购券不限人数，建议2人使用，                   超过建议人数须另收酱料费5元/位
本单谢绝自带酒水饮料',
                'location_id_list' => [
                    123,
                    12321,
                    345345,
                ],
            ],
            'bonus_cleared' => 'aaaaaaaaaaaaaa',
            'bonus_rules' => 'aaaaaaaaaaaaaa',
            'prerogative' => '',
        ];
        $client = new Client($app);
        $this->assertIsArray($client->update('ph_gmt7cUVrlRk8swPwx7aDyF-pg', 'member_card', $params));
        $this->assertEquals(json_decode($this->readMockResponseJsonByFunction(__FUNCTION__), true), $client->update('ph_gmt7cUVrlRk8swPwx7aDyF-pg', 'member_card', $params));
    }

    public function testDelete()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJsonByFunction(__FUNCTION__));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/card/delete', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);
        $this->assertTrue($client->delete('pFS7Fjg8kV1IdDz01r4SQwMkuCKc'));
    }

    public function testCreateQrCode()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJsonByFunction(__FUNCTION__));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/card/qrcode/create', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $params = [
            'action_name' => 'QR_CARD',
            'expire_seconds' => 1800,
            'action_info' => [
                'card' => [
                    'card_id' => 'pFS7Fjg8kV1IdDz01r4SQwMkuCKc',
                    'code' => '198374613512',
                    'openid' => 'oFS7Fjl0WsZ9AMZqrI80nbIq8xrA',
                    'is_unique_code' => false,
                    'outer_str' => '12b',
                ],
            ],
        ];
        $client = new Client($app);
        $this->assertIsArray($client->createQrCode($params));
        $this->assertEquals(json_decode($this->readMockResponseJsonByFunction(__FUNCTION__), true), $client->createQrCode($params));
    }

    public function testGetQrCode()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJsonByFunction(__FUNCTION__));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('GET', $request->getMethod());
            $this->assertEquals('/cgi-bin/showqrcode', $request->getUri()->getPath());
            $this->assertEquals('ticket=gQH47joAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL2taZ2Z3TVRtNzJXV1Brb3ZhYmJJAAIEZ23sUwMEmm3sUw%3D%3D&access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $params = 'gQH47joAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL2taZ2Z3TVRtNzJXV1Brb3ZhYmJJAAIEZ23sUwMEmm3sUw==';
        $client = new Client($app);
        $this->assertIsArray($client->getQrCode($params));
    }

    public function testGetQrCodeUrl()
    {
        $body = "https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=gQH47joAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL2taZ2Z3TVRtNzJXV1Brb3ZhYmJJAAIEZ23sUwMEmm3sUw==";
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $params = 'gQH47joAAAAAAAAAASxodHRwOi8vd2VpeGluLnFxLmNvbS9xL2taZ2Z3TVRtNzJXV1Brb3ZhYmJJAAIEZ23sUwMEmm3sUw==';
        $client = new Client($app);
        $this->assertIsString($client->getQrCodeUrl($params));
        $this->assertEquals($body, $client->getQrCodeUrl($params));
    }


    public function testCreateLandingPage()
    {

        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJsonByFunction(__FUNCTION__));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/card/landingpage/create', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $banner = "http://mmbiz.qpic.cn/mmbiz/iaL1LJM1mF9aRKPZJkmG8xXhiaHqkKSVMMWeN3hLut7X7hicFN";
        $pageTitle = "惠城优惠大派送";
        $canShare = true;
        $scene = "SCENE_NEAR_BY";
        $cardList = [
            [
                'card_id' => 'pXch-jnOlGtbuWwIO2NDftZeynRE',
                'thumb_url' => 'www.qq.com/a.jpg',
            ],
            [
                'card_id' => 'pXch-jnAN-ZBoRbiwgqBZ1RV60fI',
                'thumb_url' => 'www.qq.com/b.jpg',
            ],
        ];

        $client = new Client($app);
        $this->assertIsArray($client->createLandingPage($banner, $pageTitle, $canShare, $scene, $cardList));
        $this->assertEquals(json_decode($this->readMockResponseJsonByFunction(__FUNCTION__), true), $client->createLandingPage($banner, $pageTitle, $canShare, $scene, $cardList));
    }


    public function testGetHtml()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJsonByFunction(__FUNCTION__));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/card/mpnews/gethtml', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);
        $this->assertIsArray($client->getHtml('p1Pj9jr90_SQRaVqYI239Ka1erkI'));
        $this->assertEquals(json_decode($this->readMockResponseJsonByFunction(__FUNCTION__), true), $client->getHtml('p1Pj9jr90_SQRaVqYI239Ka1erkI'));
    }


    public function testSetTestWhitelist()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJsonByFunction(__FUNCTION__));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/card/testwhitelist/set', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);
        $this->assertTrue($client->setTestWhitelist(["o1Pj9jmZvwSyyyyyyBa4aULW2mA", "o1Pj9jmZvxxxxxxxxxULW2mA"]));
    }

    public function testSetTestWhitelistByName()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJsonByFunction(__FUNCTION__));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/card/testwhitelist/set', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);
        $this->assertTrue($client->setTestWhitelistByName(['foo', 'bar']));
    }

    public function testGetUserCards()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJsonByFunction(__FUNCTION__));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/card/user/getcardlist', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);
        $this->assertIsArray($client->getUserCards('12321321'));
        $this->assertEquals(json_decode($this->readMockResponseJsonByFunction(__FUNCTION__), true), $client->getUserCards('12321321'));
    }


    public function testSetPayCell()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJsonByFunction(__FUNCTION__));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/card/paycell/set', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);
        $this->assertTrue($client->setPayCell('ph_gmt7cUVrlRk8swPwx7aDyF-pg', true));
    }


    public function testSetPayConsumeCell()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJsonByFunction(__FUNCTION__));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/card/selfconsumecell/set', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);
        $this->assertTrue($client->setPayConsumeCell('ph_gmt7cUVrlRk8swPwx7aDyF-pg', true, false, false));
    }


    public function testIncreaseStock()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJsonByFunction('updateStock'));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/card/modifystock', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);
        $this->assertTrue($client->increaseStock('ph_gmt7cUVrlRk8swPwx7aDyF-pg', 1));
    }

    public function testReduceStock()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJsonByFunction('updateStock'));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/card/modifystock', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);
        $this->assertTrue($client->reduceStock('ph_gmt7cUVrlRk8swPwx7aDyF-pg', 1));
    }

    protected function readMockResponseJsonByFunction(string $func)
    {
        $fileName = strtolower(preg_replace('/(.)(?=[A-Z])/u', '$1' . '_', ltrim($func, 'test'))) . '.json';
        return file_get_contents(dirname(__FILE__) . '/mock_data/' . $fileName);
    }
}
