<?php
/**
 * Created by PhpStorm.
 * User: yf
 * Date: 2018/12/25
 * Time: 12:25 AM
 */

namespace EasySwoole\WeChat\OfficialAccount;




use EasySwoole\WeChat\Bean\OfficialAccount\QrCodeRequest;
use EasySwoole\WeChat\Bean\OfficialAccount\QrCode as QrCodeBean;

class QrCode extends ServiceBase
{
    function getTick(QrCodeRequest $codeRequest):?QrCodeBean
    {

    }

    public static function tickToImageUrl(QrCodeBean $code):?string
    {

    }
}