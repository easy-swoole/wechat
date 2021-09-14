<?php
/**
 * User: XueSi
 * Date: 2021/9/14 17:49
 * Author: XueSi <1592328848@qq.com>
 */

namespace EasySwoole\WeChat\Tests\OpenPlatform\Authorizer\MiniProgram\BetaMiniProgram;

use EasySwoole\WeChat\OpenPlatform\Application;
use EasySwoole\WeChat\OpenPlatform\Authorizer\MiniProgram\BetaMiniProgram\Client;
use EasySwoole\WeChat\Tests\Mock\Message\Status;
use EasySwoole\WeChat\Tests\TestCase;
use Psr\Http\Message\ServerRequestInterface;

class ClientTest extends TestCase
{
    public function testVerifyBetaWeapp()
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
            $this->assertEquals('/wxa/verifybetaweapp', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
            $this->assertEquals('{"verify_info":{"enterprise_name":"测试的公司","code":"8585858589999","code_type":3,"legal_persona_wechat":"Melody20136xxxxxx","legal_persona_name":"涂小xxx","component_phone":"158173xxxxx","legal_persona_idcard":"440881199xxxxxx"}}', $request->getBody()->getContents());
        }, $response, $miniProgram);

        $client = new Client($miniProgram);

        $verifyInfo = [
            'enterprise_name' => '测试的公司',
            'code' => '8585858589999',
            'code_type' => 3,
            'legal_persona_wechat' => 'Melody20136xxxxxx',
            'legal_persona_name' => '涂小xxx',
            'component_phone' => '158173xxxxx',
            'legal_persona_idcard' => '440881199xxxxxx'
        ];

        $this->assertTrue($client->verifyBetaWeapp($verifyInfo));
    }

    public function testSetBetaWeappNickname()
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
            $this->assertEquals('/wxa/setbetaweappnickname', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
            $this->assertEquals('{"name":"小麦烤鸡"}', $request->getBody()->getContents());
        }, $response, $miniProgram);

        $client = new Client($miniProgram);

        $this->assertTrue($client->setBetaWeappNickname('小麦烤鸡'));
    }

    public function testGetMpAdminAuth()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('getMpAdminAuth.json'));

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
            $this->assertEquals('/wxa/getmpadminauth', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
            $this->assertEquals('{"mp_appid":"wxxxxxxdre3f","same_admin":0}', $request->getBody()->getContents());
        }, $response, $miniProgram);

        $client = new Client($miniProgram);

        $ret = $client->getMpAdminAuth('wxxxxxxdre3f', 0);

        $this->assertIsArray($ret);

        $this->assertSame(json_decode($this->readMockResponseJson('getMpAdminAuth.json'), true), $ret);
    }

    public function testMpVerifyBetaWeapp()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('mpVerifyBetaWeapp.json'));

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
            $this->assertEquals('/wxa/mpverifybetaweapp', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
            $this->assertEquals('{"mp_appid":"wxxxxxxdre3f","ticket":"xxxxxxxxxxxx"}', $request->getBody()->getContents());
        }, $response, $miniProgram);

        $client = new Client($miniProgram);

        $ret = $client->mpVerifyBetaWeapp('wxxxxxxdre3f', 'xxxxxxxxxxxx');

        $this->assertIsArray($ret);

        $this->assertSame(json_decode($this->readMockResponseJson('mpVerifyBetaWeapp.json'), true), $ret);
    }

    protected function readMockResponseJson(string $filename): string
    {
        return file_get_contents(__DIR__ . '/mock_data/' . $filename);
    }
}
