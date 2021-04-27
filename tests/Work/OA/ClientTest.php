<?php
/**
 * Created by PhpStorm.
 * User: XueSi
 * Email: <1592328848@qq.com>
 * Date: 2021/4/25
 * Time: 2:37
 */

namespace EasySwoole\WeChat\Tests\Work\OA;


use EasySwoole\WeChat\Kernel\ServiceContainer;
use EasySwoole\WeChat\Tests\Mock\Message\Status;
use EasySwoole\WeChat\Tests\TestCase;
use EasySwoole\WeChat\Work\OA\Client;
use Psr\Http\Message\ServerRequestInterface;

class ClientTest extends TestCase
{
    public function testCheckinRecords()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('checkinRecords.json'));

        $app = $this->mockAccessToken(new ServiceContainer([
            'corpId' => 'mock_corpId',
            'corpSecret' => 'mock_corpSecret'
        ]));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/checkin/getcheckindata', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        $userList = ["james", "paul"];

        $this->assertIsArray($client->checkinRecords(1492617600, 1492790400, $userList, 3));

        $this->assertSame(json_decode($this->readMockResponseJson('checkinRecords.json'), true), $client->checkinRecords(1492617600, 1492790400, $userList, 3));
    }

    public function testCheckinRules()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('checkinRules.json'));

        $app = $this->mockAccessToken(new ServiceContainer([
            'corpId' => 'mock_corpId',
            'corpSecret' => 'mock_corpSecret'
        ]));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/checkin/getcheckinoption', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        $userList = ["james", "paul"];

        $this->assertIsArray($client->checkinRules(1511971200, $userList));

        $this->assertSame(json_decode($this->readMockResponseJson('checkinRules.json'), true), $client->checkinRules(1511971200, $userList));
    }

    public function testApprovalTemplate()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('approvalTemplate.json'));

        $app = $this->mockAccessToken(new ServiceContainer([
            'corpId' => 'mock_corpId',
            'corpSecret' => 'mock_corpSecret'
        ]));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/oa/gettemplatedetail', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        $this->assertIsArray($client->approvalTemplate('ZLqk8pcsAoXZ1eYa6vpAgfX28MPdYU3ayMaSPHaaa'));

        $this->assertSame(json_decode($this->readMockResponseJson('approvalTemplate.json'), true), $client->approvalTemplate('ZLqk8pcsAoXZ1eYa6vpAgfX28MPdYU3ayMaSPHaaa'));
    }

    public function testCreateApproval()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('createApproval.json'));

        $app = $this->mockAccessToken(new ServiceContainer([
            'corpId' => 'mock_corpId',
            'corpSecret' => 'mock_corpSecret'
        ]));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/oa/applyevent', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        $data = [
            'creator_userid' => 'WangXiaoMing',
            'template_id' => '3Tka1eD6v6JfzhDMqPd3aMkFdxqtJMc2ZRioeFXkaaa',
            'use_template_approver' => 0,
            'choose_department' => 2,
            'approver' => [
                [
                    'attr' => 2,
                    'userid' => ['WuJunJie', 'WangXiaoMing']
                ],
                [
                    'attr' => 1,
                    'userid' => ['LiuXiaoGang']
                ]
            ],
            'notifyer' => ['WuJunJie', 'WangXiaoMing'],
            'notify_type' => 1,
            'apply_data' => [
                'contents' => [
                    [
                        'control' => 'Text',
                        'id' => 'Text-15111111111',
                        'value' => [
                            'text' => '文本填写的内容',
                        ],
                    ],
                ],
            ],
            'summary_list' => [
                [
                    'summary_info' => [
                        [
                            'text' => '摘要第1行',
                            'lang' => 'zh_CN',
                        ]
                    ],
                ],
                [
                    'summary_info' => [
                        [
                            'text' => '摘要第2行',
                            'lang' => 'zh_CN',
                        ]
                    ],
                ],
                [
                    'summary_info' => [
                        [
                            'text' => '摘要第3行',
                            'lang' => 'zh_CN',
                        ]
                    ],
                ],
            ]
        ];

        $this->assertIsArray($client->createApproval($data));

        $this->assertSame(json_decode($this->readMockResponseJson('createApproval.json'), true), $client->createApproval($data));

    }

    public function testApprovalNumbers()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('approvalNumbers.json'));

        $app = $this->mockAccessToken(new ServiceContainer([
            'corpId' => 'mock_corpId',
            'corpSecret' => 'mock_corpSecret'
        ]));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/oa/getapprovalinfo', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        $filter = [
            [
                'key' => 'template_id',
                'value' => 'ZLqk8pcsAoaXZ1eY56vpAgfX28MPdYU3ayMaSPHaaa',
            ],
            [
                'key' => 'creator',
                'value' => 'WuJunJie',
            ],
            [
                'key' => 'department',
                'value' => '1',
            ],
            [
                'key' => 'sp_status',
                'value' => '1',
            ]
        ];

        $this->assertIsArray($client->approvalNumbers(
            '1569546000',
            '1569718800',
            0,
            100,
            $filter
        ));

        $this->assertSame(json_decode($this->readMockResponseJson('approvalNumbers.json'), true), $client->approvalNumbers(
            '1569546000',
            '1569718800',
            0,
            100,
            $filter
        ));
    }

    public function testApprovalDetail()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('approvalDetail.json'));

        $app = $this->mockAccessToken(new ServiceContainer([
            'corpId' => 'mock_corpId',
            'corpSecret' => 'mock_corpSecret'
        ]));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/oa/getapprovaldetail', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        $this->assertIsArray($client->approvalDetail(201909270001));

        $this->assertSame(json_decode($this->readMockResponseJson('approvalDetail.json'), true), $client->approvalDetail(201909270001));
    }

    public function testApprovalRecords()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('approvalRecords.json'));

        $app = $this->mockAccessToken(new ServiceContainer([
            'corpId' => 'mock_corpId',
            'corpSecret' => 'mock_corpSecret'
        ]));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/corp/getapprovaldata', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        $this->assertIsArray($client->approvalRecords(1492617600, 1492790400, 201704200003));

        $this->assertSame(json_decode($this->readMockResponseJson('approvalRecords.json'), true), $client->approvalRecords(1492617600, 1492790400, 201704200003));
    }

    public function testDialRecords()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('dialRecords.json'));

        $app = $this->mockAccessToken(new ServiceContainer([
            'corpId' => 'mock_corpId',
            'corpSecret' => 'mock_corpSecret'
        ]));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/dial/get_dial_record', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        $this->assertIsArray($client->dialRecords(1536508800, 1536940800, 0, 100));

        $this->assertSame(json_decode($this->readMockResponseJson('dialRecords.json'), true), $client->dialRecords(1536508800, 1536940800, 0, 100));
    }

    protected function readMockResponseJson(string $filename): string
    {
        return file_get_contents(__DIR__ . '/mock_data/' . $filename);
    }
}