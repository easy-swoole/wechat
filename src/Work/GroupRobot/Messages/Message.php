<?php

namespace EasySwoole\WeChat\Work\GroupRobot\Messages;

use EasySwoole\WeChat\Kernel\Messages\Message as BaseMessage;

/**
 * Class Message
 * @package EasySwoole\WeChat\Work\GroupRobot\Messages
 * @author: XueSi
 * @email: <1592328848@qq.com>
 */
class Message extends BaseMessage
{
    public function transformForJsonRequest(array $appends = []): array
    {
        return [
            'msgtype' => $this->getType(),
            $this->getType() => parent::transformForJsonRequest()
        ];
    }
}