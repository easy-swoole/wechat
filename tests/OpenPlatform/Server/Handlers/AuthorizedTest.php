<?php
/**
 * Created by PhpStorm.
 * User: XueSi
 * Email: <1592328848@qq.com>
 * Date: 2021/5/13
 * Time: 22:54
 */

namespace EasySwoole\WeChat\Tests\OpenPlatform\Server\Handlers;

use EasySwoole\WeChat\OpenPlatform\Server\Handlers\AuthorizedHandler;
use EasySwoole\WeChat\Tests\TestCase;

class AuthorizedTest extends TestCase
{
    public function testHandler()
    {
        $handler = new AuthorizedHandler();
        $this->assertNull($handler->handle());
    }
}