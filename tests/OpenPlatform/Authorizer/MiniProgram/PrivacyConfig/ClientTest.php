<?php
/**
 * Created by PhpStorm.
 * User: XueSi <1592328848@qq.com>
 * Date: 2022/5/17
 * Time: 12:26 上午
 */
declare(strict_types=1);

namespace EasySwoole\WeChat\Tests\OpenPlatform\Authorizer\MiniProgram\PrivacyConfig;


use EasySwoole\WeChat\Kernel\BaseClient;
use EasySwoole\WeChat\Kernel\ServiceContainer;
use EasySwoole\WeChat\OpenPlatform\Application;
use EasySwoole\WeChat\OpenPlatform\Authorizer\MiniProgram\PrivacyConfig\Client;
use EasySwoole\WeChat\Tests\Mock\Message\Status;
use EasySwoole\WeChat\Tests\TestCase;
use Psr\Http\Message\ServerRequestInterface;

class ClientTest extends TestCase
{
    public function testSetPrivacySetting()
    {
        $response = $this->buildResponse(Status::CODE_OK, '{"errcode":0,"errmsg":"ok"}');

        /** @var Application $component */
        $component = $this->mockAccessToken(new Application([
            'appId' => 'COMPONENT_APPID',
            'token' => 'COMPONENT_TOKEN'
        ]));

        $miniProgram = $component->miniProgram(
            'mock_app_id', 'mock_refresh_token'
        );
        $miniProgram = $this->mockAccessToken($miniProgram);

        $miniProgram = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/component/setprivacysetting', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $miniProgram);

        $client = new Client($miniProgram);

        $ownerSetting = [
            "contact_email"          => "contact_email",
            "contact_phone"          => "contact_email",
            "contact_qq"             => "contact_qq",
            "contact_weixin"         => "contact_weixin",
            "ext_file_media_id"      => "2113706500236918784",
            "notice_method"          => "notice_method",
            "store_expire_timestamp" => "store_expire_timestamp"
        ];
        $privacyVer = 2;
        $settingList = [
            [
                "privacy_key"  => "privacy_key",
                "privacy_text" => "privacy_text"
            ],
            [
                "privacy_key"  => "privacy_key",
                "privacy_text" => "privacy_text"
            ]
        ];
        $sdkPrivacyInfoList = [
            [
                "sdk_name"     => "测试sdk",
                "sdk_biz_name" => "小麦有限公司",
                "sdk_list"     => [
                    [
                        "privacy_key"  => "头像信息",
                        "privacy_text" => "用来展示你的美貌"
                    ]
                ]
            ]
        ];
        $this->assertTrue($client->setPrivacySetting($ownerSetting, $privacyVer, $settingList, $sdkPrivacyInfoList));
    }

    public function testGetPrivacySetting()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('getPrivacySetting.json'));

        /** @var Application $component */
        $component = $this->mockAccessToken(new Application([
            'appId' => 'COMPONENT_APPID',
            'token' => 'COMPONENT_TOKEN'
        ]));

        $miniProgram = $component->miniProgram(
            'mock_app_id', 'mock_refresh_token'
        );
        $miniProgram = $this->mockAccessToken($miniProgram);

        $miniProgram = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/component/getprivacysetting', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $miniProgram);

        $client = new Client($miniProgram);

        $ret = $client->getPrivacySetting(2);

        $this->assertIsArray($ret);
        $this->assertSame(json_decode($this->readMockResponseJson('getPrivacySetting.json'), true), $ret);
    }

    public function testUploadPrivacyExtFile()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('uploadPrivacyExtFile.json'));

        /** @var Application $component */
        $component = $this->mockAccessToken(new Application([
            'appId' => 'COMPONENT_APPID',
            'token' => 'COMPONENT_TOKEN'
        ]));

        $miniProgram = $component->miniProgram(
            'mock_app_id', 'mock_refresh_token'
        );
        $miniProgram = $this->mockAccessToken($miniProgram);

        $miniProgram = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/component/uploadprivacyextfile', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $miniProgram);

        $client = new Client($miniProgram);

        $ret = $client->uploadPrivacyExtFile(__DIR__ . '/mock_data/melody.txt');

        $this->assertIsArray($ret);
        $this->assertSame(json_decode($this->readMockResponseJson('uploadPrivacyExtFile.json'), true), $ret);
    }

    protected function readMockResponseJson(string $filename): string
    {
        return file_get_contents(__DIR__ . '/mock_data/' . $filename);
    }
}