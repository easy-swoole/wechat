<?php
/**
 * Created by PhpStorm.
 * User: yf
 * Date: 2018/12/24
 * Time: 4:51 PM
 */

namespace EasySwoole\WeChat\JsApi;


use EasySwoole\WeChat\OfficialAccount\ServiceBase;

class JsApi extends ServiceBase
{
    /*
     * jsApi的入口在公众号那边
     */

    function auth()
    {
        return new Auth($this);
    }
}