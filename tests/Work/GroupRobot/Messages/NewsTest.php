<?php
/**
 * Created by PhpStorm.
 * User: XueSi
 * Email: <1592328848@qq.com>
 * Date: 2021/4/26
 * Time: 23:49
 */

namespace EasySwoole\WeChat\Tests\Work\GroupRobot\Messages;


use EasySwoole\WeChat\Tests\TestCase;
use EasySwoole\WeChat\Work\GroupRobot\Messages\Message;
use EasySwoole\WeChat\Work\GroupRobot\Messages\News;
use EasySwoole\WeChat\Work\GroupRobot\Messages\NewsItem;

class NewsTest extends TestCase
{
    public function testBasicFeatures()
    {
        $items = [
            new NewsItem([
                'title' => 'mock-title',
                'description' => 'mock-description',
                'url' => 'mock-url',
                'image' => 'mock-picurl',
            ])
        ];

        $news = new News($items);

        $mockArr = [
            'msgtype' => 'news',
            'news' => [
                'articles' => [
                    [
                        'title' => 'mock-title',
                        'description' => 'mock-description',
                        'url' => 'mock-url',
                        'picurl' => 'mock-picurl',
                    ],
                ],
            ],
        ];

        $this->assertSame($mockArr, $news->transformForJsonRequest());

        $this->assertInstanceOf(Message::class, $news);
    }
}