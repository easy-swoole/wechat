<?php
/**
 * Created by PhpStorm.
 * User: yf
 * Date: 2018-12-30
 * Time: 14:58
 */

namespace EasySwoole\WeChat\OfficialAccount\JsSdk;


class Auth extends JsApiBase
{
    function generateURL(AuthRequest $request)
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