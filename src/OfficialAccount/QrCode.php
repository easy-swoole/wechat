<?php
/**
 * Created by PhpStorm.
 * User: yf
 * Date: 2018/12/25
 * Time: 12:25 AM
 */

namespace EasySwoole\WeChat\OfficialAccount;


use EasySwoole\WeChat\Bean\OfficialAccountQrCode;
use EasySwoole\WeChat\Bean\OfficialAccountQrCodeRequest;

class QrCode extends ServiceBase
{
    function getTick(OfficialAccountQrCodeRequest $codeRequest):?OfficialAccountQrCode
    {

    }

    public static function tickToImageUrl(OfficialAccountQrCode $code)
    {

    }
}