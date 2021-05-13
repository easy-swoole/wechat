<?php

namespace EasySwoole\WeChat\Tests\OpenPlatform;

use EasySwoole\WeChat\Kernel\ServiceProviders;
use EasySwoole\WeChat\OpenPlatform\Application;
use EasySwoole\WeChat\OpenPlatform\Authorizer\OfficialAccount\Application as OfficialAccount;
use EasySwoole\WeChat\Tests\Mock\Message\Status;
use EasySwoole\WeChat\Tests\TestCase;
use Psr\Http\Message\ServerRequestInterface;
use EasySwoole\WeChat\OpenPlatform\Base;

class ApplicationTest extends TestCase
{
    public function testProperties()
    {
        $app = new Application([
            'appId' => 'mock_component_appid', // 第三方平台的 appid
            'appSecret' => 'mock_componet_appSecret', // // 第三方平台的 app_secret
        ]);

        $this->assertInstanceOf(\EasySwoole\WeChat\OpenPlatform\Auth\AccessToken::class, $app->accessToken);

        $this->assertInstanceOf(\EasySwoole\WeChat\OpenPlatform\Auth\VerifyTicket::class, $app->verifyTicket);

        $this->assertInstanceOf(\EasySwoole\WeChat\OpenPlatform\Base\Client::class, $app->base);

        $this->assertInstanceOf(\EasySwoole\WeChat\OpenPlatform\CodeTemplate\Client::class, $app->codeTemplate);

        $this->assertInstanceOf(\EasySwoole\WeChat\OpenPlatform\Component\Client::class, $app->component);

        $this->assertInstanceOf(\EasySwoole\WeChat\OpenPlatform\Server\Guard::class, $app->server);
    }

    public function testGetPreAuthorizationUrl()
    {
        $app = new Application([
            'appId' => 'mock_component_appid' // 第三方平台的 appid
        ]);

        $mockPreAuthCode = 'Cx_Dk6qiBE0Dmx4EmlT3oRfArPvwSQ-oa3NL_fwHM7VI08r52wazoZX2Rhpz1dEw';

        $this->assertSame(
            'https://mp.weixin.qq.com/cgi-bin/componentloginpage?pre_auth_code=Cx_Dk6qiBE0Dmx4EmlT3oRfArPvwSQ-oa3NL_fwHM7VI08r52wazoZX2Rhpz1dEw&component_appid=mock_component_appid&redirect_uri=https%3A%2F%2Feasyswoole.wechat.com%2Fcallback',
            $app->getPreAuthorizationUrl('https://easyswoole.wechat.com/callback', $mockPreAuthCode)
        );
    }

    public function testGetMobilePreAuthorizationUrl()
    {
        $app = new Application([
            'appId' => 'mock_component_appid' // 第三方平台的 appid
        ]);

        $mockPreAuthCode = 'Cx_Dk6qiBE0Dmx4EmlT3oRfArPvwSQ-oa3NL_fwHM7VI08r52wazoZX2Rhpz1dEw';

        $this->assertSame(
            'https://mp.weixin.qq.com/safe/bindcomponent?auth_type=3&pre_auth_code=Cx_Dk6qiBE0Dmx4EmlT3oRfArPvwSQ-oa3NL_fwHM7VI08r52wazoZX2Rhpz1dEw&component_appid=mock_component_appid&redirect_uri=https%3A%2F%2Feasyswoole.wechat.com%2Fcallback&action=bindcomponent&no_scan=1#wechat_redirect',
            $app->getMobilePreAuthorizationUrl('https://easyswoole.wechat.com/callback', $mockPreAuthCode)
        );
    }

    public function testOfficialAccount()
    {
        $app = new Application([
            'appId' => 'component-app-id',
            'appSecret' => 'component-secret',
            'token' => 'component-token',
            'aesKey' => 'Qqx2S6jV3mp5prWPg5x3eBmeU1kLayZio4Q9ZxWTbmf'
        ]);

        $officialAccount = $app->officialAccount('mock_app_id', 'mock_refresh_token');

        $this->assertInstanceOf(\EasySwoole\WeChat\OpenPlatform\Authorizer\OfficialAccount\Application::class, $officialAccount);

        $this->assertInstanceOf(\EasySwoole\WeChat\OpenPlatform\Authorizer\Auth\AccessToken::class, $officialAccount[ServiceProviders::AccessToken]);

        $this->assertInstanceOf(\EasySwoole\WeChat\Kernel\Encryptor::class, $officialAccount[ServiceProviders::Encryptor]);

        $this->assertInstanceOf(\EasySwoole\WeChat\OpenPlatform\Authorizer\OfficialAccount\Account\Client::class, $officialAccount[OfficialAccount::Account]);

        $this->assertInstanceOf(\EasySwoole\WeChat\OpenPlatform\Authorizer\OfficialAccount\CallApi\Client::class, $officialAccount[OfficialAccount::CallApi]);

        $this->assertInstanceOf(\EasySwoole\WeChat\OpenPlatform\Authorizer\OfficialAccount\MiniProgram\Client::class, $officialAccount[OfficialAccount::MiniProgram]);

        $this->assertInstanceOf(\EasySwoole\WeChat\OpenPlatform\Authorizer\OfficialAccount\OpenOAuth\Client::class, $officialAccount[OfficialAccount::OpenOAuth]);

        $this->assertSame([
            'appId' => 'mock_app_id',
            'appSecret' => 'component-secret',
            'token' => 'component-token',
            'aesKey' => 'Qqx2S6jV3mp5prWPg5x3eBmeU1kLayZio4Q9ZxWTbmf',
            'componentAppId' => 'component-app-id',
            'componentAppToken' => 'component-token',
            'refreshToken' => 'mock_refresh_token',
        ], $officialAccount->getConfig());
    }

