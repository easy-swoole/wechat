<?php
/**
 * Created by PhpStorm.
 * User: XueSi
 * Email: <1592328848@qq.com>
 * Date: 2021/5/5
 * Time: 19:58
 */

namespace EasySwoole\WeChat\Tests\MiniProgram\RiskControl;

use EasySwoole\WeChat\Kernel\ServiceContainer;
use EasySwoole\WeChat\Tests\Mock\Message\Status;
use EasySwoole\WeChat\Tests\TestCase;
use Psr\Http\Message\ServerRequestInterface;
use EasySwoole\WeChat\MiniProgram\RiskControl\Client;

class ClientTest extends TestCase
{
    public function testGetUserRiskRank()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('getUserRiskRank.json'));

        $app = $this->mockAccessToken(new ServiceContainer([
            'appId' => 'mock_appid',
            'appSecret' => 'mock_secret'
        ]));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/wxa/getuserriskrank', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        $params = [
            'appid' => 'wx*******',
            'openid' => '*****',
            'scene' => 1,
            'mobile_no' => '12345678',
            'bank_card_no' => '******',
            'cert_no' => '*******',
            'client_ip' => '******',
            'email_address' => '***@qq.com',
            'extended_info' => '',
        ];

        $this->assertIsArray($client->getUserRiskRank($params));

        $this->assertSame(json_decode($this->readMockResponseJson('getUserRiskRank.json'), true), $client->getUserRiskRank($params));
    }

    private function readMockResponseJson($filename)
    {
        return file_get_contents(__DIR__ . '/mock_data/' . $filename);
    }
}