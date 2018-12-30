<?php
/**
 * Created by PhpStorm.
 * User: yf
 * Date: 2018/12/24
 * Time: 11:23 PM
 */

namespace EasySwoole\WeChat\JsApi;


use EasySwoole\WeChat\Bean\JsApi\AuthRequest;
use EasySwoole\WeChat\Bean\JsApi\User;


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