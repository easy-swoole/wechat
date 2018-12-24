<?php
/**
 * Created by PhpStorm.
 * User: yf
 * Date: 2018/12/24
 * Time: 10:19 PM
 */

namespace EasySwoole\WeChat\OfficialAccount;


class ErrorCode
{
    /*
     * map to https://mp.weixin.qq.com/wiki?t=resource/res_main&id=mp1433747234
     */
    const OK = 0;
    const SYS_BUSY = -1;
    const INVALID_ACCESS_TOKEN_OR_APP_SECRET = 40001;
}