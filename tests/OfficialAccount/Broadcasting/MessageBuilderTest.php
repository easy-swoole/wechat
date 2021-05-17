<?php
/**
 * Created by PhpStorm.
 * User: XueSi
 * Email: <1592328848@qq.com>
 * Date: 2021/5/18
 * Time: 0:16
 */

namespace EasySwoole\WeChat\Tests\OfficialAccount\Broadcasting;

use EasySwoole\WeChat\Kernel\Messages\Text;
use EasySwoole\WeChat\OfficialAccount\Broadcasting\Client;
use EasySwoole\WeChat\OfficialAccount\Broadcasting\MessageBuilder;
use EasySwoole\WeChat\Tests\TestCase;

class MessageBuilderTest extends TestCase
{
    public function testMessageBuildWithoutMessage()
    {
        $builder = new MessageBuilder();

        // without message
        try {
            $builder->build();
            $this->fail('Faild to assert Exception thrown.');
        } catch (\Exception $e) {
            $this->assertSame('No message content to send.', $e->getMessage());
        }
    }

    public function testBuildForPreview()
    {
        $builder = new MessageBuilder();

        $this->assertSame([
            'touser' => 'mock-openid',
            'text' => [
                'content' => 'CONTENT',
            ],
            'msgtype' => 'text',
        ], $builder->message(new Text('CONTENT'))->buildForPreview(Client::PREVIEW_BY_OPENID, 'mock-openid'));


        $this->assertSame([
            'towxname' => 'mock-wxname',
            'text' => [
                'content' => 'CONTENT',
            ],
            'msgtype' => 'text',
        ], $builder->message(new Text('CONTENT'))->buildForPreview(Client::PREVIEW_BY_NAME, 'mock-wxname'));
    }

    public function testBuild()
    {
        $text = new Text('CONTENT');


        // to all
        $message = (new MessageBuilder())->message($text)->with(['send_ignore_reprint' => 1])->toAll()->build();

        $this->assertSame([
            'filter' => [
                'is_to_all' => true,
            ],
            'text' => [
                'content' => 'CONTENT',
            ],
            'msgtype' => 'text',
            'send_ignore_reprint' => 1,
        ], $message);


        // to tag
        $message = (new MessageBuilder())->message($text)->toTag(23)->build();

        $this->assertSame([
            'filter' => [
                'is_to_all' => false,
                'tag_id' => 23,
            ],
            'text' => [
                'content' => 'CONTENT',
            ],
            'msgtype' => 'text',
        ], $message);


        // to users
        $message = (new MessageBuilder())->message($text)->toUsers(['mock-group-id1', 'mock-group-id2'])->build();

        $this->assertSame([
            'touser' => [
                'mock-group-id1',
                'mock-group-id2',
            ],
            'text' => [
                'content' => 'CONTENT',
            ],
            'msgtype' => 'text',
        ], $message);
    }
}