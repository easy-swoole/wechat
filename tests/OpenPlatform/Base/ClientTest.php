<?php
/**
 * Created by PhpStorm.
 * User: XueSi
 * Email: <1592328848@qq.com>
 * Date: 2021/5/2
 * Time: 1:27
 */

namespace EasySwoole\WeChat\Tests\OpenPlatform\Base;

use EasySwoole\WeChat\Kernel\ServiceContainer;
use EasySwoole\WeChat\Tests\Mock\Message\Status;
use EasySwoole\WeChat\Tests\TestCase;
use Psr\Http\Message\ServerRequestInterface;
use EasySwoole\WeChat\OpenPlatform\Base\Client;

class ClientTest extends TestCase
{
    public function testCreatePreAuthorizationCode()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('createPreAuthorizationCode.json'));

        $app = $this->mockAccessToken(new ServiceContainer(['appId' => 'mock-appId']));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/component/api_create_preauthcode', $request->getUri()->getPath());
            $this->assertEquals('component_access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        $this->assertIsArray($client->createPreAuthorizationCode());

        $this->assertSame(json_decode($this->readMockResponseJson('createPreAuthorizationCode.json'), true), $client->createPreAuthorizationCode());
    }

    // Test getPreAuthorizationUrl
    public function testGetPreAuthorizationUrl()
    {
        $response = $this->buildResponse(Status::CODE_OK, '{"errcode":0,"errmsg":""}');

        $app = $this->mockAccessToken(new ServiceContainer(['appId' => 'mock-componentAppId']));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
        }, $response, $app);

        $client = new Client($app);

        $mockPreAuthCode = 'Cx_Dk6qiBE0Dmx4EmlT3oRfArPvwSQ-oa3NL_fwHM7VI08r52wazoZX2Rhpz1dEw';

        $this->assertSame(
            'https://mp.weixin.qq.com/cgi-bin/componentloginpage?pre_auth_code=Cx_Dk6qiBE0Dmx4EmlT3oRfArPvwSQ-oa3NL_fwHM7VI08r52wazoZX2Rhpz1dEw&component_appid=mock-componentAppId&redirect_uri=https%3A%2F%2Feasyswoole.wechat.com%2Fcallback',
            $client->getPreAuthorizationUrl('https://easyswoole.wechat.com/callback', $mockPreAuthCode));
    }

    // Test getMobilePreAuthorizationUrl
    public function testGetMobilePreAuthorizationUrl()
    {
        $response = $this->buildResponse(Status::CODE_OK, '{"errcode":0,"errmsg":""}');

        $app = $this->mockAccessToken(new ServiceContainer(['appId' => 'mock-componentAppId']));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
        }, $response, $app);

        $client = new Client($app);

        $mockPreAuthCode = 'Cx_Dk6qiBE0Dmx4EmlT3oRfArPvwSQ-oa3NL_fwHM7VI08r52wazoZX2Rhpz1dEw';

        $this->assertSame(
            'https://mp.weixin.qq.com/safe/bindcomponent?auth_type=3&pre_auth_code=Cx_Dk6qiBE0Dmx4EmlT3oRfArPvwSQ-oa3NL_fwHM7VI08r52wazoZX2Rhpz1dEw&component_appid=mock-componentAppId&redirect_uri=https%3A%2F%2Feasyswoole.wechat.com%2Fcallback&action=bindcomponent&no_scan=1#wechat_redirect',
            $client->getMobilePreAuthorizationUrl('https://easyswoole.wechat.com/callback', $mockPreAuthCode));
    }

    public function testHandleAuthorize()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('handleAuthorize.json'));

        $app = $this->mockAccessToken(new ServiceContainer(['appId' => 'mock-componentAppId']));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/component/api_query_auth', $request->getUri()->getPath());
            $this->assertEquals('component_access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        $mockAuthCode = 'auth_code_value';

        $this->assertIsArray($client->handleAuthorize($mockAuthCode));

        $this->assertSame(
            json_decode($this->readMockResponseJson('handleAuthorize.json'), true),
            $client->handleAuthorize($mockAuthCode));
    }

    public function testGetAuthorizerOfOfficialAccount()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('getAuthorizerOfOfficialAccount.json'));

        $app = $this->mockAccessToken(new ServiceContainer(['appId' => 'mock-componentAppId']));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/component/api_get_authorizer_info', $request->getUri()->getPath());
            $this->assertEquals('component_access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        $authorizerAppId = 'mock-officialAccount_auth_appid_value';

        $this->assertIsArray($client->getAuthorizer($authorizerAppId));

        $this->assertSame(
            json_decode($this->readMockResponseJson('getAuthorizerOfOfficialAccount.json'), true),
            $client->getAuthorizer($authorizerAppId));

    }

    public function testGetAuthorizerOfMiniProgram()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('getAuthorizerOfMiniProgram.json'));

        $app = $this->mockAccessToken(new ServiceContainer(['appId' => 'mock-componentAppId']));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/component/api_get_authorizer_info', $request->getUri()->getPath());
            $this->assertEquals('component_access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        $authorizerAppId = 'mock-MiniProgram_auth_appid_value';

        $this->assertIsArray($client->getAuthorizer($authorizerAppId));

        $this->assertSame(
            json_decode($this->readMockResponseJson('getAuthorizerOfMiniProgram.json'), true),
            $client->getAuthorizer($authorizerAppId));

    }

    public function testGetAuthorizerOption()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('getAuthorizerOption.json'));

        $app = $this->mockAccessToken(new ServiceContainer(['appId' => 'mock-componentAppId']));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/component/api_get_authorizer_option', $request->getUri()->getPath());
            $this->assertEquals('component_access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        $this->assertIsArray($client->getAuthorizerOption('wx7bc5ba58cabd00f4', 'voice_recognize'));

        $this->assertSame(
            json_decode($this->readMockResponseJson('getAuthorizerOption.json'), true),
            $client->getAuthorizerOption('wx7bc5ba58cabd00f4', 'voice_recognize'));
    }

    public function testSetAuthorizerOption()
    {
        $response = $this->buildResponse(Status::CODE_OK, '{"errcode":0,"errmsg":""}');

        $app = $this->mockAccessToken(new ServiceContainer(['appId' => 'mock-componentAppId']));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/component/api_set_authorizer_option', $request->getUri()->getPath());
            $this->assertEquals('component_access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        $this->assertTrue($client->setAuthorizerOption('mock-authorizer_appid', 'option_name_value', 'option_value_value'));
    }

    public function testGetAuthorizers()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('getAuthorizers.json'));

        $app = $this->mockAccessToken(new ServiceContainer(['appId' => 'mock-componentAppId']));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/component/api_get_authorizer_list', $request->getUri()->getPath());
            $this->assertEquals('component_access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        $this->assertIsArray($client->getAuthorizers(0, 100));

        $this->assertSame(
            json_decode($this->readMockResponseJson('getAuthorizers.json'), true),
            $client->getAuthorizers(0, 100));

    }

    public function testClearQuota()
    {
        $response = $this->buildResponse(Status::CODE_OK, '{"errcode":0,"errmsg":""}');

        $app = $this->mockAccessToken(new ServiceContainer(['appId' => 'mock-componentAppId']));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/component/clear_quota', $request->getUri()->getPath());
            $this->assertEquals('component_access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        $this->assertTrue($client->clearQuota());
    }

    protected function readMockResponseJson(string $file): string
    {
        return file_get_contents(dirname(__FILE__) . '/mock_data/' . $file);
    }
}