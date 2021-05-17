<?php
/**
 * Created by PhpStorm.
 * User: XueSi
 * Email: <1592328848@qq.com>
 * Date: 2021/5/16
 * Time: 23:31
 */

namespace EasySwoole\WeChat\Tests\OfficialAccount\Material;

use EasySwoole\WeChat\Kernel\Messages\Article;
use EasySwoole\WeChat\Kernel\ServiceContainer;
use EasySwoole\WeChat\Tests\Mock\Message\Status;
use EasySwoole\WeChat\Tests\TestCase;
use EasySwoole\WeChat\OfficialAccount\Material\Client;
use Psr\Http\Message\ServerRequestInterface;

class ClientTest extends TestCase
{
    public function testUploadImage()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('upload.json'));
        $app = $this->mockAccessToken(new ServiceContainer([
            'appId' => 'mock_appId'
        ]));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/material/add_material', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token&type=image', $request->getUri()->getQuery());
        }, $response, $app);
        $client = new Client($app);
        $ret = $client->uploadImage(__DIR__ . '/mock_data/mock_image.jpg');
        $this->assertIsArray($ret);
        $this->assertEquals(json_decode($this->readMockResponseJson('upload.json'), true), $ret);
    }

    public function testUploadVoice()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('upload.json'));
        $app = $this->mockAccessToken(new ServiceContainer([
            'appId' => 'mock_appId'
        ]));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/material/add_material', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token&type=voice', $request->getUri()->getQuery());
        }, $response, $app);
        $client = new Client($app);
        $ret = $client->uploadVoice(__DIR__ . '/mock_data/mock_voice.mp3');
        $this->assertIsArray($ret);
        $this->assertEquals(json_decode($this->readMockResponseJson('upload.json'), true), $ret);
    }


    public function testUploadThumb()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('upload.json'));
        $app = $this->mockAccessToken(new ServiceContainer([
            'appId' => 'mock_appId'
        ]));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/material/add_material', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token&type=thumb', $request->getUri()->getQuery());
        }, $response, $app);
        $client = new Client($app);
        $ret = $client->uploadThumb(__DIR__ . '/mock_data/mock_thumb.jpg');
        $this->assertIsArray($ret);
        $this->assertEquals(json_decode($this->readMockResponseJson('upload.json'), true), $ret);
    }

    public function testUploadVideo()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('upload.json'));
        $app = $this->mockAccessToken(new ServiceContainer([
            'appId' => 'mock_appId'
        ]));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/material/add_material', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token&type=video', $request->getUri()->getQuery());
        }, $response, $app);
        $client = new Client($app);
        $ret = $client->uploadVideo(__DIR__ . '/mock_data/mock_video.mp4', 'VIDEO_TITLE', 'INTRODUCTION');
        $this->assertIsArray($ret);
        $this->assertEquals(json_decode($this->readMockResponseJson('upload.json'), true), $ret);
    }

    public function testUploadArticle()
    {
        $response = $this->buildResponse(Status::CODE_OK, '{"media_id":"MEDIA_ID"}');
        $app = $this->mockAccessToken(new ServiceContainer([
            'appId' => 'mock_appId'
        ]));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/material/add_news', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);
        $client = new Client($app);

        $articles = new Article([
            'title' => 'TITLE',
            'thumb_media_id' => 'THUMB_MEDIA_ID',
            'author' => 'AUTHOR',
            'digest' => 'DIGEST',
            'show_cover_pic' => 'SHOW_COVER_PIC(0 / 1)',
            'show_cover' => 'SHOW_COVER_PIC(0 / 1)',
            'content' => 'CONTENT',
            'content_source_url' => 'CONTENT_SOURCE_URL',
            'need_open_comment' => 1,
            'only_fans_can_comment' => 1
        ]);

        $ret = $client->uploadArticle($articles);
        $this->assertIsArray($ret);
        $this->assertEquals(json_decode('{"media_id":"MEDIA_ID"}', true), $ret);


        $response = $this->buildResponse(Status::CODE_OK, '{"media_id":"MEDIA_ID"}');
        $app = $this->mockAccessToken(new ServiceContainer([
            'appId' => 'mock_appId'
        ]));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/material/add_news', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);
        $client = new Client($app);

        $article1 = new Article([
            'title' => 'TITLE1',
            'thumb_media_id' => 'THUMB_MEDIA_ID',
            'author' => 'AUTHOR',
            'digest' => 'DIGEST',
            'show_cover_pic' => 'SHOW_COVER_PIC(0 / 1)',
            'show_cover' => 'SHOW_COVER_PIC(0 / 1)',
            'content' => 'CONTENT',
            'content_source_url' => 'CONTENT_SOURCE_URL',
            'need_open_comment' => 1,
            'only_fans_can_comment' => 1
        ]);
        $article2 = new Article([
            'title' => 'TITLE2',
            'thumb_media_id' => 'THUMB_MEDIA_ID',
            'author' => 'AUTHOR',
            'digest' => 'DIGEST',
            'show_cover_pic' => 'SHOW_COVER_PIC(0 / 1)',
            'show_cover' => 'SHOW_COVER_PIC(0 / 1)',
            'content' => 'CONTENT',
            'content_source_url' => 'CONTENT_SOURCE_URL',
            'need_open_comment' => 1,
            'only_fans_can_comment' => 1
        ]);

        $articlesArr = [
            $article1,
            $article2
        ];

        $ret = $client->uploadArticle($articlesArr);
        $this->assertIsArray($ret);
        $this->assertEquals(json_decode('{"media_id":"MEDIA_ID"}', true), $ret);
    }

    public function testUpdateArticle()
    {
        $response = $this->buildResponse(Status::CODE_OK, '{"errcode":0,"errmsg":"ok"}');
        $app = $this->mockAccessToken(new ServiceContainer([
            'appId' => 'mock_appId'
        ]));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/material/update_news', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);
        $client = new Client($app);
        $article = new Article([
            'title' => 'TITLE',
            'thumb_media_id' => 'THUMB_MEDIA_ID',
            'author' => 'AUTHOR',
            'digest' => 'DIGEST',
            'show_cover_pic' => 'SHOW_COVER_PIC(0 / 1)',
            'show_cover' => 'SHOW_COVER_PIC(0 / 1)',
            'content' => 'CONTENT',
            'content_source_url' => 'CONTENT_SOURCE_URL'
        ]);
        $this->assertTrue($client->updateArticle('MEDIA_ID', $article, 1));
    }

    public function testUploadArticleImage()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('uploadArticleImage.json'));
        $app = $this->mockAccessToken(new ServiceContainer([
            'appId' => 'mock_appId'
        ]));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/media/uploadimg', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token&type=news_image', $request->getUri()->getQuery());
        }, $response, $app);
        $client = new Client($app);
        $ret = $client->uploadArticleImage(__DIR__.'/mock_data/mock_image.jpg');
        $this->assertIsArray($ret);
        $this->assertSame(json_decode($this->readMockResponseJson('uploadArticleImage.json'), true), $ret);
    }

    public function testUpload()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('upload.json'));
        $app = $this->mockAccessToken(new ServiceContainer([
            'appId' => 'mock_appId'
        ]));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/material/add_material', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token&type=image', $request->getUri()->getQuery());
        }, $response, $app);
        $client = new Client($app);
        $ret = $client->upload('image', __DIR__ . '/mock_data/mock_image.jpg');
        $this->assertIsArray($ret);
        $this->assertEquals(json_decode($this->readMockResponseJson('upload.json'), true), $ret);
    }

    public function testdelete()
    {
        $response = $this->buildResponse(Status::CODE_OK, '{"errcode":0,"errmsg":"ok"}');
        $app = $this->mockAccessToken(new ServiceContainer([
            'appId' => 'mock_appId'
        ]));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/material/del_material', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);
        $client = new Client($app);
        $this->assertTrue($client->delete('MEDIA_ID'));
    }

    public function testStats()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('stats.json'));
        $app = $this->mockAccessToken(new ServiceContainer([
            'appId' => 'mock_appId'
        ]));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('GET', $request->getMethod());
            $this->assertEquals('/cgi-bin/material/get_materialcount', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);
        $client = new Client($app);
        $ret = $client->stats();
        $this->assertIsArray($ret);
        $this->assertEquals(json_decode($this->readMockResponseJson('stats.json'), true), $ret);
    }

    public function testGet1()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('get1.json'));
        $app = $this->mockAccessToken(new ServiceContainer([
            'appId' => 'mock_appId'
        ]));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/material/get_material', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);
        $client = new Client($app);
        $ret = $client->get('MEDIA_ID');
        $this->assertIsArray($ret);
        $this->assertEquals(json_decode($this->readMockResponseJson('get1.json'), true), $ret);
    }

    public function testGet2()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('get2.json'));
        $app = $this->mockAccessToken(new ServiceContainer([
            'appId' => 'mock_appId'
        ]));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/cgi-bin/material/get_material', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);
        $client = new Client($app);
        $ret = $client->get('MEDIA_ID');
        $this->assertIsArray($ret);
        $this->assertEquals(json_decode($this->readMockResponseJson('get2.json'), true), $ret);
    }

    public function testGetApiBytype()
    {
        $response = $this->buildResponse(Status::CODE_OK, $this->readMockResponseJson('stats.json'));
        $app = $this->mockAccessToken(new ServiceContainer([
            'appId' => 'mock_appId'
        ]));
        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
        }, $response, $app);
        $client = new Client($app);
        $this->assertSame('/cgi-bin/media/uploadimg', $client->getApiByType('news_image'));
        $this->assertSame('/cgi-bin/material/add_material', $client->getApiByType('image'));
    }

    protected function readMockResponseJson(string $file): string
    {
        return file_get_contents(dirname(__FILE__) . '/mock_data/' . $file);
    }
}