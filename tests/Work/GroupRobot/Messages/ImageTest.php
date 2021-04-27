<?php
/**
 * Created by PhpStorm.
 * User: XueSi
 * Email: <1592328848@qq.com>
 * Date: 2021/4/26
 * Time: 23:40
 */

namespace EasySwoole\WeChat\Tests\Work\GroupRobot\Messages;

use EasySwoole\WeChat\Work\GroupRobot\Messages\Message;
use EasySwoole\WeChat\Tests\TestCase;
use EasySwoole\WeChat\Work\GroupRobot\Messages\Image;

class ImageTest extends TestCase
{
    public function testBasicFeatures()
    {
        $image = new Image('mock-base64', 'mock-md5');

        $this->assertSame('mock-base64', $image->base64);

        $this->assertSame('mock-md5', $image->md5);

        $this->assertInstanceOf(Message::class, $image);

        $mockJson = '{"msgtype":"image","image":{"base64":"mock-base64","md5":"mock-md5"}}';

        $this->assertSame(json_decode($mockJson, true), $image->transformForJsonRequest());
    }
}