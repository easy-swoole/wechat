<?php
/**
 * Created by PhpStorm.
 * User: yf
 * Date: 2018-12-30
 * Time: 14:58
 */

namespace EasySwoole\WeChat\OfficialAccount\JsSdk;


use EasySwoole\WeChat\Bean\OfficialAccount\JsAuthRequest;
use EasySwoole\WeChat\OfficialAccount\User;

class Auth extends JsApiBase
{
    function generateURL(JsAuthRequest $request)
    {
        $redirect_uri = urlencode($request->getRedirectUri());
    }

    /*
     * 这里直接code换access token,再获取用户信息
     */
    function codeToInfo($authCode):?User
    {
        return null;
    }
}