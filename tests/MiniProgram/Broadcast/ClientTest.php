<?php
/**
 * Created by PhpStorm.
 * User: XueSi
 * Email: <1592328848@qq.com>
 * Date: 2021/5/5
 * Time: 15:29
 */

namespace EasySwoole\WeChat\Tests\MiniProgram\Broadcast;


use EasySwoole\WeChat\Kernel\ServiceContainer;
use EasySwoole\WeChat\Tests\Mock\Message\Status;
use EasySwoole\WeChat\Tests\TestCase;
use Psr\Http\Message\ServerRequestInterface;
use EasySwoole\WeChat\MiniProgram\Broadcast\Client;

class ClientTest extends TestCase
{
    public function testCreate()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('create.json'));

        $app = $this->mockAccessToken(new ServiceContainer([
            'appId' => 'mock_appid',
            'appSecret' => 'mock_secret'
        ]));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/wxaapi/broadcast/goods/add', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        $goodsInfo = [
            'coverImgUrl' => 'ZuYVNKk9sMP1X4m7FXdcDCKra251KDZTjS502UTV7gwalgLZXcrOhG6oNYX6c7AR',
            'name' => 'TIT茶杯',
            'priceType' => 1,
            'price' => 99.5,
            // "price2": 150.5, priceType为2或3时必填
            'url' => 'pages/index/index',
        ];

        $this->assertIsArray($client->create($goodsInfo));

        $this->assertSame(json_decode($this->readMockResponseJson('create.json'), true), $client->create($goodsInfo));
    }

    public function testResetAudit()
    {
        $response = $this->buildResponse(Status::CODE_OK, '{"errcode":0}');

        $app = $this->mockAccessToken(new ServiceContainer([
            'appId' => 'mock_appid',
            'appSecret' => 'mock_secret'
        ]));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/wxaapi/broadcast/goods/resetaudit', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        $this->assertTrue($client->resetAudit(525022184, 9));
    }

    public function testResubmitAudit()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('resubmitAudit.json'));

        $app = $this->mockAccessToken(new ServiceContainer([
            'appId' => 'mock_appid',
            'appSecret' => 'mock_secret'
        ]));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/wxaapi/broadcast/goods/audit', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        $this->assertIsArray($client->resubmitAudit(9));

        $this->assertSame(json_decode($this->readMockResponseJson('resubmitAudit.json'), true), $client->resubmitAudit(9));
    }

    public function testDelete()
    {
        $response = $this->buildResponse(Status::CODE_OK, '{"errcode":0}');

        $app = $this->mockAccessToken(new ServiceContainer([
            'appId' => 'mock_appid',
            'appSecret' => 'mock_secret'
        ]));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/wxaapi/broadcast/goods/delete', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        $this->assertTrue($client->delete(9));
    }

    public function testUpdate()
    {
        $response = $this->buildResponse(Status::CODE_OK, '{"errcode":0}');

        $app = $this->mockAccessToken(new ServiceContainer([
            'appId' => 'mock_appid',
            'appSecret' => 'mock_secret'
        ]));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/wxaapi/broadcast/goods/update', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        $goodsInfo = [
            // 需要更新哪个字段就传入哪个字段，goodsId 必传
            'coverImgUrl' => 'ZuYVNKk9sMP1X4m7FXdcDCKra251KDZTjS502UTV7gwalgLZXcrOhG6oNYX6c7AR',
            'name' => 'TIT茶杯',
            'priceType' => 1,
            'price' => 99.5,
            // "price2": 150.5, priceType为2或3时必填
            'url' => 'pages/index/index',
            'goodsId' => 9,
        ];

        $this->assertTrue($client->update($goodsInfo));
    }

    public function testGetGoodsWarehouse()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('resubmitAudit.json'));

        $app = $this->mockAccessToken(new ServiceContainer([
            'appId' => 'mock_appid',
            'appSecret' => 'mock_secret'
        ]));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/wxa/business/getgoodswarehouse', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        $this->assertIsArray($client->getGoodsWarehouse([1]));

        $this->assertSame(json_decode($this->readMockResponseJson('resubmitAudit.json'), true), $client->getGoodsWarehouse([1]));
    }

    public function testGetApproved()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('getApproved.json'));

        $app = $this->mockAccessToken(new ServiceContainer([
            'appId' => 'mock_appid',
            'appSecret' => 'mock_secret'
        ]));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('GET', $request->getMethod());
            $this->assertEquals('/wxaapi/broadcast/goods/getapproved', $request->getUri()->getPath());
            $this->assertEquals('offset=1&limit=30&status=1&access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        $params = [
            'offset' => 1,
            'limit' => 30,
            'status' => 1
        ];

        $this->assertIsArray($client->getApproved($params));

        $this->assertSame(json_decode($this->readMockResponseJson('getApproved.json'), true), $client->getApproved($params));
    }

    /**************** 直播间接口 ******************/
    public function testCreateLiveRoom()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('createLiveRoom.json'));

        $app = $this->mockAccessToken(new ServiceContainer([
            'appId' => 'mock_appid',
            'appSecret' => 'mock_secret'
        ]));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/wxaapi/broadcast/room/create', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        $params = [
            'name' => "测试直播房间1", // 房间名字
            'coverImg' => "", // 通过 uploadfile 上传，填写 mediaID
            'startTime' => 1588237130, // 开始时间
            'endTime' => 1588237130, // 结束时间
            'anchorName' => "zefzhang1", // 主播昵称
            'anchorWechat' => "WxgQiao_04",  //主播微信号
            'subAnchorWechat' => "WxgQiao_03",  // 主播副号微信号
            'createrWechat' => "test_creater", // 创建者微信号
            'shareImg' => "w7zsntcr0rE-RBfBAaF553DqBk-J02UtWsP8VqrUh3tKu3jO_JwEO8n1cWTJ5TN",  //通过 uploadfile 上传，填写 mediaID
            'feedsImg' => "hw7zsntcr0rE-RBfBAaF553DqBk-J02UtWsP8VqrUh3tKu3jO_JwEO8n1cWTJ5TN",   //通过 uploadfile 上传，填写 mediaID
            'isFeedsPublic' => 1, // 是否开启官方收录，1 开启，0 关闭
            'type' => 1, // 直播类型，1：推流，0：手机直播
            'closeLike' => 0, // 是否关闭点赞 1：关闭
            'closeGoods' => 0, // 是否关闭商品货架，1：关闭
            'closeComment' => 0, // 是否开启评论，1：关闭
            'closeReplay' => 1, // 是否关闭回放 1 关闭
            'closeShare' => 0,   //  是否关闭分享 1 关闭
            'closeKf' => 0, // 是否关闭客服，1 关闭
        ];

        $this->assertIsArray($client->createLiveRoom($params));

        $this->assertSame(json_decode($this->readMockResponseJson('createLiveRoom.json'), true), $client->createLiveRoom($params));
    }

    public function testGetRooms()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('getRooms.json'));

        $app = $this->mockAccessToken(new ServiceContainer([
            'appId' => 'mock_appid',
            'appSecret' => 'mock_secret'
        ]));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/wxa/business/getliveinfo', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        $this->assertIsArray($client->getRooms(0, 10));

        $this->assertSame(json_decode($this->readMockResponseJson('getRooms.json'), true), $client->getRooms(0, 10));
    }

    public function testGetPlaybacks()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('getPlaybacks.json'));

        $app = $this->mockAccessToken(new ServiceContainer([
            'appId' => 'mock_appid',
            'appSecret' => 'mock_secret'
        ]));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/wxa/business/getliveinfo', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        $this->assertIsArray($client->getPlaybacks(354));

        $this->assertSame(json_decode($this->readMockResponseJson('getPlaybacks.json'), true), $client->getPlaybacks(354));
    }

    public function testAddGoods()
    {
        $response = $this->buildResponse(Status::CODE_OK, '{"errcode":0}');

        $app = $this->mockAccessToken(new ServiceContainer([
            'appId' => 'mock_appid',
            'appSecret' => 'mock_secret'
        ]));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/wxaapi/broadcast/room/addgoods', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        $params = [
            'ids' => [1150, 1111], // 数组列表，可传入多个，里面填写 商品 ID
            'roomId' => 2554
        ];

        $this->assertTrue($client->addGoods($params));
    }

    public function testDeleteLiveRoom()
    {
        $response = $this->buildResponse(Status::CODE_OK, '{"errcode":0}');

        $app = $this->mockAccessToken(new ServiceContainer([
            'appId' => 'mock_appid',
            'appSecret' => 'mock_secret'
        ]));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/wxaapi/broadcast/room/deleteroom', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        $params = [
            'id' => 6491
        ];

        $this->assertTrue($client->deleteLiveRoom($params));
    }

    public function testUpdateLiveRoom()
    {
        $response = $this->buildResponse(Status::CODE_OK, '{"errcode":0}');

        $app = $this->mockAccessToken(new ServiceContainer([
            'appId' => 'mock_appid',
            'appSecret' => 'mock_secret'
        ]));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/wxaapi/broadcast/room/editroom', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        $params = [
            'id' => 811,
            'name' => '测试更新副号1',
            'coverImg' => 'hw7zsntcr0rE-RBfBAaF553DqBk-J02UtWsP8VqrUh3tKu3jO_JwEO8n1cWTJ5TN',
            'startTime' => 1607443200,
            'endTime' => 1607450400,
            'anchorName' => '主播昵称11',
            'anchorWechat' => 'lintest1',
            'shareImg' => 'hw7zsntcr0rE-RBfBAaF553DqBk-J02UtWsP8VqrUh3tKu3jO_JwEO8n1cWTJ5TN',
            'closeLike' => 0,
            'closeGoods' => 0,
            'closeComment' => 0,
            'isFeedsPublic' => 0,
            'closeReplay' => 0,
            'closeShare' => 0,
            'closeKf' => 0,
            'feedsImg' => 'hw7zsntcr0rE-RBfBAaF553DqBk-J02UtWsP8VqrUh3tKu3jO_JwEO8n1cWTJ5TN'
        ];

        $this->assertTrue($client->updateLiveRoom($params));
    }

    public function testGetPushUrl()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('getPushUrl.json'));

        $app = $this->mockAccessToken(new ServiceContainer([
            'appId' => 'mock_appid',
            'appSecret' => 'mock_secret'
        ]));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('GET', $request->getMethod());
            $this->assertEquals('/wxaapi/broadcast/room/getpushurl', $request->getUri()->getPath());
            $this->assertEquals('roomId=6209&access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        $params = [
            'roomId' => 6209
        ];

        $this->assertIsArray($client->getPushUrl($params));

        $this->assertSame(json_decode($this->readMockResponseJson('getPushUrl.json'), true), $client->getPushUrl($params));
    }

    public function testGetShareQrcode()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('getShareQrcode.json'));

        $app = $this->mockAccessToken(new ServiceContainer([
            'appId' => 'mock_appid',
            'appSecret' => 'mock_secret'
        ]));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('GET', $request->getMethod());
            $this->assertEquals('/wxaapi/broadcast/room/getsharedcode', $request->getUri()->getPath());
            $this->assertEquals('roomId=6209&params=%257B%2522foo%2522%253A%2522bar%2522%257D&access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        $params = [
            'roomId' => 6209,
            'params' => '%7B%22foo%22%3A%22bar%22%7D'
        ];

        $this->assertIsArray($client->getShareQrcode($params));

        $this->assertSame(json_decode($this->readMockResponseJson('getShareQrcode.json'), true), $client->getShareQrcode($params));
    }

    public function testAddAssistant()
    {
        $response = $this->buildResponse(Status::CODE_OK, '{"errcode":0}');

        $app = $this->mockAccessToken(new ServiceContainer([
            'appId' => 'mock_appid',
            'appSecret' => 'mock_secret'
        ]));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/wxaapi/broadcast/room/addassistant', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        $params = [
            'roomId' => 6474,
            'users' => [
                [
                    'username' => 'testwechat',
                    'nickname' => 'testnick'
                ]
            ]
        ];

        $this->assertTrue($client->addAssistant($params));
    }

    public function testUpdateAssistant()
    {
        $response = $this->buildResponse(Status::CODE_OK, '{"errcode":0}');

        $app = $this->mockAccessToken(new ServiceContainer([
            'appId' => 'mock_appid',
            'appSecret' => 'mock_secret'
        ]));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/wxaapi/broadcast/room/modifyassistant', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        $params = [
            'roomId' => 6474,
            'username' => 'testwechat',
            'nickname' => 'testnick'
        ];

        $this->assertTrue($client->updateAssistant($params));
    }

    public function testDeleteAssistant()
    {
        $response = $this->buildResponse(Status::CODE_OK, '{"errcode":0}');

        $app = $this->mockAccessToken(new ServiceContainer([
            'appId' => 'mock_appid',
            'appSecret' => 'mock_secret'
        ]));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/wxaapi/broadcast/room/removeassistant', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        $params = [
            'roomId' => 6623,
            'username' => 'testwechat'
        ];

        $this->assertTrue($client->deleteAssistant($params));
    }

    public function testGetAssistantList()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('getAssistantList.json'));

        $app = $this->mockAccessToken(new ServiceContainer([
            'appId' => 'mock_appid',
            'appSecret' => 'mock_secret'
        ]));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('GET', $request->getMethod());
            $this->assertEquals('/wxaapi/broadcast/room/getassistantlist', $request->getUri()->getPath());
            $this->assertEquals('roomId=6491&access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        $params = [
            'roomId' => 6491,
        ];

        $this->assertIsArray($client->getAssistantList($params));

        $this->assertSame(json_decode($this->readMockResponseJson('getAssistantList.json'), true), $client->getAssistantList($params));
    }

    public function testAddSubAnchor()
    {
        $response = $this->buildResponse(Status::CODE_OK, '{"errcode":0}');

        $app = $this->mockAccessToken(new ServiceContainer([
            'appId' => 'mock_appid',
            'appSecret' => 'mock_secret'
        ]));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/wxaapi/broadcast/room/addsubanchor', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        $params = [
            'roomId' => 6827,
            'username' => 'lintest2'
        ];

        $this->assertTrue($client->addSubAnchor($params));
    }

    public function testUpdateSubAnchor()
    {
        $response = $this->buildResponse(Status::CODE_OK, '{"errcode":0}');

        $app = $this->mockAccessToken(new ServiceContainer([
            'appId' => 'mock_appid',
            'appSecret' => 'mock_secret'
        ]));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/wxaapi/broadcast/room/modifysubanchor', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        $params = [
            'roomId' => 6827,
            'username' => 'wechattest'
        ];

        $this->assertTrue($client->updateSubAnchor($params));
    }

    public function testDeleteSubAnchor()
    {
        $response = $this->buildResponse(Status::CODE_OK, '{"errcode":0}');

        $app = $this->mockAccessToken(new ServiceContainer([
            'appId' => 'mock_appid',
            'appSecret' => 'mock_secret'
        ]));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/wxaapi/broadcast/room/deletesubanchor', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        $params = [
            'roomId' => 6491,
        ];

        $this->assertTrue($client->deleteSubAnchor($params));
    }

    public function testGetSubAnchor()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('getSubAnchor.json'));

        $app = $this->mockAccessToken(new ServiceContainer([
            'appId' => 'mock_appid',
            'appSecret' => 'mock_secret'
        ]));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('GET', $request->getMethod());
            $this->assertEquals('/wxaapi/broadcast/room/getsubanchor', $request->getUri()->getPath());
            $this->assertEquals('roomId=6491&access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        $params = [
            'roomId' => 6491,
        ];

        $this->assertIsArray($client->getSubAnchor($params));

        $this->assertSame(json_decode($this->readMockResponseJson('getSubAnchor.json'), true), $client->getSubAnchor($params));
    }

    public function testUpdateFeedPublic()
    {
        $response = $this->buildResponse(Status::CODE_OK, '{"errcode":0}');

        $app = $this->mockAccessToken(new ServiceContainer([
            'appId' => 'mock_appid',
            'appSecret' => 'mock_secret'
        ]));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/wxaapi/broadcast/room/updatefeedpublic', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        $params = [
            'roomId' => 6474,
            'isFeedsPublic' => 0
        ];

        $this->assertTrue($client->updateFeedPublic($params));
    }

    public function testUpdateReplay()
    {
        $response = $this->buildResponse(Status::CODE_OK, '{"errcode":0}');

        $app = $this->mockAccessToken(new ServiceContainer([
            'appId' => 'mock_appid',
            'appSecret' => 'mock_secret'
        ]));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/wxaapi/broadcast/room/updatereplay', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        $params = [
            'roomId' => 6474,
            'closeReplay' => 0
        ];

        $this->assertTrue($client->updateReplay($params));
    }

    public function testUpdateKf()
    {
        $response = $this->buildResponse(Status::CODE_OK, '{"errcode":0}');

        $app = $this->mockAccessToken(new ServiceContainer([
            'appId' => 'mock_appid',
            'appSecret' => 'mock_secret'
        ]));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/wxaapi/broadcast/room/updatekf', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        $params = [
            'roomId' => 6491,
            'closeKf' => 1
        ];

        $this->assertTrue($client->updateKf($params));
    }

    public function testUpdateComment()
    {
        $response = $this->buildResponse(Status::CODE_OK, '{"errcode":0}');

        $app = $this->mockAccessToken(new ServiceContainer([
            'appId' => 'mock_appid',
            'appSecret' => 'mock_secret'
        ]));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/wxaapi/broadcast/room/updatecomment', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        $params = [
            'roomId' => 6491,
            'banComment' => 1
        ];

        $this->assertTrue($client->updateComment($params));
    }

    public function testUpdateGoodsInRoom()
    {
        $response = $this->buildResponse(Status::CODE_OK, '{"errcode":0}');

        $app = $this->mockAccessToken(new ServiceContainer([
            'appId' => 'mock_appid',
            'appSecret' => 'mock_secret'
        ]));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/wxaapi/broadcast/goods/onsale', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        $params = [
            'roomId' => 6474,
            'goodsId' => 1,
            'onSale' => 0,
        ];

        $this->assertTrue($client->updateGoodsInRoom($params));
    }

    public function testDeleteGoodsInRoom()
    {
        $response = $this->buildResponse(Status::CODE_OK, '{"errcode":0}');

        $app = $this->mockAccessToken(new ServiceContainer([
            'appId' => 'mock_appid',
            'appSecret' => 'mock_secret'
        ]));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/wxaapi/broadcast/goods/deleteInRoom', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        $params = [
            'roomId' => 6474,
            'goodsId' => 1
        ];

        $this->assertTrue($client->deleteGoodsInRoom($params));
    }

    public function testPushGoods()
    {
        $response = $this->buildResponse(Status::CODE_OK, '{"errcode":0}');

        $app = $this->mockAccessToken(new ServiceContainer([
            'appId' => 'mock_appid',
            'appSecret' => 'mock_secret'
        ]));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/wxaapi/broadcast/goods/push', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        $params = [
            'roomId' => 6474,
            'goodsId' => 1
        ];

        $this->assertTrue($client->pushGoods($params));
    }

    public function testSortGoods()
    {
        $response = $this->buildResponse(Status::CODE_OK, '{"errcode":0}');

        $app = $this->mockAccessToken(new ServiceContainer([
            'appId' => 'mock_appid',
            'appSecret' => 'mock_secret'
        ]));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/wxaapi/broadcast/goods/sort', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        $params = [
            'roomId' => 6474,
            'goods' => [
                ['goodsId' => 123],
                ['goodsId' => 234],
            ]
        ];

        $this->assertTrue($client->sortGoods($params));
    }

    public function testDownloadGoodsExplanationVideo()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('downloadGoodsExplanationVideo.json'));

        $app = $this->mockAccessToken(new ServiceContainer([
            'appId' => 'mock_appid',
            'appSecret' => 'mock_secret'
        ]));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/wxaapi/broadcast/goods/getVideo', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        $params = [
            'roomId' => 6474,
            'goodsId' => 1,
        ];

        $this->assertIsArray($client->downloadGoodsExplanationVideo($params));

        $this->assertSame(json_decode($this->readMockResponseJson('downloadGoodsExplanationVideo.json'), true), $client->downloadGoodsExplanationVideo($params));
    }

    /************* 成员管理接口 ***********************/
    public function testAddRole()
    {
        $response = $this->buildResponse(Status::CODE_OK, '{"errcode":0}');

        $app = $this->mockAccessToken(new ServiceContainer([
            'appId' => 'mock_appid',
            'appSecret' => 'mock_secret'
        ]));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/wxaapi/broadcast/role/addrole', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        $params = [
            'username' => 'test_1', // 微信号
            'role' => 1, // 取值[1-管理员，2-主播，3-运营者]，设置超级管理员将无效
        ];

        $this->assertTrue($client->addRole($params));
    }

    public function testDeleteRole()
    {
        $response = $this->buildResponse(Status::CODE_OK, '{"errcode":0}');

        $app = $this->mockAccessToken(new ServiceContainer([
            'appId' => 'mock_appid',
            'appSecret' => 'mock_secret'
        ]));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/wxaapi/broadcast/role/deleterole', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        $params = [
            'username' => 'test_1', // 微信号
            'role' => 1, // 取值[1-管理员，2-主播，3-运营者]，设置超级管理员将无效
        ];

        $this->assertTrue($client->deleteRole($params));
    }

    public function testGetRoleList()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('getRoleList.json'));

        $app = $this->mockAccessToken(new ServiceContainer([
            'appId' => 'mock_appid',
            'appSecret' => 'mock_secret'
        ]));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('GET', $request->getMethod());
            $this->assertEquals('/wxaapi/broadcast/role/getrolelist', $request->getUri()->getPath());
            $this->assertEquals('role=1&offset=0&limit=10&keyword=test_1&access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        $params = [
            'role' => 1, // 取值 [-1-所有成员， 0-超级管理员，1-管理员，2-主播，3-运营者]
            'offset' => 0, // 起始偏移量
            'limit' => 10, // 查询个数，最大30，默认10
            'keyword' => 'test_1' // 搜索的微信号，不传返回全部
        ];

        $this->assertIsArray($client->getRoleList($params));

        $this->assertSame(json_decode($this->readMockResponseJson('getRoleList.json'), true), $client->getRoleList($params));
    }

    /*********** 长期订阅相关接口 ************/
    public function testGetFollowers()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('getFollowers.json'));

        $app = $this->mockAccessToken(new ServiceContainer([
            'appId' => 'mock_appid',
            'appSecret' => 'mock_secret'
        ]));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/wxa/business/get_wxa_followers', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        $params = [
            'limit' => 200,
            'page_break' => 0
        ];

        $this->assertIsArray($client->getFollowers($params));

        $this->assertSame(json_decode($this->readMockResponseJson('getFollowers.json'), true), $client->getFollowers($params));
    }

    public function testPushMessage()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('pushMessage.json'));

        $app = $this->mockAccessToken(new ServiceContainer([
            'appId' => 'mock_appid',
            'appSecret' => 'mock_secret'
        ]));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/wxa/business/push_message', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        $params = [
            'room_id' => 1,
            'user_openid' => ['openid1', 'openid2']
        ];

        $this->assertIsArray($client->pushMessage($params));

        $this->assertSame(json_decode($this->readMockResponseJson('pushMessage.json'), true), $client->pushMessage($params));
    }

    private function readMockResponseJson($filename)
    {
        return file_get_contents(__DIR__ . '/mock_data/' . $filename);
    }
}