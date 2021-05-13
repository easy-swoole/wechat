<?php
/**
 * User: XueSi
 * Date: 2021/4/23 18:31
 * Author: XueSi <1592328848@qq.com>
 */

namespace EasySwoole\WeChat\Tests\OpenPlatform\Authorizer\MiniProgram;


use EasySwoole\WeChat\OpenPlatform\Authorizer\MiniProgram\Application;
use EasySwoole\WeChat\Tests\TestCase;

class ApplicationTest extends TestCase
{
    public function testProperties()
    {
        /** @var Application $miniProgram */
        $miniProgram = new Application(['app_id' => 'mock_appId']);

        $this->assertInstanceOf(\EasySwoole\WeChat\OpenPlatform\Authorizer\MiniProgram\Code\Client::class, $miniProgram->code);

        $this->assertInstanceOf(\EasySwoole\WeChat\OpenPlatform\Authorizer\MiniProgram\Domain\Client::class, $miniProgram->domain);

        $this->assertInstanceOf(\EasySwoole\WeChat\OpenPlatform\Authorizer\MiniProgram\Material\Client::class, $miniProgram->material);

        $this->assertInstanceOf(\EasySwoole\WeChat\OpenPlatform\Authorizer\MiniProgram\QrCodeJump\Client::class, $miniProgram->qrCodeJump);

        $this->assertInstanceOf(\EasySwoole\WeChat\OpenPlatform\Authorizer\MiniProgram\Setting\Client::class, $miniProgram->setting);

        $this->assertInstanceOf(\EasySwoole\WeChat\OpenPlatform\Authorizer\MiniProgram\Tester\Client::class, $miniProgram->tester);
    }
}
