<?php
/**
 * User: XueSi
 * Date: 2021/4/26 11:53
 * Author: XueSi <1592328848@qq.com>
 */

namespace EasySwoole\WeChat\Tests\Work\User;


use EasySwoole\WeChat\Kernel\Exceptions\InvalidArgumentException;
use EasySwoole\WeChat\Kernel\ServiceContainer;
use EasySwoole\WeChat\Tests\Mock\Message\Status;
use EasySwoole\WeChat\Tests\TestCase;
use EasySwoole\WeChat\Work\User\Client;
use Psr\Http\Message\ServerRequestInterface;

class ClientTest extends TestCase
{
    public function testCreate()
    {
        $response = $this->buildResponse(Status::CODE_OK, '{"errcode":0,"errmsg":"created"}');

        $app = $this->mockAccessToken(new ServiceContainer([
            'corpId' => 'mock_corpId',
            'corpSecret' => 'mock_corpSecret'
        ]));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/user/create', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        $data = [
            'userid' => 'zhangsan',
            'name' => '张三',
            'alias' => 'jackzhang',
            'mobile' => '+86 13800000000',
            'department' => [1, 2],
            'order' => [10, 40],
            'position' => '产品经理',
            'gender' => '1',
            'email' => 'zhangsan@gzdev.com',
            'is_leader_in_dept' => [1, 0],
            'enable' => 1,
            'avatar_mediaid' => '2-G6nrLmr5EC3MNb_-zL1dDdzkd0p7cNliYu9V5w7o8K0',
            'telephone' => '020-123456',
            'address' => '广州市海珠区新港中路',
            'main_department' => 1,
            'extattr' => [
                'attrs' => [
                    [
                        'type' => 0,
                        'name' => '文本名称',
                        'text' => [
                            'value' => '文本',
                        ],
                    ],
                    [
                        'type' => 1,
                        'name' => '网页名称',
                        'web' => [
                            'url' => 'http://www.test.com',
                            'title' => '标题',
                        ],
                    ],
                ],
            ],
            'to_invite' => true,
            'external_position' => '高级产品经理',
            'external_profile' => [
                'external_corp_name' => '企业简称',
                'external_attr' => [
                    [
                        'type' => 0,
                        'name' => '文本名称',
                        'text' => [
                            'value' => '文本',
                        ],
                    ],
                    [
                        'type' => 1,
                        'name' => '网页名称',
                        'web' => [
                            'url' => 'http://www.test.com',
                            'title' => '标题',
                        ],
                    ],
                    [
                        'type' => 2,
                        'name' => '测试app',
                        'miniprogram' => [
                            'appid' => 'wx8bd8012614784fake',
                            'pagepath' => '/index',
                            'title' => 'my miniprogram',
                        ],
                    ],
                ],
            ],
        ];

