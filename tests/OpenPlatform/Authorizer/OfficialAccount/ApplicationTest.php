<?php
/**
 * Created by PhpStorm.
 * User: XueSi
 * Email: <1592328848@qq.com>
 * Date: 2021/5/11
 * Time: 1:50
 */

namespace EasySwoole\WeChat\Tests\OpenPlatform\Authorizer\OfficialAccount;


use EasySwoole\WeChat\OpenPlatform\Authorizer\OfficialAccount\Application;
use EasySwoole\WeChat\Tests\TestCase;

class ApplicationTest extends TestCase
{
    public function testProperties()
    {
        /** @var Application $officialAccount */
        $officialAccount = new Application(['app_id' => 'mock_appId']);

        $this->assertInstanceOf(\EasySwoole\WeChat\OpenPlatform\Authorizer\OfficialAccount\MiniProgram\Client::class, $officialAccount->miniProgram);
    }
}