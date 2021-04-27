<?php
/**
 * User: XueSi
 * Date: 2021/4/25 18:58
 * Author: XueSi <1592328848@qq.com>
 */

namespace EasySwoole\WeChat\Tests\Work\User;


use EasySwoole\WeChat\Kernel\ServiceContainer;
use EasySwoole\WeChat\Tests\Mock\Message\Status;
use EasySwoole\WeChat\Tests\TestCase;
use EasySwoole\WeChat\Work\User\BatchJobsClient;
use Psr\Http\Message\ServerRequestInterface;

class BatchJobsClientTest extends TestCase
{
    public function testBatchUpdateUsers()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('batchUpdateUsers.json'));

        $app = $this->mockAccessToken(new ServiceContainer([
            'corpId' => 'mock_corpId',
            'corpSecret' => 'mock_corpSecret'
        ]));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/batch/syncuser', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new BatchJobsClient($app);

        $params = [
            'media_id' => 'xxxxxx',
            'to_invite' =>true,
            'callback' => [
                'url' => 'xxx',
                'token' => 'xxx',
                'encodingaeskey' => 'xxx'
            ]
        ];

        $this->assertIsArray($client->batchUpdateUsers($params));

        $this->assertSame(json_decode($this->readMockResponseJson('batchUpdateUsers.json'), true), $client->batchUpdateUsers($params));
    }

    public function testBatchReplaceUsers()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('batchReplaceUsers.json'));

        $app = $this->mockAccessToken(new ServiceContainer([
            'corpId' => 'mock_corpId',
            'corpSecret' => 'mock_corpSecret'
        ]));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/batch/replaceuser', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new BatchJobsClient($app);

        $params = [
            'media_id' => 'xxxxxx',
            'to_invite' =>true,
            'callback' => [
                'url' => 'xxx',
                'token' => 'xxx',
                'encodingaeskey' => 'xxx'
            ]
        ];

        $this->assertIsArray($client->batchReplaceUsers($params));

        $this->assertSame(json_decode($this->readMockResponseJson('batchReplaceUsers.json'), true), $client->batchReplaceUsers($params));
    }

    public function testBatchReplaceDepartments()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('batchReplaceDepartments.json'));

        $app = $this->mockAccessToken(new ServiceContainer([
            'corpId' => 'mock_corpId',
            'corpSecret' => 'mock_corpSecret'
        ]));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/batch/replaceparty', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new BatchJobsClient($app);

        $params = [
            'media_id' => 'xxxxxx',
            'callback' => [
                'url' => 'xxx',
                'token' => 'xxx',
                'encodingaeskey' => 'xxx'
            ]
        ];

        $this->assertIsArray($client->batchReplaceDepartments($params));

        $this->assertSame(json_decode($this->readMockResponseJson('batchReplaceDepartments.json'), true), $client->batchReplaceDepartments($params));
    }

    public function testGetJobStatus()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('getJobStatus.json'));

        $app = $this->mockAccessToken(new ServiceContainer([
            'corpId' => 'mock_corpId',
            'corpSecret' => 'mock_corpSecret'
        ]));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('GET', $request->getMethod());
            $this->assertEquals('/cgi-bin/batch/getresult', $request->getUri()->getPath());
            $this->assertEquals('jobid=JOBID&access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new BatchJobsClient($app);

        $this->assertIsArray($client->getJobStatus('JOBID'));

        $this->assertSame(json_decode($this->readMockResponseJson('getJobStatus.json'), true), $client->getJobStatus('JOBID'));
    }

    protected function readMockResponseJson(string $filename)
    {
        return file_get_contents(__DIR__ . '/mock_data/BatchJobsClient/' . $filename);
    }
}
