<?php
/**
 * Created by PhpStorm.
 * User: XueSi
 * Email: <1592328848@qq.com>
 * Date: 2021/4/26
 * Time: 23:19
 */

namespace EasySwoole\WeChat\Tests\Work\GroupRobot;


use EasySwoole\WeChat\Kernel\ServiceContainer;
use EasySwoole\WeChat\Tests\Mock\Message\Status;
use EasySwoole\WeChat\Tests\TestCase;
use EasySwoole\WeChat\Work\GroupRobot\Client;
use EasySwoole\WeChat\Work\GroupRobot\Messages\Text;
use EasySwoole\WeChat\Work\GroupRobot\Messenger;
use Psr\Http\Message\ServerRequestInterface;

class ClientTest extends TestCase
{
    public function testMessage()
    {
        $app = $this->mockAccessToken(new ServiceContainer([
            'corpId' => 'mock_corpId',
            'corpSecret' => 'mock_corpSecret',
        ]));

        $client = new Client($app);

        $this->assertInstanceOf(Messenger::class, $client->message('hello'));
    }

    public function testSend()
    {
        $response = $this->buildResponse(Status::CODE_OK, '{"errcode":0,"errmsg":""}');
        $app = $this->mockAccessToken(new ServiceContainer([
            'corpId' => 'mock_corpId',
            'corpSecret' => 'mock_corpSecret',
        ]));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/webhook/send', $request->getUri()->getPath());
            $this->assertEquals('key=mock_key', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        $message = new Text('hello world');

        $this->assertIsArray($client->send('mock_key',
            $message->transformForJsonRequest()
        ));

        $this->assertSame(json_decode('{"errcode":0,"errmsg":""}', true), $client->send('mock_key', [
            'msgtype' => 'text',
            'text' => [
                'content' => 'hello world'
            ]
        ]));
    }

    public function testUploadMedia()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('uploadMedia.json'));

        $app = $this->mockAccessToken(new ServiceContainer([
            'corpId' => 'mock_corpId',
            'corpSecret' => 'mock_corpSecret',
        ]));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/webhook/upload_media', $request->getUri()->getPath());
            $this->assertEquals('key=mock_key&type=file', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        $this->assertIsArray($client->uploadMedia(
            __DIR__ . '/mock_data/MEDIA_ID.jpg',
            'mock_key',
            [
                'Content-Disposition' =>
                    'form-data; name="media";filename="wework.txt"; filelength=6'
            ]
        ));

        $this->assertSame(json_decode($this->readMockResponseJson('uploadMedia.json'), true), $client->uploadMedia(
            __DIR__ . '/mock_data/MEDIA_ID.jpg',
            'mock_key',
            [
                'Content-Disposition' =>
                    'form-data; name="media";filename="wework.txt"; filelength=6'
            ]
        ));
    }

    protected function readMockResponseJson(string $filename): string
    {
        return file_get_contents(__DIR__ . '/mock_data/' . $filename);
    }
}