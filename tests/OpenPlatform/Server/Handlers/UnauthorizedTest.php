<?php
/**
 * Created by PhpStorm.
 * User: XueSi
 * Email: <1592328848@qq.com>
 * Date: 2021/5/13
 * Time: 22:55
 */

namespace EasySwoole\WeChat\Tests\OpenPlatform\Server\Handlers;

use EasySwoole\WeChat\OpenPlatform\Server\Handlers\UnauthorizedHandler;
use EasySwoole\WeChat\Tests\TestCase;

class UnauthorizedTest extends TestCase
{
    public function testHandle()
    {
        $handler = new UnauthorizedHandler();
        $this->assertNull($handler->handle());
    }
}