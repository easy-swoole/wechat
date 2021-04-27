<?php
/**
 * Created by PhpStorm.
 * User: XueSi
 * Email: <1592328848@qq.com>
 * Date: 2021/4/26
 * Time: 23:41
 */

namespace EasySwoole\WeChat\Tests\Work\GroupRobot\Messages;


use EasySwoole\WeChat\Tests\TestCase;
use EasySwoole\WeChat\Work\GroupRobot\Messages\Markdown;
use EasySwoole\WeChat\Work\GroupRobot\Messages\Message;

class MarkdownTest extends TestCase
{
    public function testBasicFeatures()
    {
        $markdown = new Markdown('mock_content');

        $this->assertSame('mock_content', $markdown->content);

        $mockJson = '{"msgtype":"markdown","markdown":{"content":"mock_content"}}';

        $this->assertSame(json_decode($mockJson, true), $markdown->transformForJsonRequest());

        $this->assertInstanceOf(Message::class, $markdown);
    }
}