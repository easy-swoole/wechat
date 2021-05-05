<?php
/**
 * Created by PhpStorm.
 * User: XueSi
 * Email: <1592328848@qq.com>
 * Date: 2021/5/5
 * Time: 21:55
 */

namespace EasySwoole\WeChat\Tests\MiniProgram\SubscribeMessage;

use EasySwoole\WeChat\Kernel\Exceptions\InvalidArgumentException;
use EasySwoole\WeChat\Kernel\ServiceContainer;
use EasySwoole\WeChat\Tests\Mock\Message\Status;
use EasySwoole\WeChat\Tests\TestCase;
use Psr\Http\Message\ServerRequestInterface;
use EasySwoole\WeChat\MiniProgram\SubscribeMessage\Client;

class ClientTest extends TestCase
{
    public function testSend()
    {
        $response = $this->buildResponse(Status::CODE_OK, '{"errcode":0,"errmsg":""}');

        $app = $this->mockAccessToken(new ServiceContainer([
            'appId' => 'mock_appid',
            'appSecret' => 'mock_secret'
        ]));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/message/subscribe/send', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        // mock without touser
        try {
            $client->send();
        } catch (\Exception $exception) {
            $this->assertInstanceOf(InvalidArgumentException::class, $exception);
            $this->assertSame('Attribute "touser" can not be empty!', $exception->getMessage());
        }

        // mock without template_id
        try {
            $client->send([
                'touser' => 'mock-openid'
            ]);
        } catch (\Exception $exception) {
            $this->assertInstanceOf(InvalidArgumentException::class, $exception);
            $this->assertSame('Attribute "template_id" can not be empty!', $exception->getMessage());
        }

        // mock without data
        try {
            $client->send(['touser' => 'mock-openid', 'template_id' => 'mock-template_id']);
        } catch (\Exception $exception) {
            $this->assertInstanceOf(InvalidArgumentException::class, $exception);
            $this->assertSame('Attribute "data" can not be empty!', $exception->getMessage());
        }

        $this->assertTrue($client->send([
            'touser' => 'OPENID',
            'template_id' => 'TEMPLATE_ID',
            'page' => 'index',
            'miniprogram_state' => 'developer',
            'lang' => 'zh_CN',
            'data' => [
                'number01' => [
                    'value' => '339208499',
                ],
                'date01' => [
                    'value' => '2015年01月05日',
                ],
                'site01' => [
                    'value' => 'TIT创意园',
                ],
                'site02' => [
                    'value' => '广州市新港中路397号',
                ],
            ],
        ]));
    }

    public function testAddTemplate()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('addTemplate.json'));

        $app = $this->mockAccessToken(new ServiceContainer([
            'appId' => 'mock_appid',
            'appSecret' => 'mock_secret'
        ]));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/wxaapi/newtmpl/addtemplate', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        $this->assertIsArray($client->addTemplate(401, [1, 2], '测试数据'));

        $this->assertSame(json_decode($this->readMockResponseJson('addTemplate.json'), true), $client->addTemplate(401, [1, 2], '测试数据'));
    }

    public function testDeleteTemplate()
    {
        $response = $this->buildResponse(Status::CODE_OK, '{"errcode":0,"errmsg":""}');

        $app = $this->mockAccessToken(new ServiceContainer([
            'appId' => 'mock_appid',
            'appSecret' => 'mock_secret'
        ]));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/wxaapi/newtmpl/deltemplate', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        $this->assertTrue($client->deleteTemplate('wDYzYZVxobJivW9oMpSCpuvACOfJXQIoKUm0PY397Tc'));
    }

    public function testGetCategory()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('getCategory.json'));

        $app = $this->mockAccessToken(new ServiceContainer([
            'appId' => 'mock_appid',
            'appSecret' => 'mock_secret'
        ]));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('GET', $request->getMethod());
            $this->assertEquals('/wxaapi/newtmpl/getcategory', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        $this->assertIsArray($client->getCategory());

        $this->assertSame(json_decode($this->readMockResponseJson('getCategory.json'), true), $client->getCategory());
    }

    public function testGetTemplateKeywords()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('getTemplateKeywords.json'));

        $app = $this->mockAccessToken(new ServiceContainer([
            'appId' => 'mock_appid',
            'appSecret' => 'mock_secret'
        ]));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('GET', $request->getMethod());
            $this->assertEquals('/wxaapi/newtmpl/getpubtemplatekeywords', $request->getUri()->getPath());
            $this->assertEquals('tid=99&access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        $this->assertIsArray($client->getTemplateKeywords(99));

        $this->assertSame(json_decode($this->readMockResponseJson('getTemplateKeywords.json'), true), $client->getTemplateKeywords(99));
    }

    public function testGetTemplateTitles()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('getTemplateTitles.json'));

        $app = $this->mockAccessToken(new ServiceContainer([
            'appId' => 'mock_appid',
            'appSecret' => 'mock_secret'
        ]));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('GET', $request->getMethod());
            $this->assertEquals('/wxaapi/newtmpl/getpubtemplatetitles', $request->getUri()->getPath());
            $this->assertEquals('ids=2%2C616&start=0&limit=1&access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        $this->assertIsArray($client->getTemplateTitles([2, 616], 0, 1));

        $this->assertSame(json_decode($this->readMockResponseJson('getTemplateTitles.json'), true), $client->getTemplateTitles([2, 616], 0, 1));
    }

    public function testGetTemplates()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('getTemplates.json'));

        $app = $this->mockAccessToken(new ServiceContainer([
            'appId' => 'mock_appid',
            'appSecret' => 'mock_secret'
        ]));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('GET', $request->getMethod());
            $this->assertEquals('/wxaapi/newtmpl/gettemplate', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        $this->assertIsArray($client->getTemplates());

        $this->assertSame(json_decode($this->readMockResponseJson('getTemplates.json'), true), $client->getTemplates());
    }

    private function readMockResponseJson($filename)
    {
        return file_get_contents(__DIR__ . '/mock_data/' . $filename);
    }
}