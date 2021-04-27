<?php
/**
 * Created by PhpStorm.
 * User: XueSi
 * Email: <1592328848@qq.com>
 * Date: 2021/4/24
 * Time: 18:14
 */

namespace EasySwoole\WeChat\Tests\Work\Chat;


use EasySwoole\WeChat\Kernel\ServiceContainer;
use EasySwoole\WeChat\Tests\Mock\Message\Status;
use EasySwoole\WeChat\Tests\TestCase;
use Psr\Http\Message\ServerRequestInterface;
use EasySwoole\WeChat\Work\Chat\Client;

class ClientTest extends TestCase
{
    public function testGet()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('get.json'));
        $app = $this->mockAccessToken(new ServiceContainer([
            'corpId' => 'mock_corpId',
            'corpSecret' => 'mock_corpSecret',
        ]));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('GET', $request->getMethod());
            $this->assertEquals('/cgi-bin/appchat/get', $request->getUri()->getPath());
            $this->assertEquals('chatid=CHATID&access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);
        $this->assertIsArray($client->get('CHATID'));

        $this->assertSame(json_decode($this->readMockResponseJson('get.json'), true), $client->get('CHATID'));

    }

    public function testCreate()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('create.json'));
        $app = $this->mockAccessToken(new ServiceContainer([
            'corpId' => 'mock_corpId',
            'corpSecret' => 'mock_corpSecret',
        ]));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/appchat/create', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $data = [
            'name' => 'NAME',
            'owner' => 'userid1',
            'userlist' => ["userid1", "userid2", "userid3"],
            'chatid' => 'CHATID'
        ];

        $client = new Client($app);
        $this->assertIsArray($client->create($data));
        $this->assertSame(json_decode($this->readMockResponseJson('create.json'), true), $client->create($data));
    }

    public function testUpdate()
    {
        $response = $this->buildResponse(Status::CODE_OK, '{"errcode":0,"errmsg":"ok"}');
        $app = $this->mockAccessToken(new ServiceContainer([
            'corpId' => 'mock_corpId',
            'corpSecret' => 'mock_corpSecret',
        ]));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/appchat/update', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $data = [
            'name' => 'NAME',
            'owner' => 'userid2',
            'add_user_list' => ['userid1', 'userid2', 'userid3'],
            'del_user_list' => ['userid3', 'userid4']
        ];

        $client = new Client($app);
        $this->assertTrue($client->update('CHATID', $data));
    }

    public function testSend()
    {
        $response = $this->buildResponse(Status::CODE_OK, '{"errcode":0,"errmsg":"ok"}');
        $app = $this->mockAccessToken(new ServiceContainer([
            'corpId' => 'mock_corpId',
            'corpSecret' => 'mock_corpSecret',
        ]));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/appchat/send', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $message = [
            'chatid' => 'CHATID',
            'msgtype' => 'text',
            'text' => ['content' => '你的快递已到\n请携带工卡前往邮件中心领取'],
            'safr' => 0
        ];

        $client = new Client($app);
        $this->assertTrue($client->send($message));
    }

    protected function readMockResponseJson(string $filename): string
    {
        return file_get_contents(__DIR__ . '/mock_data/' . $filename);
    }
}