<?php
/**
 * Created by PhpStorm.
 * User: XueSi
 * Email: <1592328848@qq.com>
 * Date: 2021/4/27
 * Time: 0:28
 */

namespace EasySwoole\WeChat\Tests\Work\GroupRobot\Messages;


use EasySwoole\WeChat\Tests\TestCase;
use EasySwoole\WeChat\Work\GroupRobot\Messages\Message;
use EasySwoole\WeChat\Work\GroupRobot\Messages\Text;

class TextTest extends TestCase
{
    public function testBasicFeatures()
    {
        $text = new Text(
            '广州今日天气：29度，大部分多云，降雨概率：60%',
            ['wangqing', '@all'],
            ['13800001111', '@all']
        );

        $this->assertSame('广州今日天气：29度，大部分多云，降雨概率：60%', $text->content);

        $this->assertSame(['wangqing', '@all'], $text->mentioned_list);

        $this->assertSame(['13800001111', '@all'], $text->mentioned_mobile_list);

        $mockJson = '{"msgtype":"text","text":{"content":"广州今日天气：29度，大部分多云，降雨概率：60%","mentioned_list":["wangqing","@all"],"mentioned_mobile_list":["13800001111","@all"]}}';

        $this->assertSame(json_decode($mockJson, true), $text->transformForJsonRequest());

        $this->assertInstanceOf(Message::class, $text);
    }
}