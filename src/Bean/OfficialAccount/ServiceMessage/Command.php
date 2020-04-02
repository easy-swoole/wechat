<?php
/**
 * Created by PhpStorm.
 * User: EZ
 * Date: 2020/4/3
 * Time: 00:19
 */

namespace EasySwoole\WeChat\Bean\OfficialAccount\ServiceMessage;


use EasySwoole\Spl\SplArray;
use EasySwoole\Spl\SplBean;
use EasySwoole\WeChat\Bean\OfficialAccount\RequestConst;

class Command extends RequestedReplyMsg
{
    // 客服输入状态(默认是取消状态)
    protected $command = 'CancelTyping';

    /**
     * @return SplArray
     */
    public function buildMessage() : SplArray
    {
        $data = $this->toArray(null, Command::FILTER_NOT_NULL);

        return new SplArray($data);
    }

    /**
     * @return null|string
     */
    public function getCommand() : ?string
    {
        return $this->command ?? null;
    }

    public function setCommand()
    {
        $this->command = 'Typing';
    }


}