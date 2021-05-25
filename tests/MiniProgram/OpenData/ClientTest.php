<?php
/**
 * Created by PhpStorm.
 * User: XueSi
 * Email: <1592328848@qq.com>
 * Date: 2021/5/5
 * Time: 19:44
 */

namespace EasySwoole\WeChat\Tests\MiniProgram\OpenData;

use EasySwoole\WeChat\Kernel\ServiceContainer;
use EasySwoole\WeChat\Tests\Mock\Message\Status;
use EasySwoole\WeChat\Tests\TestCase;
use Psr\Http\Message\ServerRequestInterface;
use EasySwoole\WeChat\MiniProgram\OpenData\Client;

class ClientTest extends TestCase
{
    public function testRemoveUserStorage()
    {
        $response = $this->buildResponse(Status::CODE_OK, '{"errcode":0,"errmsg":""}');

        $app = $this->mockAccessToken(new ServiceContainer([
            'appId' => 'mock_appid',
            'appSecret' => 'mock_secret'
        ]));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/wxa/remove_user_storage', $request->getUri()->getPath());
            $this->assertEquals('openid=mock-openid&sig_method=hmac_sha256&signature=1bedbb2ffda206ec6ad5b4e694efb914b1b481ea3661c4adc81bdc7232655fed&access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        $this->assertTrue($client->removeUserStorage('mock-openid', 'mock-session-key', ['mock-key']));
    }

    public function testSetUserStorage()
    {
        $response = $this->buildResponse(Status::CODE_OK, '{"errcode":0,"errmsg":""}');

        $app = $this->mockAccessToken(new ServiceContainer([
            'appId' => 'mock_appid',
            'appSecret' => 'mock_secret'
        ]));

        $app = $this->mockHttpClient(function (ServerRequestInterface $request) {
            $this->assertEquals('POST', $request->getMethod());
            $this->assertEquals('/wxa/set_user_storage', $request->getUri()->getPath());
            $this->assertEquals('openid=mock-openid&sig_method=hmac_sha256&signature=428995f6ef0227629528261163b4c6f722e324744857a3d23b3b0c3dd7490ea2&access_token=mock_access_token', $request->getUri()->getQuery());
        }, $response, $app);

        $client = new Client($app);

        $kvList = [
            'mock-key-1' => 'mock-value-1',
            'mock-key-2' => 'mock-value-2'
        ];

        $this->assertTrue($client->setUserStorage('mock-openid', 'mock-session-key', $kvList));
    }
}
