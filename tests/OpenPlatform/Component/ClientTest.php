<?php
/**
 * Created by PhpStorm.
 * User: XueSi
 * Email: <1592328848@qq.com>
 * Date: 2021/5/10
 * Time: 1:51
 */

namespace EasySwoole\WeChat\Tests\OpenPlatform\Component;

use EasySwoole\WeChat\Kernel\ServiceContainer;
use EasySwoole\WeChat\Tests\Mock\Message\Status;
use EasySwoole\WeChat\Tests\TestCase;
use EasySwoole\WeChat\OpenPlatform\Component\Client;
use Psr\Http\Message\ServerRequestInterface;

class ClientTest extends TestCase
{
    public function testRegisterMiniProgram()
    {
        $response = $this->buildResponse(Status::CODE_OK, '{"errcode":0,"errmsg":"OK"}');

        $app = $this->mockAccessToken(new ServiceContainer(['appId' => 'mock-componentAppId']));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/component/fastregisterweapp', $request->getUri()->getPath());
            $this->assertEquals('action=create&component_access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        $params = [
            'name' => 'tencent', // 企业名
            'code' => '123', // 企业代码
            'code_type' => 1, // 企业代码类型（1：统一社会信用代码， 2：组织机构代码，3：营业执照注册号）
            'legal_persona_wechat' => '123', // 法人微信
            'legal_persona_name' => 'candy', // 法人姓名
            'component_phone' => '1234567' // 第三方联系电话
        ];

        $this->assertTrue($client->registerMiniProgram($params));
    }

    public function testGetRegistrationStatus()
    {
        $response = $this->buildResponse(Status::CODE_OK, '{"errcode":0,"errmsg":"OK"}');

        $app = $this->mockAccessToken(new ServiceContainer(['appId' => 'mock-componentAppId']));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/component/fastregisterweapp', $request->getUri()->getPath());
            $this->assertEquals('action=search&component_access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        $companyName = 'tencent'; // 企业名
        $legalPersonaWechat = '123'; // 法人微信
        $legalPersonaName = 'candy'; // 法人姓名

        $this->assertTrue($client->getRegistrationStatus($companyName, $legalPersonaWechat, $legalPersonaName));
    }

    public function testRegisterPersonalWeapp()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('registerPersonalWeapp.json'));

        $app = $this->mockAccessToken(new ServiceContainer(['appId' => 'mock-componentAppId']));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/wxa/component/fastregisterpersonalweapp', $request->getUri()->getPath());
            $this->assertEquals('action=create&component_access_token=mock_access_token', $request->getUri()->getQuery());
            $this->assertEquals('{"idname":"tencent","wxuser":"wxidnnn","component_phone":"1234567"}', $request->getBody()->getContents());
        }, $response, $app);

        $client = new Client($app);

        $idName = 'tencent'; // 个人用户名字
        $wxUser = 'wxidnnn'; // 个人用户微信id
        $componentPhone = '1234567'; // 第三方联系电话

        $ret = $client->registerPersonalWeapp($idName, $wxUser, $componentPhone);

        $this->assertIsArray($ret);

        $this->assertSame(json_decode($this->readMockResponseJson('registerPersonalWeapp.json'), true), $ret);
    }

    public function testGetPersonalWeappStatus()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('getPersonalWeappStatus.json'));

        $app = $this->mockAccessToken(new ServiceContainer(['appId' => 'mock-componentAppId']));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/wxa/component/fastregisterpersonalweapp', $request->getUri()->getPath());
            $this->assertEquals('action=query&component_access_token=mock_access_token', $request->getUri()->getQuery());
            $this->assertEquals('{"taskid":"xxxxx"}', $request->getBody()->getContents());
        }, $response, $app);

        $client = new Client($app);

        $ret = $client->getPersonalWeappStatus('xxxxx');

        $this->assertIsArray($ret);

        $this->assertSame(json_decode($this->readMockResponseJson('getPersonalWeappStatus.json'), true), $ret);
    }

    protected function readMockResponseJson(string $file): string
    {
        return file_get_contents(dirname(__FILE__) . '/mock_data/' . $file);
    }
}
