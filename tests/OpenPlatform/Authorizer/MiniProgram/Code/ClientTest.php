<?php
/**
 * Created by PhpStorm.
 * User: XueSi
 * Email: <1592328848@qq.com>
 * Date: 2021/4/24
 * Time: 15:07
 */

namespace EasySwoole\WeChat\Tests\OpenPlatform\Authorizer\MiniProgram\Code;

use EasySwoole\WeChat\Kernel\Psr\StreamResponse;
use EasySwoole\WeChat\OpenPlatform\Application;
use EasySwoole\WeChat\Tests\Mock\Message\Status;
use EasySwoole\WeChat\Tests\TestCase;
use EasySwoole\WeChat\OpenPlatform\Authorizer\MiniProgram\Code\Client;
use Psr\Http\Message\ServerRequestInterface;

class ClientTest extends TestCase
{
    public function testCommit()
    {
        $response = $this->buildResponse(Status::CODE_OK, '{"errcode":0,"errmsg":"ok"}');

        /** @var Application $app */
        $app = $this->mockAccessToken(new Application([
            'appId' => 'mock_component-app-id',
            'token' => 'mock_component-token',
        ]));

        $miniProgram = $app->miniProgram(
            'mock_app_id', 'mock_refresh_token'
        );
        $miniProgram = $this->mockAccessToken($miniProgram);

        $miniProgram = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/wxa/commit', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $miniProgram);

        $client = new Client($miniProgram);

        $this->assertTrue($client->commit('0', "{\"extAppid\":\"\",\"ext\":{\"attr1\":\"value1\",\"attr2\":\"value2\"},\"extPages\":{\"index\":{},\"search/index\":{}},\"pages\":[\"index\",\"search/index\"],\"window\":{},\"networkTimeout\":{},\"tabBar\":{},\"plugin\":{}}", 'V1.0', 'test'));
    }

