<?php
/**
 * Created by PhpStorm.
 * User: XueSi
 * Email: <1592328848@qq.com>
 * Date: 2021/4/24
 * Time: 19:57
 */

namespace EasySwoole\WeChat\Tests\Work\ExternalContact;


use EasySwoole\WeChat\Kernel\ServiceContainer;
use EasySwoole\WeChat\Tests\Mock\Message\Status;
use EasySwoole\WeChat\Tests\TestCase;
use EasySwoole\WeChat\Work\ExternalContact\Client;
use Psr\Http\Message\ServerRequestInterface;

class ClientTest extends TestCase
{
    public function testGetFollowUsers()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('getFollowUsers.json'));
        $app = $this->mockAccessToken(new ServiceContainer([
            'corpId' => 'mock_corpId',
            'corpSecret' => 'mock_corpSecret',
        ]));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('GET', $request->getMethod());
            $this->assertEquals('/cgi-bin/externalcontact/get_follow_user_list', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        $this->assertIsArray($client->getFollowUsers());

        $this->assertSame(json_decode($this->readMockResponseJson('getFollowUsers.json'), true), $client->getFollowUsers());
    }

    public function testList()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('list.json'));
        $app = $this->mockAccessToken(new ServiceContainer([
            'corpId' => 'mock_corpId',
            'corpSecret' => 'mock_corpSecret',
        ]));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('GET', $request->getMethod());
            $this->assertEquals('/cgi-bin/externalcontact/list', $request->getUri()->getPath());
            $this->assertEquals('userid=USERID&access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        $this->assertIsArray($client->list('USERID'));

        $this->assertSame(json_decode($this->readMockResponseJson('list.json'), true), $client->list('USERID'));
    }

    public function testBatchGet()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('batchGet.json'));
        $app = $this->mockAccessToken(new ServiceContainer([
            'corpId' => 'mock_corpId',
            'corpSecret' => 'mock_corpSecret',
        ]));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/externalcontact/batch/get_by_user', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        $this->assertIsArray($client->batchGet('rocky', '', 100));

        $this->assertSame(json_decode($this->readMockResponseJson('batchGet.json'), true), $client->batchGet('rocky', '', 100));
    }

    public function testGet()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('get.json'));
        $app = $this->mockAccessToken(new ServiceContainer([
            'corpId' => 'mock_corpId',
            'corpSecret' => 'mock_corpSecret',
        ]));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('GET', $request->getMethod());
            $this->assertEquals('/cgi-bin/externalcontact/get', $request->getUri()->getPath());
            $this->assertEquals('external_userid=EXTERNAL_USERID&access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        $this->assertIsArray($client->get('EXTERNAL_USERID'));

        $this->assertSame(json_decode($this->readMockResponseJson('get.json'), true), $client->get('EXTERNAL_USERID'));
    }

    public function testRemark()
    {
        $response = $this->buildResponse(Status::CODE_OK, '{"errcode":0,"errmsg":"ok"}');
        $app = $this->mockAccessToken(new ServiceContainer([
            'corpId' => 'mock_corpId',
            'corpSecret' => 'mock_corpSecret',
        ]));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/externalcontact/remark', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        $data = [
            'userid' => 'zhangsan',
            'external_userid' => 'woAJ2GCAAAd1asdasdjO4wKmE8Aabj9AAA',
            'remark' => '备注信息',
            'description' => '描述信息',
            'remark_company' => '腾讯科技',
            'remark_mobiles' =>
                [
                    '13800000001',
                    '13800000002',
                ],
            'remark_pic_mediaid' => 'MEDIAID',
        ];

        $this->assertTrue($client->remark($data));
    }

    public function testGetUnassigned()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('getUnassigned.json'));
        $app = $this->mockAccessToken(new ServiceContainer([
            'corpId' => 'mock_corpId',
            'corpSecret' => 'mock_corpSecret',
        ]));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/externalcontact/get_unassigned_list', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        $this->assertIsArray($client->getUnassigned(0, 100));

        $this->assertSame(json_decode($this->readMockResponseJson('getUnassigned.json'), true), $client->getUnassigned(0, 100));

    }

    public function testTransfer()
    {
        $response = $this->buildResponse(Status::CODE_OK, '{"errcode":0,"errmsg":"ok"}');
        $app = $this->mockAccessToken(new ServiceContainer([
            'corpId' => 'mock_corpId',
            'corpSecret' => 'mock_corpSecret',
        ]));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/externalcontact/transfer', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        $this->assertTrue($client->transfer('woAJ2GCAAAXtWyujaWJHDDGi0mACAAAA', 'zhangsan', 'lisi', '您好，您的服务已升级，后续将由我的同事李四@腾讯接替我的工作，继续为您服务。'));
    }

    public function testTransferGroupChat()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('transferGroupChat.json'));
        $app = $this->mockAccessToken(new ServiceContainer([
            'corpId' => 'mock_corpId',
            'corpSecret' => 'mock_corpSecret',
        ]));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/externalcontact/groupchat/transfer', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        $this->assertIsArray($client->transferGroupChat([
            'wrOgQhDgAAcwMTB7YmDkbeBsgT_AAAA',
            'wrOgQhDgAAMYQiS5ol9G7gK9JVQUAAAA'
        ], 'zhangsan'));

        $this->assertSame(json_decode($this->readMockResponseJson('transferGroupChat.json'), true), $client->transferGroupChat([
            'wrOgQhDgAAcwMTB7YmDkbeBsgT_AAAA',
            'wrOgQhDgAAMYQiS5ol9G7gK9JVQUAAAA'
        ], 'zhangsan'));
    }

    public function testGetTransferResult()
    {
        $response = $this->buildResponse(Status::CODE_OK, '{"error":0,"error_msg":""}');
        $app = $this->mockAccessToken(new ServiceContainer([
            'corpId' => 'mock_corpId',
            'corpSecret' => 'mock_corpSecret',
        ]));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/externalcontact/get_transfer_result', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        $this->assertIsArray($client->getTransferResult('woAJ2GCAAAXtWyujaWJHDDGi0mACH71w', 'zhangsan', 'lisi'));

        $this->assertSame([
            'error' => 0,
            'error_msg' => ''
        ], $client->getTransferResult('woAJ2GCAAAXtWyujaWJHDDGi0mACH71w', 'zhangsan', 'lisi'));
    }

    public function testGetGroupChats()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('getGroupChats.json'));
        $app = $this->mockAccessToken(new ServiceContainer([
            'corpId' => 'mock_corpId',
            'corpSecret' => 'mock_corpSecret',
        ]));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/externalcontact/groupchat/list', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        $params = [
            'status_filter' => 0,
            'owner_filter' => [
                'userid_list' => ['abel']
            ],
            'cursor' => 'r9FqSqsI8fgNbHLHE5QoCP50UIg2cFQbfma3l2QsmwI',
            'limit' => 10
        ];

        $this->assertIsArray($client->GetGroupChats($params));

        $this->assertSame(json_decode($this->readMockResponseJson('getGroupChats.json'), true), $client->GetGroupChats($params));
    }

    public function testGetGroupChat()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('getGroupChat.json'));
        $app = $this->mockAccessToken(new ServiceContainer([
            'corpId' => 'mock_corpId',
            'corpSecret' => 'mock_corpSecret',
        ]));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/externalcontact/groupchat/get', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        $this->assertIsArray($client->getGroupChat('wrOgQhDgAAMYQiS5ol9G7gK9JVAAAA'));

        $this->assertSame(json_decode($this->readMockResponseJson('getGroupChat.json'), true), $client->getGroupChat('wrOgQhDgAAMYQiS5ol9G7gK9JVAAAA'));
    }

    public function testGetCorpTags()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('getCorpTags.json'));
        $app = $this->mockAccessToken(new ServiceContainer([
            'corpId' => 'mock_corpId',
            'corpSecret' => 'mock_corpSecret',
        ]));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/externalcontact/get_corp_tag_list', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        $tagIds = [
            'tag_id' => [
                'etXXXXXXXXXX',
                'etYYYYYYYYYY'],
            'group_id' => [
                'etZZZZZZZZZZZZZ',
                'etYYYYYYYYYYYYY'
            ]
        ];

        $this->assertIsArray($client->getCorpTags($tagIds));

        $this->assertSame(json_decode($this->readMockResponseJson('getCorpTags.json'), true), $client->getCorpTags($tagIds));
    }

    public function testAddCorpTag()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('addCorpTag.json'));
        $app = $this->mockAccessToken(new ServiceContainer([
            'corpId' => 'mock_corpId',
            'corpSecret' => 'mock_corpSecret',
        ]));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/externalcontact/add_corp_tag', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        $params = [
            'group_id' => 'GROUP_ID',
            'group_name' => 'GROUP_NAME',
            'order' => 1,
            'tag' => [
                [
                    'name' => 'TAG_NAME_1',
                    'order' => 1,
                ],
                [
                    'name' => 'TAG_NAME_2',
                    'order' => 2,
                ],
            ],
            'agentid' => 1000014,
        ];

        $this->assertIsArray($client->addCorpTag($params));

        $this->assertSame(json_decode($this->readMockResponseJson('addCorpTag.json'), true), $client->addCorpTag($params));
    }

    public function testUpdateCorpTag()
    {
        $response = $this->buildResponse(Status::CODE_OK, '{"errcode":0,"errmsg":"ok"}');
        $app = $this->mockAccessToken(new ServiceContainer([
            'corpId' => 'mock_corpId',
            'corpSecret' => 'mock_corpSecret',
        ]));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/externalcontact/edit_corp_tag', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        $this->assertTrue($client->updateCorpTag('TAG_ID', 'NEW_TAG_NAME', 1));
    }

    public function testDeleteCorpTag()
    {
        $response = $this->buildResponse(Status::CODE_OK, '{"errcode":0,"errmsg":"ok"}');
        $app = $this->mockAccessToken(new ServiceContainer([
            'corpId' => 'mock_corpId',
            'corpSecret' => 'mock_corpSecret',
        ]));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/externalcontact/del_corp_tag', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        $tagId = [
            'TAG_ID_1',
            'TAG_ID_2'
        ];

        $groupId = [
            'GROUP_ID_1',
            'GROUP_ID_2'
        ];

        $this->assertTrue($client->deleteCorpTag($tagId, $groupId));
    }

    public function testMarkTags()
    {
        $response = $this->buildResponse(Status::CODE_OK, '{"errcode":0,"errmsg":"ok"}');
        $app = $this->mockAccessToken(new ServiceContainer([
            'corpId' => 'mock_corpId',
            'corpSecret' => 'mock_corpSecret',
        ]));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/externalcontact/mark_tag', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        $params = [
            'userid' => 'zhangsan',
            'external_userid' => 'woAJ2GCAAAd1NPGHKSD4wKmE8Aabj9AAA',
            'add_tag' => ['TAGID1', 'TAGID2'],
            'remove_tag' => ['TAGID3', 'TAGID4']
        ];

        $this->assertTrue($client->markTags($params));
    }

    protected function readMockResponseJson(string $filename): string
    {
        return file_get_contents(__DIR__ . '/mock_data/Client/' . $filename);
    }
}