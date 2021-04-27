<?php
/**
 * Created by PhpStorm.
 * User: XueSi
 * Email: <1592328848@qq.com>
 * Date: 2021/4/25
 * Time: 0:23
 */

namespace EasySwoole\WeChat\Tests\Work\Media;


use EasySwoole\WeChat\Kernel\Exceptions\HttpException;
use EasySwoole\WeChat\Kernel\Psr\StreamResponse;
use EasySwoole\WeChat\Kernel\ServiceContainer;
use EasySwoole\WeChat\Tests\Mock\Message\Status;
use EasySwoole\WeChat\Tests\TestCase;
use EasySwoole\WeChat\Work\Media\Client;
use Psr\Http\Message\ServerRequestInterface;

class ClientTest extends TestCase
{
    public function testExpectionGet()
    {
        $response = $this->buildResponse(Status::CODE_OK, '{"errcode":40007,"errmsg":"invalid media_id"}');

        $app = $this->mockAccessToken(new ServiceContainer([
            'corpId' => 'mock_corpId',
            'corpSecret' => 'mock_corpSecret',
        ]));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('GET', $request->getMethod());
            $this->assertEquals('/cgi-bin/media/get', $request->getUri()->getPath());
            $this->assertEquals('media_id=invalid-media-id&access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        try {
            $client->get('invalid-media-id');
        } catch (\Exception $exception) {
            $this->assertInstanceOf(HttpException::class, $exception);
            $this->assertSame('request wechat error, message: (40007) invalid media_id', $exception->getMessage());
        }
    }

    public function testGet()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('MEDIA_ID.jpg'), [
            'Content-disposition' => [
                'attachment',
                'filename="MEDIA_ID.jpg'
            ]
        ]);

        $app = $this->mockAccessToken(new ServiceContainer([
            'corpId' => 'mock_corpId',
            'corpSecret' => 'mock_corpSecret',
        ]));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('GET', $request->getMethod());
            $this->assertEquals('/cgi-bin/media/get', $request->getUri()->getPath());
            $this->assertEquals('media_id=MEDIA_ID&access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        $this->assertInstanceOf(StreamResponse::class, $client->get('MEDIA_ID'));
    }

    public function testUploadImage()
    {
        // mock 无参
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('upload.json'));

        $app = $this->mockAccessToken(new ServiceContainer([
            'corpId' => 'mock_corpId',
            'corpSecret' => 'mock_corpSecret',
        ]));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/media/upload', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token&type=image', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        $this->assertIsArray($client->uploadImage(__DIR__ . '/mock_data/MEDIA_ID.jpg'));

        $this->assertSame(json_decode($this->readMockResponseJson('upload.json'), true), $client->uploadImage(__DIR__ . '/mock_data/MEDIA_ID.jpg'));


        // mock 有参
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('upload.json'));

        $app = $this->mockAccessToken(new ServiceContainer([
            'corpId' => 'mock_corpId',
            'corpSecret' => 'mock_corpSecret',
        ]));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/media/upload', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token&type=image', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        $this->assertIsArray($client->uploadImage(__DIR__ . '/mock_data/MEDIA_ID.jpg', ['filename' => 'MEDIA_ID.jpg']));

        $this->assertSame(json_decode($this->readMockResponseJson('upload.json'), true), $client->uploadImage(__DIR__ . '/mock_data/MEDIA_ID.jpg', ['filename' => 'MEDIA_ID.jpg']));
    }

    public function testUploadVideo()
    {
        // mock 无参
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('upload.json'));

        $app = $this->mockAccessToken(new ServiceContainer([
            'corpId' => 'mock_corpId',
            'corpSecret' => 'mock_corpSecret',
        ]));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/media/upload', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token&type=video', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        $this->assertIsArray($client->uploadVideo(__DIR__ . '/mock_data/test.mp4'));

        $this->assertSame(json_decode($this->readMockResponseJson('upload.json'), true), $client->uploadVideo(__DIR__ . '/mock_data/test.mp4'));


        // mock 有参
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('upload.json'));

        $app = $this->mockAccessToken(new ServiceContainer([
            'corpId' => 'mock_corpId',
            'corpSecret' => 'mock_corpSecret',
        ]));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/media/upload', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token&type=video', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        $this->assertIsArray($client->uploadVideo(__DIR__ . '/mock_data/test.mp4', ['filename' => 'test.mp4']));

        $this->assertSame(json_decode($this->readMockResponseJson('upload.json'), true), $client->uploadVideo(__DIR__ . '/mock_data/test.mp4', ['filename' => 'test.mp4']));
    }

    public function testUploadVoice()
    {
        // mock 无参
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('upload.json'));

        $app = $this->mockAccessToken(new ServiceContainer([
            'corpId' => 'mock_corpId',
            'corpSecret' => 'mock_corpSecret',
        ]));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/media/upload', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token&type=voice', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        $this->assertIsArray($client->uploadVoice(__DIR__ . '/mock_data/test.arm'));

        $this->assertSame(json_decode($this->readMockResponseJson('upload.json'), true), $client->uploadVoice(__DIR__ . '/mock_data/test.arm'));


        // mock 有参
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('upload.json'));

        $app = $this->mockAccessToken(new ServiceContainer([
            'corpId' => 'mock_corpId',
            'corpSecret' => 'mock_corpSecret',
        ]));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/media/upload', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token&type=voice', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        $this->assertIsArray($client->uploadVoice(__DIR__ . '/mock_data/test.mp4', ['filename' => 'test.arm']));

        $this->assertSame(json_decode($this->readMockResponseJson('upload.json'), true), $client->uploadVoice(__DIR__ . '/mock_data/test.arm', ['filename' => 'test.arm']));
    }

    public function testUploadFile()
    {
        // mock 无参
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('upload.json'));

        $app = $this->mockAccessToken(new ServiceContainer([
            'corpId' => 'mock_corpId',
            'corpSecret' => 'mock_corpSecret',
        ]));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/media/upload', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token&type=file', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        $this->assertIsArray($client->uploadFile(__DIR__ . '/mock_data/test.txt'));

        $this->assertSame(json_decode($this->readMockResponseJson('upload.json'), true), $client->uploadFile(__DIR__ . '/mock_data/test.txt'));


        // mock 有参
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('upload.json'));

        $app = $this->mockAccessToken(new ServiceContainer([
            'corpId' => 'mock_corpId',
            'corpSecret' => 'mock_corpSecret',
        ]));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/media/upload', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token&type=file', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        $this->assertIsArray($client->uploadFile(__DIR__ . '/mock_data/test.txt', ['filename' => 'test.txt']));

        $this->assertSame(json_decode($this->readMockResponseJson('upload.json'), true), $client->uploadFile(__DIR__ . '/mock_data/test.txt', ['filename' => 'test.txt']));
    }


    protected function readMockResponseJson(string $filename)
    {
        return file_get_contents(__DIR__ . '/mock_data/' . $filename);
    }
}