    public function testGetPage()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('getPage.json'));

        /** @var Application $app */
        $app = $this->mockAccessToken(new Application([
            'appId' => 'mock_component-app-id',
            'token' => 'mock_component-token',
        ]));

        $miniProgram = $app->miniProgram(
            'mock_app_id', 'mock_refresh_token'
        );
        $miniProgram = $this->mockAccessToken($miniProgram);

        $miniProgram = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('GET', $request->getMethod());
            $this->assertEquals('/wxa/get_page', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $miniProgram);

        $client = new Client($miniProgram);

        $this->assertIsArray($client->getPage());

        $this->assertSame(json_decode($this->readMockResponseJson('getPage.json'), true), $client->getPage());
    }

    public function testGetQrCode()
    {
        $response = $this->buildResponse(Status::CODE_OK, file_get_contents(__DIR__ . '/mock_data/QRCode.jpg'), [
            'Content-disposition' => [
                'attachment',
                'filename="QRCode.jpg',
            ]
        ]);

        /** @var Application $app */
        $app = $this->mockAccessToken(new Application([
            'appId' => 'mock_component-app-id',
            'token' => 'mock_component-token',
        ]));

        $miniProgram = $app->miniProgram(
            'mock_app_id', 'mock_refresh_token'
        );
        $miniProgram = $this->mockAccessToken($miniProgram);

        $miniProgram = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('GET', $request->getMethod());
            $this->assertEquals('/wxa/get_qrcode', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $miniProgram);

        $client = new Client($miniProgram);

        $this->assertInstanceOf(StreamResponse::class, $client->getQrCode());

        $this->assertSame(file_get_contents(__DIR__ . '/mock_data/QRCode.jpg'), $client->getQrCode()->getContents());
    }

    public function testSubmitAudit()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('submitAudit.json'));

        /** @var Application $app */
        $app = $this->mockAccessToken(new Application([
            'appId' => 'mock_component-app-id',
            'token' => 'mock_component-token',
        ]));

        $miniProgram = $app->miniProgram(
            'mock_app_id', 'mock_refresh_token'
        );
        $miniProgram = $this->mockAccessToken($miniProgram);

        $miniProgram = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/wxa/submit_audit', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $miniProgram);

        $client = new Client($miniProgram);

        $data = [
            'item_list' => [
                [
                    'address' => 'index',
                    'tag' => '学习 生活',
                    'first_class' => '文娱',
                    'second_class' => '资讯',
                    'first_id' => 1,
                    'second_id' => 2,
                    'title' => '首页',
                ],
                [
                    'address' => 'page/logs/logs',
                    'tag' => '学习 工作',
                    'first_class' => '教育',
                    'second_class' => '学历教育',
                    'third_class' => '高等',
                    'first_id' => 3,
                    'second_id' => 4,
                    'third_id' => 5,
                    'title' => '日志',
                ],
            ],
            'feedback_info' => 'blablabla',
            'feedback_stuff' => 'xx|yy|zz',
            'preview_info' => [
                'video_id_list' => ['xxxx'],
                'pic_id_list' => [
                    'xxxx',
                    'yyyy',
                    'zzzz',
                ],
            ],
            'version_desc' => 'blablabla',
            'ugc_declare' => [
                'scene' => [
                    1,
                    2,
                ],
                'method' => [
                    1,
                ],
                'has_audit_team' => 1,
                'audit_desc' => 'blablabla',
            ],
        ];

        $this->assertIsArray($client->submitAudit($data));

        $this->assertSame(json_decode($this->readMockResponseJson('submitAudit.json'), true), $client->submitAudit($data));
    }

    public function testGetAuditStatus()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('getAuditStatus.json'));

        /** @var Application $app */
        $app = $this->mockAccessToken(new Application([
            'appId' => 'mock_component-app-id',
            'token' => 'mock_component-token',
        ]));

        $miniProgram = $app->miniProgram(
            'mock_app_id', 'mock_refresh_token'
        );
        $miniProgram = $this->mockAccessToken($miniProgram);

        $miniProgram = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/wxa/get_auditstatus', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $miniProgram);

        $client = new Client($miniProgram);

        $ret = $client->getAuditStatus(1234567);

        $this->assertIsArray($ret);

        $this->assertSame(json_decode($this->readMockResponseJson('getAuditStatus.json'), true), $ret);
    }

    public function testGetLastAuditStatus()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('getLatestAuditStatus.json'));

        /** @var Application $app */
        $app = $this->mockAccessToken(new Application([
            'appId' => 'mock_component-app-id',
            'token' => 'mock_component-token',
        ]));

        $miniProgram = $app->miniProgram(
            'mock_app_id', 'mock_refresh_token'
        );
        $miniProgram = $this->mockAccessToken($miniProgram);

        $miniProgram = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('GET', $request->getMethod());
            $this->assertEquals('/wxa/get_latest_auditstatus', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $miniProgram);

        $client = new Client($miniProgram);

        $ret = $client->getLatestAuditStatus();

        $this->assertIsArray($ret);

        $this->assertSame(json_decode($this->readMockResponseJson('getLatestAuditStatus.json'), true), $ret);
    }

    public function testWithdrawAudit()
    {
        $response = $this->buildResponse(Status::CODE_OK, '{"errcode":0,"errmsg":"ok"}');

        /** @var Application $app */
        $app = $this->mockAccessToken(new Application([
            'appId' => 'mock_component-app-id',
            'token' => 'mock_component-token',
        ]));

        $miniProgram = $app->miniProgram(
            'mock_app_id', 'mock_refresh_token'
        );
        $miniProgram = $this->mockAccessToken($miniProgram);

        $miniProgram = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('GET', $request->getMethod());
            $this->assertEquals('/wxa/undocodeaudit', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $miniProgram);

        $client = new Client($miniProgram);

        $this->assertTrue($client->withdrawAudit());
    }

    public function testRelease()
    {
        $response = $this->buildResponse(Status::CODE_OK, '{"errcode":0,"errmsg":"ok"}');

        /** @var Application $app */
        $app = $this->mockAccessToken(new Application([
            'appId' => 'mock_component-app-id',
            'token' => 'mock_component-token',
        ]));

        $miniProgram = $app->miniProgram(
            'mock_app_id', 'mock_refresh_token'
        );
        $miniProgram = $this->mockAccessToken($miniProgram);

        $miniProgram = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/wxa/release', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $miniProgram);

        $client = new Client($miniProgram);

        $this->assertTrue($client->release());
    }

    public function testRollbackRelease()
    {
        $response = $this->buildResponse(Status::CODE_OK, '{"errcode":0,"errmsg":"ok"}');

        /** @var Application $app */
        $app = $this->mockAccessToken(new Application([
            'appId' => 'mock_component-app-id',
            'token' => 'mock_component-token',
        ]));

        $miniProgram = $app->miniProgram(
            'mock_app_id', 'mock_refresh_token'
        );
        $miniProgram = $this->mockAccessToken($miniProgram);

        $miniProgram = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('GET', $request->getMethod());
            $this->assertEquals('/wxa/revertcoderelease', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $miniProgram);

        $client = new Client($miniProgram);

        $this->assertTrue($client->rollbackRelease());
    }

    public function testGetHistoryVersion()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('getHistoryVersion.json'));

        /** @var Application $app */
        $app = $this->mockAccessToken(new Application([
            'appId' => 'mock_component-app-id',
            'token' => 'mock_component-token',
        ]));

        $miniProgram = $app->miniProgram(
            'mock_app_id', 'mock_refresh_token'
        );
        $miniProgram = $this->mockAccessToken($miniProgram);

        $miniProgram = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('GET', $request->getMethod());
            $this->assertEquals('/wxa/revertcoderelease', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token&action=get_history_version', $request->getUri()->getQuery());
        }, $response, $miniProgram);

        $client = new Client($miniProgram);

        $ret = $client->getHistoryVersion();

        $this->assertIsArray($ret);

        $this->assertSame(json_decode($this->readMockResponseJson('getHistoryVersion.json'), true), $ret);
    }

    public function testGrayRelease()
    {
        $response = $this->buildResponse(Status::CODE_OK, '{"errcode":0,"errmsg":"ok"}');

        /** @var Application $app */
        $app = $this->mockAccessToken(new Application([
            'appId' => 'mock_component-app-id',
            'token' => 'mock_component-token',
        ]));

        $miniProgram = $app->miniProgram(
            'mock_app_id', 'mock_refresh_token'
        );
        $miniProgram = $this->mockAccessToken($miniProgram);

        $miniProgram = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/wxa/grayrelease', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $miniProgram);

        $client = new Client($miniProgram);

        $this->assertTrue($client->grayRelease(1));
    }

    public function testGetGrayRelease()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('getGrayRelease.json'));

        /** @var Application $app */
        $app = $this->mockAccessToken(new Application([
            'appId' => 'mock_component-app-id',
            'token' => 'mock_component-token',
        ]));

        $miniProgram = $app->miniProgram(
            'mock_app_id', 'mock_refresh_token'
        );
        $miniProgram = $this->mockAccessToken($miniProgram);

        $miniProgram = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('GET', $request->getMethod());
            $this->assertEquals('/wxa/getgrayreleaseplan', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $miniProgram);

        $client = new Client($miniProgram);

        $ret = $client->getGrayRelease();

        $this->assertIsArray($ret);

        $this->assertSame(json_decode($this->readMockResponseJson('getGrayRelease.json'), true), $ret);
    }

    public function testRevertGrayRelease()
    {
        $response = $this->buildResponse(Status::CODE_OK, '{"errcode":0,"errmsg":"ok"}');

        /** @var Application $app */
        $app = $this->mockAccessToken(new Application([
            'appId' => 'mock_component-app-id',
            'token' => 'mock_component-token',
        ]));

        $miniProgram = $app->miniProgram(
            'mock_app_id', 'mock_refresh_token'
        );
        $miniProgram = $this->mockAccessToken($miniProgram);

        $miniProgram = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('GET', $request->getMethod());
            $this->assertEquals('/wxa/revertgrayrelease', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $miniProgram);

        $client = new Client($miniProgram);

        $this->assertTrue($client->revertGrayRelease());
    }

    public function testChangeVisitRelease()
    {
        $response = $this->buildResponse(Status::CODE_OK, '{"errcode":0,"errmsg":"ok"}');

        /** @var Application $app */
        $app = $this->mockAccessToken(new Application([
            'appId' => 'mock_component-app-id',
            'token' => 'mock_component-token',
        ]));

        $miniProgram = $app->miniProgram(
            'mock_app_id', 'mock_refresh_token'
        );
        $miniProgram = $this->mockAccessToken($miniProgram);

        $miniProgram = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/wxa/change_visitstatus', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $miniProgram);

        $client = new Client($miniProgram);

        $this->assertTrue($client->changeVisitStatus('close'));
    }

    public function testGetSupportVersion()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('getSupportVersion.json'));

        /** @var Application $app */
        $app = $this->mockAccessToken(new Application([
            'appId' => 'mock_component-app-id',
            'token' => 'mock_component-token',
        ]));

        $miniProgram = $app->miniProgram(
            'mock_app_id', 'mock_refresh_token'
        );
        $miniProgram = $this->mockAccessToken($miniProgram);

        $miniProgram = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/wxopen/getweappsupportversion', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $miniProgram);

        $client = new Client($miniProgram);

        $ret = $client->getSupportVersion();

        $this->assertIsArray($ret);

        $this->assertSame(json_decode($this->readMockResponseJson('getSupportVersion.json'), true), $ret);
    }

    public function testSetSupportVersion()
    {
        $response = $this->buildResponse(Status::CODE_OK, '{"errcode":0,"errmsg":"ok"}');

        /** @var Application $app */
        $app = $this->mockAccessToken(new Application([
            'appId' => 'mock_component-app-id',
            'token' => 'mock_component-token',
        ]));

        $miniProgram = $app->miniProgram(
            'mock_app_id', 'mock_refresh_token'
        );
        $miniProgram = $this->mockAccessToken($miniProgram);

        $miniProgram = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/wxopen/setweappsupportversion', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $miniProgram);

        $client = new Client($miniProgram);

        $this->assertTrue($client->setSupportVersion('1.0.0'));
    }

    public function testQueryQuota()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('queryQuota.json'));

        /** @var Application $app */
        $app = $this->mockAccessToken(new Application([
            'appId' => 'mock_component-app-id',
            'token' => 'mock_component-token',
        ]));

        $miniProgram = $app->miniProgram(
            'mock_app_id', 'mock_refresh_token'
        );
        $miniProgram = $this->mockAccessToken($miniProgram);

        $miniProgram = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('GET', $request->getMethod());
            $this->assertEquals('/wxa/queryquota', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $miniProgram);

        $client = new Client($miniProgram);

        $ret = $client->queryQuota();

        $this->assertIsArray($ret);

        $this->assertSame(json_decode($this->readMockResponseJson('queryQuota.json'), true), $ret);
    }

    public function testSpeedupAudit()
    {
        $response = $this->buildResponse(Status::CODE_OK, '{"errcode":0,"errmsg":"ok"}');

        /** @var Application $app */
        $app = $this->mockAccessToken(new Application([
            'appId' => 'mock_component-app-id',
            'token' => 'mock_component-token',
        ]));

        $miniProgram = $app->miniProgram(
            'mock_app_id', 'mock_refresh_token'
        );
        $miniProgram = $this->mockAccessToken($miniProgram);

        $miniProgram = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/wxa/speedupaudit', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $miniProgram);

        $client = new Client($miniProgram);

        $this->assertTrue($client->speedupAudit(12345));
    }

    protected function readMockResponseJson(string $filename): string
    {
        return file_get_contents(__DIR__ . '/mock_data/' . $filename);
    }
}
