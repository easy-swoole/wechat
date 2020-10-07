<?php


namespace EasySwoole\WeChat;


use EasySwoole\WeChat\OfficialAccount\Application as OfficialAccount;

class Factory
{
    public static function officialAccount(...$arguments)
    {
        return new OfficialAccount(...$arguments);
    }
}