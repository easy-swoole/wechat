<?php
/**
 * Created by PhpStorm.
 * User: XueSi
 * Email: <1592328848@qq.com>
 * Date: 2021/4/24
 * Time: 17:05
 */

namespace EasySwoole\WeChat\Tests\Work\Agent;


use EasySwoole\WeChat\Kernel\ServiceContainer;
use EasySwoole\WeChat\Tests\Mock\Message\Status;
use EasySwoole\WeChat\Tests\TestCase;
use EasySwoole\WeChat\Work\Agent\WorkbenchClient;
use Psr\Http\Message\ServerRequestInterface;

class WorkbenchClientTest extends TestCase
{
    public function testSetWorkBenchTemplate()
    {
        $response = $this->buildResponse(Status::CODE_OK, '{"errcode":0,"errmsg":"ok"}');
        $app = $this->mockAccessToken(new ServiceContainer([
            'corpId' => 'mock_corpId',
            'corpSecret' => 'mock_corpSecret',
        ]));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/agent/set_workbench_template', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $params = [
            'agentid' => 1000005,
            'type' => 'image',
            'image' =>
                array(
                    'url' => 'xxxx',
                    'jump_url' => 'http://www.qq.com',
                    'pagepath' => 'pages/index',
                ),
            'replace_user_data' => true,
        ];

        $client = new WorkbenchClient($app);
        $this->assertTrue($client->setWorkbenchTemplate($params));
    }

    public function testGetWorkBenchTemplate()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('getWorkBenchTemplate.json'));
        $app = $this->mockAccessToken(new ServiceContainer([
            'corpId' => 'mock_corpId',
            'corpSecret' => 'mock_corpSecret',
        ]));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/agent/get_workbench_template', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new WorkbenchClient($app);
        $this->assertIsArray($client->getWorkbenchTemplate(1000005));
        $this->assertSame(json_decode($this->readMockResponseJson('getWorkBenchTemplate.json'), true), $client->getWorkbenchTemplate(1000005));
    }

    public function testSetWorkBenchData()
    {
        $response = $this->buildResponse(Status::CODE_OK, '{"errcode":0,"errmsg":"ok"}');
        $app = $this->mockAccessToken(new ServiceContainer([
            'corpId' => 'mock_corpId',
            'corpSecret' => 'mock_corpSecret',
        ]));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/agent/set_workbench_data', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $params = [
            'agentid' => 1000005,
            'userid' => 'test',
            'type' => 'keydata',
            'keydata' => [
                'items' => [
                    [
                        'key' => '待审批',
                        'data' => '2',
                        'jump_url' => 'http://www.qq.com',
                        'pagepath' => 'pages/index'
                    ],
                    [
                        'key' => '带批阅作业',
                        'data' => '4',
                        'jump_url' => 'http://www.qq.com',
                        'pagepath' => 'pages/index'
                    ],
                    [
                        'key' => '成绩录入',
                        'data' => '45',
                        'jump_url' => 'http://www.qq.com',
                        'pagepath' => 'pages/index'
                    ],
                    [
                        'key' => '综合评价',
                        'data' => '98',
                        'jump_url' => 'http://www.qq.com',
                        'pagepath' => 'pages/index'
                    ]
                ]
            ]
        ];

        $client = new WorkbenchClient($app);
        $this->assertTrue($client->setWorkbenchData($params));
    }

    protected function readMockResponseJson(string $filename): string
    {
        return file_get_contents(__DIR__ . '/mock_data/' . $filename);
    }
}