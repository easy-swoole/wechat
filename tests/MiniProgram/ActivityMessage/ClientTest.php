<?php
/**
 * Created by PhpStorm.
 * User: XueSi
 * Email: <1592328848@qq.com>
 * Date: 2021/5/5
 * Time: 14:26
 */

namespace EasySwoole\WeChat\Tests\MiniProgram\ActivityMessage;


use EasySwoole\WeChat\Kernel\Exceptions\InvalidArgumentException;
use EasySwoole\WeChat\Kernel\ServiceContainer;
use EasySwoole\WeChat\Tests\Mock\Message\Status;
use EasySwoole\WeChat\Tests\TestCase;
use EasySwoole\WeChat\MiniProgram\ActivityMessage\Client;
use Psr\Http\Message\ServerRequestInterface;

class ClientTest extends TestCase
{
    public function testCreateActivityId()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('createActivityId.json'));

        $app = $this->mockAccessToken(new ServiceContainer([
            'appId' => 'mock_appid',
            'appSecret' => 'mock_secret'
        ]));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('GET', $request->getMethod());
            $this->assertEquals('/cgi-bin/message/wxopen/activityid/create', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        $this->assertIsArray($client->createActivityId());

        $this->assertEquals(json_decode($this->readMockResponseJson('createActivityId.json'), true), $client->createActivityId());
    }

    public function testUpdateMessageWithInvalidState()
    {
        $response = $this->buildResponse(Status::CODE_OK, '{"errcode":0,"errmsg":""}');

        $app = $this->mockAccessToken(new ServiceContainer([
            'appId' => 'mock_appid',
            'appSecret' => 'mock_secret'
        ]));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/message/wxopen/updatablemsg/send', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('"state" should be "0" or "1".');
        $this->assertTrue($client->updateMessage('mock_activity-id', 666));
    }

    public function testUpdateMessage()
    {
        $response = $this->buildResponse(Status::CODE_OK, '{"errcode":0,"errmsg":""}');

        $app = $this->mockAccessToken(new ServiceContainer([
            'appId' => 'mock_appid',
            'appSecret' => 'mock_secret'
        ]));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/message/wxopen/updatablemsg/send', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        $this->assertTrue($client->updateMessage('mock-activity-id', 0, [
            'member_count' => 'mock-member-count',
            'room_limit' => 'mock-room-limit',
            'path' => 'mock-path',
            'version_type' => 'develop',
            'foo' => 'bar',
        ]));

        // invalid version type
        $this->expectException(InvalidArgumentException::class);
        $this->expectExceptionMessage('Invalid value of attribute "version_type".');
        $this->assertTrue($client->updateMessage('mock_activity-id', 0, [
            'member_count' => 'mock-member-count',
            'room_limit' => 'mock-room-limit',
            'path' => 'mock-path',
            'version_type' => 'mock-version-type',
            'foo' => 'bar',
        ]));
    }

    /**
     * @return string
     */
    private function readMockResponseJson($filename): string
    {
        return file_get_contents(__DIR__ . '/mock_data/' . $filename);
    }
}