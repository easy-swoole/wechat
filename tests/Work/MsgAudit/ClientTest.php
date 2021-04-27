<?php
/**
 * Created by PhpStorm.
 * User: XueSi
 * Email: <1592328848@qq.com>
 * Date: 2021/4/25
 * Time: 2:25
 */

namespace EasySwoole\WeChat\Tests\Work\MsgAudit;


use EasySwoole\WeChat\Kernel\ServiceContainer;
use EasySwoole\WeChat\Tests\Mock\Message\Status;
use EasySwoole\WeChat\Tests\TestCase;
use EasySwoole\WeChat\Work\MsgAudit\Client;
use Psr\Http\Message\ServerRequestInterface;

class ClientTest extends TestCase
{
    public function testGetPermitUsers()
    {
        // mock 无type
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('getPermitUsers.json'));

        $app = $this->mockAccessToken(new ServiceContainer([
            'corpId' => 'mock_corpId',
            'corpSecret' => 'mock_corpSecret'
        ]));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/msgaudit/get_permit_user_list', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        $this->assertIsArray($client->getPermitUsers());

        $this->assertSame(json_decode($this->readMockResponseJson('getPermitUsers.json'), true), $client->getPermitUsers());

        // mock 有type
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('getPermitUsers.json'));

        $app = $this->mockAccessToken(new ServiceContainer([
            'corpId' => 'mock_corpId',
            'corpSecret' => 'mock_corpSecret'
        ]));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/msgaudit/get_permit_user_list', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        $this->assertIsArray($client->getPermitUsers(1));

        $this->assertSame(json_decode($this->readMockResponseJson('getPermitUsers.json'), true), $client->getPermitUsers(1));
    }

    public function testGetSingleAgreeStatus()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('getSingleAgreeStatus.json'));

        $app = $this->mockAccessToken(new ServiceContainer([
            'corpId' => 'mock_corpId',
            'corpSecret' => 'mock_corpSecret'
        ]));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/msgaudit/check_single_agree', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        $info = [
            [
                'userid' => 'XuJinSheng',
                'exteranalopenid' => 'wmeDKaCQAAGd9oGiQWxVsAKwV2HxNAAA',
            ],
            [
                'userid' => 'XuJinSheng',
                'exteranalopenid' => 'wmeDKaCQAAIQ_p7ACn_jpLVBJSGocAAA',
            ],
            [
                'userid' => 'XuJinSheng',
                'exteranalopenid' => 'wmeDKaCQAAPE_p7ABnxkpLBBJSGocAAA',
            ]
        ];

        $this->assertIsArray($client->getSingleAgreeStatus($info));

        $this->assertSame(json_decode($this->readMockResponseJson('getSingleAgreeStatus.json'), true), $client->getSingleAgreeStatus($info));
    }

    public function testGetRoomAgreeStatus()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('getRoomAgreeStatus.json'));

        $app = $this->mockAccessToken(new ServiceContainer([
            'corpId' => 'mock_corpId',
            'corpSecret' => 'mock_corpSecret'
        ]));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/msgaudit/check_room_agree', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        $this->assertIsArray($client->getRoomAgreeStatus('wrjc7bDwAASxc8tZvBErFE02BtPWyAAA'));

        $this->assertSame(json_decode($this->readMockResponseJson('getRoomAgreeStatus.json'), true), $client->getRoomAgreeStatus('wrjc7bDwAASxc8tZvBErFE02BtPWyAAA'));
    }

    public function testGetRoom()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('getRoom.json'));

        $app = $this->mockAccessToken(new ServiceContainer([
            'corpId' => 'mock_corpId',
            'corpSecret' => 'mock_corpSecret'
        ]));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/msgaudit/groupchat/get', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        $this->assertIsArray($client->getRoom('wrNplhCgAAIVZohLe57zKnvIV7xBKrig'));

        $this->assertSame(json_decode($this->readMockResponseJson('getRoom.json'), true), $client->getRoom('wrNplhCgAAIVZohLe57zKnvIV7xBKrig'));
    }

    protected function readMockResponseJson(string $filename): string
    {
        return file_get_contents(__DIR__ . '/mock_data/' . $filename);
    }
}