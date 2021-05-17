<?php

namespace EasySwoole\WeChat\Tests\OfficialAccount\Broadcasting;

use EasySwoole\WeChat\Kernel\Exceptions\RuntimeException;
use EasySwoole\WeChat\Kernel\Messages\Text;
use EasySwoole\WeChat\Kernel\ServiceContainer;
use EasySwoole\WeChat\OfficialAccount\Broadcasting\Client;
use EasySwoole\WeChat\Tests\Mock\Message\Status;
use EasySwoole\WeChat\Tests\TestCase;
use Psr\Http\Message\ServerRequestInterface;

class ClientTest extends TestCase
{
    public function testSend()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('send.json'));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/message/mass/sendall', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        // to all
        $message = [
            'filter' => [
                'is_to_all' => true,
                'tag_id' => 2,
            ],
            'text' => [
                'content' => 'CONTENT'
            ],
            'msgtype' => 'text'
        ];
        $this->assertIsArray($client->send($message));
        $this->assertEquals(json_decode($this->readMockResponseJson('send.json'), true), $client->send($message));

        // to tag
        $message = [
            'filter' => [
                'is_to_all' => false,
                'tag_id' => 2,
            ],
            'text' => [
                'content' => 'CONTENT'
            ],
            'msgtype' => 'text'
        ];
        $this->assertIsArray($client->send($message));
        $this->assertEquals(json_decode($this->readMockResponseJson('send.json'), true), $client->send($message));
    }

    // send to user
    public function testSend1()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('send.json'));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/message/mass/send', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        // to user
        $message = [
            'touser' => ['OPENID1', 'OPENID2'],
            'msgtype' => 'text',
            'text' => [
                'content' => 'hello from boxer.',
            ],
        ];
        $this->assertIsArray($client->send($message));
        $this->assertEquals(json_decode($this->readMockResponseJson('send.json'), true), $client->send($message));

        // exception
        $this->expectException(RuntimeException::class);
        $this->expectExceptionMessage('The message reception object is not specified');
        $message = [
            'text' => [
                'content' => 'hello from boxer.',
            ],
        ];
        $client->send($message);
    }

    public function testPreview()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('preview.json'));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/message/mass/preview', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        $message = [
            'touser' => 'OPENID',
            'text' => [
                'content' => 'CONTENT'
            ],
            'msgtype' => 'text'
        ];
        $this->assertIsArray($client->preview($message));
        $this->assertEquals(json_decode($this->readMockResponseJson('preview.json'), true), $client->preview($message));
    }

    public function testStatus()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('status.json'));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/message/mass/get', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);
        $this->assertIsArray($client->status('201053012'));
        $this->assertEquals(json_decode($this->readMockResponseJson('status.json'), true), $client->status('201053012'));
    }

    public function testDelete()
    {
        $response = $this->buildResponse(Status::CODE_OK, '{"errcode":0,"errmsg":"ok"}');
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/message/mass/delete', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);
        $this->assertTrue($client->delete('30124', 2));
    }

    public function testSendText()
    {
        // to tag
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('send.json'));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/message/mass/sendall', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);
        $this->assertIsArray($client->sendText('CONTENT', 2));
        $this->assertEquals(json_decode($this->readMockResponseJson('send.json'), true), $client->sendText('CONTENT', 2));

        // to user
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('send.json'));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/message/mass/send', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);
        $this->assertIsArray($client->sendText('CONTENT', ['OPENID1', 'OPENID2']));
        $this->assertEquals(json_decode($this->readMockResponseJson('send.json'), true), $client->sendText('CONTENT', ['OPENID1', 'OPENID2']));
    }

    public function testSendNews()
    {
        // to tag
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('send.json'));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/message/mass/sendall', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);
        $this->assertIsArray($client->sendNews('123dsdajkasd231jhksad', 2, [
            'send_ignore_reprint' => 0
        ]));
        $this->assertEquals(json_decode($this->readMockResponseJson('send.json'), true), $client->sendNews('123dsdajkasd231jhksad', 2, [
            'send_ignore_reprint' => 0
        ]));

        // to user
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('send.json'));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/message/mass/send', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);
        $this->assertIsArray($client->sendNews('123dsdajkasd231jhksad', ['OPENID1', 'OPENID2'], [
            'send_ignore_reprint' => 0
        ]));
        $this->assertEquals(json_decode($this->readMockResponseJson('send.json'), true), $client->sendNews('123dsdajkasd231jhksad', ['OPENID1', 'OPENID2'], [
            'send_ignore_reprint' => 0
        ]));
    }

    public function testSendVoice()
    {
        // to tag
        $mediaId = '123dsdajkasd231jhksad';
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('send.json'));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/message/mass/sendall', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);
        $this->assertIsArray($client->sendVoice($mediaId, 2));
        $this->assertEquals(json_decode($this->readMockResponseJson('send.json'), true), $client->sendVoice($mediaId, 2));

        // to user
        $mediaId = 'mLxl6paC7z2Tl-NJT64yzJve8T9c8u9K2x-Ai6Ujd4lIH9IBuF6-2r66mamn_gIT';
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('send.json'));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/message/mass/send', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);
        $this->assertIsArray($client->sendVoice($mediaId, ['OPENID1', 'OPENID2']));
        $this->assertEquals(json_decode($this->readMockResponseJson('send.json'), true), $client->sendVoice($mediaId, ['OPENID1', 'OPENID2']));
    }

    public function testSendImage()
    {
        // to tag
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('send.json'));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/message/mass/sendall', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);
        $client = new Client($app);
        $this->assertIsArray($client->sendImage('mock_mediaId', 2));
        $this->assertEquals(json_decode($this->readMockResponseJson('send.json'), true), $client->sendImage('mock_mediaId', 2));

        // to user
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('send.json'));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/message/mass/send', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);
        $client = new Client($app);
        $this->assertIsArray($client->sendImage('mock_mediaId', ['OPENID1', 'OPENID2']));
        $this->assertEquals(json_decode($this->readMockResponseJson('send.json'), true), $client->sendImage('mock_mediaId', ['OPENID1', 'OPENID2']));
    }

    public function testSendImages()
    {
        // to tag
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('send.json'));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/message/mass/sendall', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);
        $mediaIds = [
            'aaa',
            'bbb',
            'ccc'
        ];
        $extraParams = [
            'recomand' => 'xxx',
            'need_open_comment' => 1,
            'only_fans_can_comment' => 0
        ];
        $this->assertIsArray($client->sendImages($mediaIds, 2, [], $extraParams));
        $this->assertEquals(json_decode($this->readMockResponseJson('send.json'), true), $client->sendImages($mediaIds, 2, [], $extraParams));

        // to user
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('send.json'));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/message/mass/send', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);
        $mediaIds = [
            'aaa',
            'bbb',
            'ccc'
        ];
        $extraParams = [
            'recomand' => 'xxx',
            'need_open_comment' => 1,
            'only_fans_can_comment' => 0
        ];
        $this->assertIsArray($client->sendImages($mediaIds, ['OPENID1', 'OPENID2'], [], $extraParams));
        $this->assertEquals(json_decode($this->readMockResponseJson('send.json'), true), $client->sendImages($mediaIds, ['OPENID1', 'OPENID2'], [], $extraParams));
    }

    public function testSendVideo()
    {
        // to tag
        $mediaId = '123dsdajkasd231jhksad';
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('send.json'));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/message/mass/sendall', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);
        $this->assertIsArray($client->sendVoice($mediaId, 2));
        $this->assertEquals(json_decode($this->readMockResponseJson('send.json'), true), $client->sendVoice($mediaId, 2));

        // to user
        $mediaId = 'IhdaAQXuvJtGzwwc0abfXnzeezfO0NgPK6AQYShD8RQYMTtfzbLdBIQkQziv2XJc';
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('send.json'));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/message/mass/send', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);
        $this->assertIsArray($client->sendVoice($mediaId, ['OPENID1', 'OPENID2']));
        $this->assertEquals(json_decode($this->readMockResponseJson('send.json'), true), $client->sendVoice($mediaId, ['OPENID1', 'OPENID2']));
    }

    public function testSendCard()
    {
        $cardId = '123dsdajkasd231jhksad';
        // to tag
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('send.json'));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/message/mass/sendall', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);
        $this->assertIsArray($client->sendCard($cardId, 2));
        $this->assertEquals(json_decode($this->readMockResponseJson('send.json'), true), $client->sendCard($cardId, 2));

        // to user
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('send.json'));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/message/mass/send', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);
        $this->assertIsArray($client->sendCard($cardId, ['OPENID1', 'OPENID2']));
        $this->assertEquals(json_decode($this->readMockResponseJson('send.json'), true), $client->sendCard($cardId, ['OPENID1', 'OPENID2']));
    }

    public function testPreviewText()
    {
        // to openid
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('preview.json'));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/message/mass/preview', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);
        $client = new Client($app);
        $ret = $client->previewText('CONTENT', 'OPENID');
        $this->assertIsArray($ret);
        $this->assertEquals(json_decode($this->readMockResponseJson('preview.json'), true), $ret);

        // to wxname
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('preview.json'));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/message/mass/preview', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);
        $client = new Client($app);
        $ret = $client->previewText('CONTENT', '示例的微信号', Client::PREVIEW_BY_NAME);
        $this->assertIsArray($ret);
        $this->assertEquals(json_decode($this->readMockResponseJson('preview.json'), true), $ret);
    }

    public function testPreviewNews()
    {
        // to openid
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('preview.json'));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/message/mass/preview', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);
        $client = new Client($app);
        $ret = $client->previewNews('123dsdajkasd231jhksad', 'OPENID');
        $this->assertIsArray($ret);
        $this->assertEquals(json_decode($this->readMockResponseJson('preview.json'), true), $ret);

        // to wxname
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('preview.json'));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/message/mass/preview', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);
        $client = new Client($app);
        $ret = $client->previewNews('123dsdajkasd231jhksad', '示例的微信号', Client::PREVIEW_BY_NAME);
        $this->assertIsArray($ret);
        $this->assertEquals(json_decode($this->readMockResponseJson('preview.json'), true), $ret);
    }

    public function testPreviewVoice()
    {
        // to openid
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('preview.json'));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/message/mass/preview', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);
        $client = new Client($app);
        $ret = $client->previewVoice('123dsdajkasd231jhksad', 'OPENID');
        $this->assertIsArray($ret);
        $this->assertEquals(json_decode($this->readMockResponseJson('preview.json'), true), $ret);

        // to wxname
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('preview.json'));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/message/mass/preview', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);
        $client = new Client($app);
        $ret = $client->previewVoice('123dsdajkasd231jhksad', '示例的微信号', Client::PREVIEW_BY_NAME);
        $this->assertIsArray($ret);
        $this->assertEquals(json_decode($this->readMockResponseJson('preview.json'), true), $ret);
    }

    public function testPreviewImage()
    {
        // to openid
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('preview.json'));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/message/mass/preview', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);
        $client = new Client($app);
        $ret = $client->previewImage('123dsdajkasd231jhksad', 'OPENID');
        $this->assertIsArray($ret);
        $this->assertEquals(json_decode($this->readMockResponseJson('preview.json'), true), $ret);

        // to wxname
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('preview.json'));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/message/mass/preview', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);
        $client = new Client($app);
        $ret = $client->previewVoice('123dsdajkasd231jhksad', '示例的微信号', Client::PREVIEW_BY_NAME);
        $this->assertIsArray($ret);
        $this->assertEquals(json_decode($this->readMockResponseJson('preview.json'), true), $ret);
    }

    public function testPreviewVideo()
    {
        // to openid
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('preview.json'));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/message/mass/preview', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);
        $client = new Client($app);
        $ret = $client->previewVideo('IhdaAQXuvJtGzwwc0abfXnzeezfO0NgPK6AQYShD8RQYMTtfzbLdBIQkQziv2XJc', 'OPENID');
        $this->assertIsArray($ret);
        $this->assertEquals(json_decode($this->readMockResponseJson('preview.json'), true), $ret);

        // to wxname
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('preview.json'));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/message/mass/preview', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);
        $client = new Client($app);
        $ret = $client->previewVideo('IhdaAQXuvJtGzwwc0abfXnzeezfO0NgPK6AQYShD8RQYMTtfzbLdBIQkQziv2XJc', '示例的微信号', Client::PREVIEW_BY_NAME);
        $this->assertIsArray($ret);
        $this->assertEquals(json_decode($this->readMockResponseJson('preview.json'), true), $ret);
    }

    public function testPreviewCard1()
    {
        // to openid
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('preview.json'));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/message/mass/preview', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);
        $client = new Client($app);
        $ret = $client->previewCard('123dsdajkasd231jhksad', 'OPENID');
        $this->assertIsArray($ret);
        $this->assertEquals(json_decode($this->readMockResponseJson('preview.json'), true), $ret);

        // to wxname
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('preview.json'));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/message/mass/preview', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);
        $client = new Client($app);
        $ret = $client->previewCard('123dsdajkasd231jhksad', '示例的微信号', Client::PREVIEW_BY_NAME);
        $this->assertIsArray($ret);
        $this->assertEquals(json_decode($this->readMockResponseJson('preview.json'), true), $ret);
    }

    public function testPreviewCard2()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('preview.json'));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/message/mass/preview', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);
        $client = new Client($app);
        $ret = $client->preview([
            'touser' => 'OPENID',
            'wxcard' => [
                'card_id' => '123dsdajkasd231jhksad',
                'card_ext' => json_encode([
                    'code' => '',
                    'openid' => '',
                    'timestamp' => '1402057159',
                    'signature' => '017bb17407c8e0058a66d72dcc61632b70f511ad'
                ])
            ],
            'msgtype' => 'wxcard'
        ]);
        $this->assertIsArray($ret);
        $this->assertEquals(json_decode($this->readMockResponseJson('preview.json'), true), $ret);
    }

    public function testPreviewNews2()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('preview.json'));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/message/mass/preview', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);
        $client = new Client($app);
        $ret = $client->preview([
            'touser' => '示例的微信号',
            'wxcard' => [
                'media_id' => '123dsdajkasd231jhksad',
            ],
            'msgtype' => 'mpnews'
        ]);
        $this->assertIsArray($ret);
        $this->assertEquals(json_decode($this->readMockResponseJson('preview.json'), true), $ret);
    }

    public function testPreviewMessage()
    {
        // to openid
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('preview.json'));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/message/mass/preview', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);
        $client = new Client($app);
        $ret = $client->previewText('CONTENT', 'OPENID1');
        $this->assertIsArray($ret);
        $this->assertEquals(json_decode($this->readMockResponseJson('preview.json'), true), $ret);

        // to wxname
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('preview.json'));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/message/mass/preview', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);
        $client = new Client($app);
        $ret = $client->previewText('CONTENT', '示例的微信号', Client::PREVIEW_BY_NAME);
        $this->assertIsArray($ret);
        $this->assertEquals(json_decode($this->readMockResponseJson('preview.json'), true), $ret);
    }

    public function testSendMessage()
    {
        // to tag id
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('send.json'));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/message/mass/sendall', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);
        $client = new Client($app);
        $text = new Text('CONTENT');
        $ret = $client->sendMessage($text, 1);
        $this->assertIsArray($ret);
        $this->assertEquals(json_decode($this->readMockResponseJson('send.json'), true), $ret);

        // to all
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('send.json'));
        $app = $this->mockAccessToken(new ServiceContainer(['appId' => '123456']));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/message/mass/send', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);
        $client = new Client($app);
        $text = new Text('CONTENT');
        $ret = $client->sendMessage($text, ['OPENID1', 'OPENID2']);
        $this->assertIsArray($ret);
        $this->assertEquals(json_decode($this->readMockResponseJson('send.json'), true), $ret);
    }

    protected function readMockResponseJson(string $file): string
    {
        return file_get_contents(dirname(__FILE__) . '/mock_data/' . $file);
    }
}
