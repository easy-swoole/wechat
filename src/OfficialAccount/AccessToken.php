<?php
/**
 * Created by PhpStorm.
 * User: yf
 * Date: 2018/12/25
 * Time: 12:09 AM
 */

namespace EasySwoole\WeChat\OfficialAccount;


class AccessToken extends ServiceBase
{
    function getToken($forceRefresh = false)
    {
        /*
         * 这里要实现过期识别
         */
//        $this->getOfficialAccount()->getConfig()->getStorage()->set();
    }

    function refresh():bool
    {
//        $this->getOfficialAccount()->getConfig()->getStorage()->set();
    }
}