<?php
/**
 * Created by PhpStorm.
 * User: XueSi
 * Email: <1592328848@qq.com>
 * Date: 2021/5/13
 * Time: 22:56
 */

namespace EasySwoole\WeChat\Tests\OpenPlatform\Server\Handlers;

use EasySwoole\WeChat\OpenPlatform\Server\Handlers\UpdateAuthorizedHandler;
use EasySwoole\WeChat\Tests\TestCase;

class UpdateAuthorizedTest extends TestCase
{
    public function testHandle()
    {
        $handler = new UpdateAuthorizedHandler();
        $this->assertNull($handler->handle());
    }
}