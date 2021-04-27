<?php
/**
 * Created by PhpStorm.
 * User: XueSi
 * Email: <1592328848@qq.com>
 * Date: 2021/4/26
 * Time: 23:46
 */

namespace EasySwoole\WeChat\Tests\Work\GroupRobot\Messages;


use EasySwoole\WeChat\Tests\TestCase;
use EasySwoole\WeChat\Work\GroupRobot\Messages\Message;
use EasySwoole\WeChat\Work\GroupRobot\Messages\NewsItem;

class NewsItemTest extends TestCase
{
    public function testBasicFeatures()
    {
        $newItem = new NewsItem([
            'title' => 'mock-title',
            'description' => 'mock-description',
            'url' => 'mock-url',
            'image' => 'mock-image',
        ]);

        $this->assertSame([
            'title' => 'mock-title',
            'description' => 'mock-description',
            'url' => 'mock-url',
            'picurl' => 'mock-image',
        ], $newItem->toJsonArray());

        $mockJson = '{"msgtype":"news","news":{"articles":[{"title":"mock-title","description":"mock-description","url":"mock-url","picurl":"mock-image"}]}}';

        $this->assertSame(json_decode($mockJson, true), $newItem->transformForJsonRequest());

        $this->assertInstanceOf(Message::class, $newItem);
    }
}