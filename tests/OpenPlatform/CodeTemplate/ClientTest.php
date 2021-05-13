<?php
/**
 * Created by PhpStorm.
 * User: XueSi
 * Email: <1592328848@qq.com>
 * Date: 2021/5/10
 * Time: 1:32
 */

namespace EasySwoole\WeChat\Tests\OpenPlatform\CodeTemplate;


use EasySwoole\WeChat\Kernel\ServiceContainer;
use EasySwoole\WeChat\Tests\Mock\Message\Status;
use EasySwoole\WeChat\Tests\TestCase;
use EasySwoole\WeChat\OpenPlatform\CodeTemplate\Client;
use Psr\Http\Message\ServerRequestInterface;

class ClientTest extends TestCase
{
    public function testGetDrafts()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('getDrafts.json'));

        $app = $this->mockAccessToken(new ServiceContainer(['appId' => 'mock-componentAppId']));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('GET', $request->getMethod());
            $this->assertEquals('/wxa/gettemplatedraftlist', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        $this->assertIsArray($client->getDrafts());

        $this->assertSame(
            json_decode($this->readMockResponseJson('getDrafts.json'), true),
            $client->getDrafts());
    }

    public function testCreateFromDraft()
    {
        $response = $this->buildResponse(Status::CODE_OK, '{"errcode":0,"errmsg":"ok"}');

        $app = $this->mockAccessToken(new ServiceContainer(['appId' => 'mock-componentAppId']));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/wxa/addtotemplate', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        $this->assertTrue($client->createFromDraft(0));
    }

    public function testList()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('list.json'));

        $app = $this->mockAccessToken(new ServiceContainer(['appId' => 'mock-componentAppId']));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('GET', $request->getMethod());
            $this->assertEquals('/wxa/gettemplatelist', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        $this->assertIsArray($client->list());

        $this->assertSame(
            json_decode($this->readMockResponseJson('list.json'), true),
            $client->list());
    }

    public function testDelete()
    {
        $response = $this->buildResponse(Status::CODE_OK, '{"errcode":0,"errmsg":"ok"}');

        $app = $this->mockAccessToken(new ServiceContainer(['appId' => 'mock-componentAppId']));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/wxa/deletetemplate', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        $this->assertTrue($client->delete(0));
    }

    protected function readMockResponseJson(string $file): string
    {
        return file_get_contents(dirname(__FILE__) . '/mock_data/' . $file);
    }
}