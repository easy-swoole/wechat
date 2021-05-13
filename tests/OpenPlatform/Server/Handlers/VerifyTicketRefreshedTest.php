<?php
/**
 * Created by PhpStorm.
 * User: XueSi
 * Email: <1592328848@qq.com>
 * Date: 2021/5/13
 * Time: 22:57
 */

namespace EasySwoole\WeChat\Tests\OpenPlatform\Server\Handlers;

use EasySwoole\WeChat\Kernel\Encryptor;
use EasySwoole\WeChat\Kernel\ServiceProviders;
use EasySwoole\WeChat\OpenPlatform\Application;
use EasySwoole\WeChat\OpenPlatform\Server\Guard;
use EasySwoole\WeChat\OpenPlatform\Server\Handlers\VerifyTicketRefreshedHandler;
use EasySwoole\WeChat\Tests\TestCase;

class VerifyTicketRefreshedTest extends TestCase
{
    // 安全 消息内容加密模式
    public function testHandle1()
    {
        // 安全模式 对消息内容进行加密的单元测试
        $mockData = $this->readMockData('safe_mode_VerifyTicketRefreshedHandler.json');

        $mockData = json_decode($mockData, true);

        $app = new Application([
            'aesKey' => 'abcdefghijklmnopqrstuvwxyz0123456789ABCDEFG',
            'appId' => 'wxb11529c136998cb6',
            'token' => 'pamtest'
        ]);

        $app->rebind(ServiceProviders::Encryptor, new Encryptor());

        $handler = new VerifyTicketRefreshedHandler($app);

        $mockServerRequest = $this->buildRequest(
            "POST",
            "https://easyswoole.wechat.test.com?" . http_build_query($mockData['query']),
            [],
            $mockData['body']
        );

        $guard = new Guard($app);

        $guard = $guard->validate($mockServerRequest);

        $this->assertNull($handler->handle($guard->parseRequest($mockServerRequest)));
    }

    // 安全 消息内容非加密模式
    public function testHandle2()
    {
        // 安全模式 对消息内容进行加密的单元测试
        $mockData = $this->readMockData('clear_mode_VerifyTicketRefreshedHandler.json');

        $mockData = json_decode($mockData, true);

        $app = new Application([
            'appId' => 'wxb11529c136998cb6',
            'token' => 'pamtest'
        ]);

        $app->rebind(ServiceProviders::Encryptor, new Encryptor());

        $handler = new VerifyTicketRefreshedHandler($app);

        $mockServerRequest = $this->buildRequest(
            "POST",
            "https://easyswoole.wechat.test.com?" . http_build_query($mockData['query']),
            [],
            $mockData['body']
        );

        $guard = new Guard($app);

        // 验证请求是否开启安全模式
        $guard = $guard->validate($mockServerRequest);

        $this->assertNull($handler->handle($guard->parseRequest($mockServerRequest)));
    }

    /**
     * @param string $filename
     * @return string
     */
    private function readMockData(string $filename): string
    {
        return file_get_contents(dirname(__FILE__) . '/mock_data/' . $filename);
    }
}