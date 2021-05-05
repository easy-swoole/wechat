<?php
/**
 * Created by PhpStorm.
 * User: XueSi
 * Email: <1592328848@qq.com>
 * Date: 2021/5/6
 * Time: 0:54
 */

namespace EasySwoole\WeChat\Tests\MiniProgram\Mall;


use EasySwoole\WeChat\Tests\TestCase;
use EasySwoole\WeChat\Kernel\ServiceContainer;
use EasySwoole\WeChat\Tests\Mock\Message\Status;
use Psr\Http\Message\ServerRequestInterface;
use EasySwoole\WeChat\MiniProgram\Mall\MediaClient;

class MediaClientTest extends TestCase
{
    public function testImport()
    {
        $response = $this->buildResponse(Status::CODE_OK, '{"errcode":0,"errmsg":"success"}');

        $app = $this->mockAccessToken(new ServiceContainer([
            'appId' => 'mock_appid',
            'appSecret' => 'mock_secret'
        ]));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/mall/importmedia', $request->getUri()->getPath());
            $this->assertEquals('access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new MediaClient($app);

        $params = [
            'media_list' => [
                [
                    'item_code' => 'here_is_spu_id',
                    'title' => 'media_name',
                    'desc' => 'media_description',
                    'image_list' => [
                        'image_url1',
                        'image_url2',
                    ],
                    'src_wxapp_path' => '/detail?item_code=xxxx',
                    'media_info' => [
                        'type' => 1,
                        'play_url' => 'www.qq.music.com/test.mp3',
                    ],
                ],
            ],
        ];

        $this->assertTrue($client->import($params));
    }
}