    // 测试公众号本身的 oauth 授权
    public function testOfficialAccountOAuth()
    {
        $app = new Application([
            'appId' => 'component-app-id',
            'appSecret' => 'component-secret',
            'token' => 'component-token',
            'aesKey' => 'Qqx2S6jV3mp5prWPg5x3eBmeU1kLayZio4Q9ZxWTbmf'
        ]);

        $officialAccount = $app->officialAccount('mock_app_id', 'mock_refresh_token');

        $this->assertInstanceOf(\EasySwoole\WeChat\OfficialAccount\OAuth\Client::class, $officialAccount->oauth);
    }

    public function testMiniProgram()
    {
        $app = new Application([
            'appId' => 'component-app-id',
            'appSecret' => 'component-secret',
            'token' => 'component-token',
            'aesKey' => 'Qqx2S6jV3mp5prWPg5x3eBmeU1kLayZio4Q9ZxWTbmf']);

        $miniProgram = $app->miniProgram('mock_app_id', 'mock_refresh-token');

        $this->assertInstanceOf(\EasySwoole\WeChat\MiniProgram\Application::class, $miniProgram);

        $this->assertInstanceOf(\EasySwoole\WeChat\OpenPlatform\Authorizer\Auth\AccessToken::class, $miniProgram->accessToken);

        $this->assertInstanceOf(\EasySwoole\WeChat\MiniProgram\Encryptor::class, $miniProgram->encryptor);

        $this->assertInstanceOf(\EasySwoole\WeChat\OpenPlatform\Authorizer\MiniProgram\Account\Client::class, $miniProgram->account);

        $this->assertInstanceOf(\EasySwoole\WeChat\OpenPlatform\Authorizer\MiniProgram\OpenAuth\Client::class, $miniProgram->openAuth);

        $this->assertInstanceOf(\EasySwoole\WeChat\OpenPlatform\Authorizer\MiniProgram\Code\Client::class, $miniProgram->code);

        $this->assertInstanceOf(\EasySwoole\WeChat\OpenPlatform\Authorizer\MiniProgram\Domain\Client::class, $miniProgram->domain);

        $this->assertInstanceOf(\EasySwoole\WeChat\OpenPlatform\Authorizer\MiniProgram\Material\Client::class, $miniProgram->material);

        $this->assertInstanceOf(\EasySwoole\WeChat\OpenPlatform\Authorizer\MiniProgram\QrCodeJump\Client::class, $miniProgram->qrCodeJump);

        $this->assertInstanceOf(\EasySwoole\WeChat\OpenPlatform\Authorizer\MiniProgram\Setting\Client::class, $miniProgram->setting);

        $this->assertInstanceOf(\EasySwoole\WeChat\OpenPlatform\Authorizer\MiniProgram\Tester\Client::class, $miniProgram->tester);
    }

    // 测试小程序本身的 auth 授权
    public function testMiniProgramAuth()
    {
        $app = new Application([
            'appId' => 'component-app-id',
            'appSecret' => 'component-secret',
            'token' => 'component-token',
            'aesKey' => 'Qqx2S6jV3mp5prWPg5x3eBmeU1kLayZio4Q9ZxWTbmf'
        ]);

        $miniProgram = $app->miniProgram('mock_app_id', 'mock_refresh_token');

        $this->assertInstanceOf(\EasySwoole\WeChat\MiniProgram\Auth\Client::class, $miniProgram->auth);
    }

    public function testDynamicCalls1()
    {
        $app = new Application([
            'appId' => 'component-app-id',
            'appSecret' => 'component-secret',
            'token' => 'component-token',
            'aesKey' => 'Qqx2S6jV3mp5prWPg5x3eBmeU1kLayZio4Q9ZxWTbmf'
        ]);

        $app[Application::Base] = new class()
        {
            public function dummyMethod()
            {
                return 'mock-result';
            }
        };

        $this->assertSame('mock-result', $app->dummyMethod());
    }

    public function testDynamicCalls2()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('createPreAuthorizationCode.json'));

        /** @var Application $app */
        $app = new Application([
            'appId' => 'component-app-id',
            'appSecret' => 'component-secret',
            'token' => 'component-token',
            'aesKey' => 'Qqx2S6jV3mp5prWPg5x3eBmeU1kLayZio4Q9ZxWTbmf'
        ]);

        $app = $this->mockAccessToken($app);

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/component/api_create_preauthcode', $request->getUri()->getPath());
            $this->assertEquals('component_access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        /** @var Base\Client $client */
        $client = $app->base;

        $this->assertIsArray($client->createPreAuthorizationCode());

        $this->assertSame(json_decode($this->readMockResponseJson('createPreAuthorizationCode.json'), true), $client->createPreAuthorizationCode());
    }

    protected function readMockResponseJson(string $file): string
    {
        return file_get_contents(dirname(__FILE__) . '/Base/mock_data/' . $file);
    }
}