<?php
/**
 * User: XueSi
 * Date: 2021/4/23 18:34
 * Author: XueSi <1592328848@qq.com>
 */

namespace EasySwoole\WeChat\Tests\OpenPlatform\Authorizer\MiniProgram\Account;

use EasySwoole\WeChat\OpenPlatform\Application;
use EasySwoole\WeChat\Tests\Mock\Message\Status;
use EasySwoole\WeChat\Tests\TestCase;
use Psr\Http\Message\ServerRequestInterface;
use EasySwoole\WeChat\OpenPlatform\Authorizer\MiniProgram\Account\Client;

class ClientTest extends TestCase
{
    public function testGetBasicInfo()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('getBasicInfo.json'));

        $app = new Application([
            'appId' => 'component-app-id',
            'appSecret' => 'component-secret',
            'token' => 'component-token',
            'aesKey' => 'Qqx2S6jV3mp5prWPg5x3eBmeU1kLayZio4Q9ZxWTbmf'
        ]);

        /** @var Application $app */
        $app = $this->mockAccessToken($app);

        $miniProgram = $app->miniProgram(
            'mock_app_id', 'mock_refresh_token'
        );
        $miniProgram = $this->mockAccessToken($miniProgram);

        $miniProgram = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('GET', $request->getMethod());
            $this->assertEquals('/cgi-bin/account/getaccountbasicinfo', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $miniProgram);

        $client = new Client($miniProgram, $app);

        $this->assertIsArray($client->getBasicInfo());

        $this->assertSame(json_decode($this->readMockResponseJson('getBasicInfo.json'), true), $client->getBasicInfo());
    }

    public function testUpdateAvatar()
    {
        $response = $this->buildResponse(Status::CODE_OK, '{"errcode":0,"errmsg":"ok"}');

        $app = new Application([
            'appId' => 'component-app-id',
            'appSecret' => 'component-secret',
            'token' => 'component-token',
            'aesKey' => 'Qqx2S6jV3mp5prWPg5x3eBmeU1kLayZio4Q9ZxWTbmf'
        ]);

        /** @var Application $app */
        $app = $this->mockAccessToken($app);

        $miniProgram = $app->miniProgram(
            'mock_app_id', 'mock_refresh_token'
        );
        $miniProgram = $this->mockAccessToken($miniProgram);

        $miniProgram = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/account/modifyheadimage', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $miniProgram);

        $client = new Client($miniProgram, $app);

        $this->assertTrue($client->updateAvatar('mI-4E_sFh_2X3g-qmTIWD83RT78ytI1_6VfgFp_A3-Y2U5T_nLl3nm1xYTafFJ8p', '0', '0', '0.7596899224806202', '0.49'));
    }

    public function testUpdateSignature()
    {
        $response = $this->buildResponse(Status::CODE_OK, '{"errcode":0,"errmsg":"ok"}');

        $app = new Application([
            'appId' => 'component-app-id',
            'appSecret' => 'component-secret',
            'token' => 'component-token',
            'aesKey' => 'Qqx2S6jV3mp5prWPg5x3eBmeU1kLayZio4Q9ZxWTbmf'
        ]);

        /** @var Application $app */
        $app = $this->mockAccessToken($app);

        $miniProgram = $app->miniProgram(
            'mock_app_id', 'mock_refresh_token'
        );
        $miniProgram = $this->mockAccessToken($miniProgram);

        $miniProgram = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/account/modifysignature', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $miniProgram);

        $client = new Client($miniProgram, $app);
        $this->assertTrue($client->updateSignature('提供好玩的服务。'));
    }

    protected function readMockResponseJson(string $filename): string
    {
        return file_get_contents(__DIR__ . '/mock_data/' . $filename);
    }
}