        $this->assertTrue($client->create($data));
    }

    public function testUpdate()
    {
        $response = $this->buildResponse(Status::CODE_OK, '{"errcode":0,"errmsg":"updated"}');

        $app = $this->mockAccessToken(new ServiceContainer([
            'corpId' => 'mock_corpId',
            'corpSecret' => 'mock_corpSecret'
        ]));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/user/update', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        $data = [
            'name' => '李四',
            'department' => [1],
            'order' => [10],
            'position' => '后台工程师',
            'mobile' => '13800000000',
            'gender' => '1',
            'email' => 'zhangsan@gzdev.com',
            'is_leader_in_dept' => [1],
            'enable' => 1,
            'avatar_mediaid' => '2-G6nrLmr5EC3MNb_-zL1dDdzkd0p7cNliYu9V5w7o8K0',
            'telephone' => '020-123456',
            'alias' => 'jackzhang',
            'address' => '广州市海珠区新港中路',
            'main_department' => 1,
            'extattr' => [
                'attrs' => [
                    [
                        'type' => 0,
                        'name' => '文本名称',
                        'text' => [
                            'value' => '文本',
                        ],
                    ],
                    [
                        'type' => 1,
                        'name' => '网页名称',
                        'web' => [
                            'url' => 'http://www.test.com',
                            'title' => '标题',
                        ],
                    ],
                ],
            ],
            'external_position' => '工程师',
            'external_profile' => [
                'external_corp_name' => '企业简称',
                'external_attr' => [
                    [
                        'type' => 0,
                        'name' => '文本名称',
                        'text' => [
                            'value' => '文本',
                        ],
                    ],
                    [
                        'type' => 1,
                        'name' => '网页名称',
                        'web' => [
                            'url' => 'http://www.test.com',
                            'title' => '标题',
                        ],
                    ],
                    [
                        'type' => 2,
                        'name' => '测试app',
                        'miniprogram' => [
                            'appid' => 'wx8bd80126147dFAKE',
                            'pagepath' => '/index',
                            'title' => 'my miniprogram',
                        ],
                    ],
                ],
            ],
        ];

        $this->assertTrue($client->update('zhangsan', $data));
    }

    public function testDelete()
    {
        $response = $this->buildResponse(Status::CODE_OK, '{"errcode":0,"errmsg":"deleted"}');

        $app = $this->mockAccessToken(new ServiceContainer([
            'corpId' => 'mock_corpId',
            'corpSecret' => 'mock_corpSecret'
        ]));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('GET', $request->getMethod());
            $this->assertEquals('/cgi-bin/user/delete', $request->getUri()->getPath());
            $this->assertEquals('userid=USERID&access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        $this->assertTrue($client->delete('USERID'));
    }

    public function testBatchDelete()
    {
        $response = $this->buildResponse(Status::CODE_OK, '{"errcode":0,"errmsg":"deleted"}');

        $app = $this->mockAccessToken(new ServiceContainer([
            'corpId' => 'mock_corpId',
            'corpSecret' => 'mock_corpSecret'
        ]));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/user/batchdelete', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        $this->assertTrue($client->delete(["zhangsan", "lisi"]));
    }

    public function testGet()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('get.json'));

        $app = $this->mockAccessToken(new ServiceContainer([
            'corpId' => 'mock_corpId',
            'corpSecret' => 'mock_corpSecret'
        ]));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('GET', $request->getMethod());
            $this->assertEquals('/cgi-bin/user/get', $request->getUri()->getPath());
            $this->assertEquals('userid=USERID&access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        $this->assertIsArray($client->get('USERID'));

        $this->assertSame(json_decode($this->readMockResponseJson('get.json'), true), $client->get('USERID'));
    }

    public function testGetDepartmentUsers()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('getDepartmentUsers.json'));

        $app = $this->mockAccessToken(new ServiceContainer([
            'corpId' => 'mock_corpId',
            'corpSecret' => 'mock_corpSecret'
        ]));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('GET', $request->getMethod());
            $this->assertEquals('/cgi-bin/user/simplelist', $request->getUri()->getPath());
            $this->assertEquals('department_id=15&fetch_child=0&access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        $this->assertIsArray($client->getDepartmentUsers(
            15
        ));

        $this->assertSame(json_decode($this->readMockResponseJson('getDepartmentUsers.json'), true), $client->getDepartmentUsers(
            15
        ));

        // 递归获取子部门下面的成员
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('getDepartmentUsers.json'));

        $app = $this->mockAccessToken(new ServiceContainer([
            'corpId' => 'mock_corpId',
            'corpSecret' => 'mock_corpSecret'
        ]));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('GET', $request->getMethod());
            $this->assertEquals('/cgi-bin/user/simplelist', $request->getUri()->getPath());
            $this->assertEquals('department_id=15&fetch_child=1&access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        $this->assertIsArray($client->getDepartmentUsers(
            15,
            true
        ));

        $this->assertSame(json_decode($this->readMockResponseJson('getDepartmentUsers.json'), true), $client->getDepartmentUsers(
            15,
            true
        ));
    }

    public function testGetDetailedDepartmentUsers()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('getDetailedDepartmentUsers.json'));

        $app = $this->mockAccessToken(new ServiceContainer([
            'corpId' => 'mock_corpId',
            'corpSecret' => 'mock_corpSecret'
        ]));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('GET', $request->getMethod());
            $this->assertEquals('/cgi-bin/user/list', $request->getUri()->getPath());
            $this->assertEquals('department_id=18&fetch_child=0&access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        $this->assertIsArray($client->getDetailedDepartmentUsers(
            18
        ));

        $this->assertSame(json_decode($this->readMockResponseJson('getDetailedDepartmentUsers.json'), true), $client->getDetailedDepartmentUsers(
            18
        ));

        // 递归获取子部门下面的成员
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('getDetailedDepartmentUsers.json'));

        $app = $this->mockAccessToken(new ServiceContainer([
            'corpId' => 'mock_corpId',
            'corpSecret' => 'mock_corpSecret'
        ]));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('GET', $request->getMethod());
            $this->assertEquals('/cgi-bin/user/list', $request->getUri()->getPath());
            $this->assertEquals('department_id=18&fetch_child=1&access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        $this->assertIsArray($client->getDetailedDepartmentUsers(
            18,
            true
        ));

        $this->assertSame(json_decode($this->readMockResponseJson('getDetailedDepartmentUsers.json'), true), $client->getDetailedDepartmentUsers(
            18,
            true
        ));
    }

    public function testUserIdToOpenid()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('userIdToOpenid.json'));

        $app = $this->mockAccessToken(new ServiceContainer([
            'corpId' => 'mock_corpId',
            'corpSecret' => 'mock_corpSecret'
        ]));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/user/convert_to_openid', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        $this->assertIsArray($client->userIdToOpenid('zhangsan'));

        $this->assertSame(json_decode($this->readMockResponseJson('userIdToOpenid.json'), true), $client->userIdToOpenid('zhangsan'));
    }

    public function testOpenidToUserId()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('openidToUserId.json'));

        $app = $this->mockAccessToken(new ServiceContainer([
            'corpId' => 'mock_corpId',
            'corpSecret' => 'mock_corpSecret'
        ]));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/user/convert_to_userid', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        $this->assertIsArray($client->openidToUserId('oDjGHs-1yCnGrRovBj2yHij5JAAA'));

        $this->assertSame(json_decode($this->readMockResponseJson('openidToUserId.json'), true), $client->openidToUserId('oDjGHs-1yCnGrRovBj2yHij5JAAA'));
    }

    public function testMobileToUserId()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('mobileToUserId.json'));

        $app = $this->mockAccessToken(new ServiceContainer([
            'corpId' => 'mock_corpId',
            'corpSecret' => 'mock_corpSecret'
        ]));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/user/getuserid', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        $this->assertIsArray($client->mobileToUserId('13430388888'));

        $this->assertSame(json_decode($this->readMockResponseJson('mobileToUserId.json'), true), $client->mobileToUserId('13430388888'));
    }

    public function testAccept()
    {
        $response = $this->buildResponse(Status::CODE_OK, '{"errcode":0,"errmsg":"ok"}');

        $app = $this->mockAccessToken(new ServiceContainer([
            'corpId' => 'mock_corpId',
            'corpSecret' => 'mock_corpSecret'
        ]));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('GET', $request->getMethod());
            $this->assertEquals('/cgi-bin/user/authsucc', $request->getUri()->getPath());
            $this->assertEquals('userid=USERID&access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        $this->assertTrue($client->accept('USERID'));
    }

    public function testInvite()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('invite.json'));

        $app = $this->mockAccessToken(new ServiceContainer([
            'corpId' => 'mock_corpId',
            'corpSecret' => 'mock_corpSecret'
        ]));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/batch/invite', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        $params = [
            'user' => ['UserID1', 'UserID2', 'UserID3'],
            'party' => ['PartyID1', 'PartyID2'],
            'tag' => ['TagID1', 'TagID2'],
        ];

        $this->assertIsArray($client->invite($params));

        $this->assertSame(json_decode($this->readMockResponseJson('invite.json'), true), $client->invite($params));
    }

    public function testGetInvitationQrCode()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('getInvitationQrCode.json'));

        $app = $this->mockAccessToken(new ServiceContainer([
            'corpId' => 'mock_corpId',
            'corpSecret' => 'mock_corpSecret'
        ]));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('GET', $request->getMethod());
            $this->assertEquals('/cgi-bin/corp/get_join_qrcode', $request->getUri()->getPath());
            $this->assertEquals('size_type=1&access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        try {
            $client->getInvitationQrCode(5);
        } catch (\Exception $exception) {
            $this->assertInstanceOf(InvalidArgumentException::class, $exception);
            $this->assertSame('The sizeType must be 1, 2, 3, 4.', $exception->getMessage());
        }

        $this->assertIsArray($client->getInvitationQrCode(1));

        $this->assertSame(json_decode($this->readMockResponseJson('getInvitationQrCode.json'), true), $client->getInvitationQrCode(1));
    }

    protected function readMockResponseJson(string $filename)
    {
        return file_get_contents(__DIR__ . '/mock_data/Client/' . $filename);
    }
}
