<?php
/**
 * Created by PhpStorm.
 * User: XueSi
 * Email: <1592328848@qq.com>
 * Date: 2021/5/16
 * Time: 20:02
 */

namespace EasySwoole\WeChat\Tests;

use EasySwoole\WeChat\Factory;
use EasySwoole\WeChat\Kernel\ServiceProviders;

class FactoryTest extends TestCase
{
    public function testStaticCall()
    {
        // officialAccount
        $officialAccount = Factory::officialAccount([
            'appId' => 'mock_appId',
            'appSecret' => 'mock_appSecret'
        ]);

        $this->assertInstanceOf(\EasySwoole\WeChat\OfficialAccount\Application::class, $officialAccount);

        $expected = [
            'appId' => 'mock_appId',
            'appSecret' => 'mock_appSecret'
        ];

        $this->assertSame($expected, $officialAccount[ServiceProviders::Config]->all());


        // openPlatform
        $openPlatform = Factory::openPlatform([
            'appId' => 'mock_appId',
            'appSecret' => 'mock_appSecret'
        ]);
        $this->assertInstanceOf(\EasySwoole\WeChat\OpenPlatform\Application::class, $openPlatform);


        // miniProgram
        $miniProgram = Factory::miniProgram([
            'appId' => 'mock_appId',
            'appSecret' => 'mock_appSecret'
        ]);
        $this->assertInstanceOf(\EasySwoole\WeChat\MiniProgram\Application::class, $miniProgram);


        // miniProgram
        $miniProgram = Factory::miniProgram([
            'appId' => 'mock_appId',
            'appSecret' => 'mock_appSecret'
        ]);
        $this->assertInstanceOf(\EasySwoole\WeChat\MiniProgram\Application::class, $miniProgram);


        // work
        $work = Factory::work([
            'corpId' => 'mock_corpId',
            'corpSecret' => 'mock_corpSecret',
        ]);
        $this->assertInstanceOf(\EasySwoole\WeChat\Work\Application::class, $work);
    }
}