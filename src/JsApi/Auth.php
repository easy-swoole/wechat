<?php
/**
 * Created by PhpStorm.
 * User: yf
 * Date: 2018/12/24
 * Time: 11:23 PM
 */

namespace EasySwoole\WeChat\JsApi;


use EasySwoole\WeChat\Bean\OfficialAccount\User;

class Auth extends JsApiBase
{
    const TYPE_BASE = 'snsapi_base';
    const TYPE_USER_INFO = 'snsapi_userinfo';

    function generateURL($redirect_uri,$state = '',$type = self::TYPE_BASE)
    {
        $redirect_uri = urlencode($redirect_uri);
    }

    /*
     * 这里直接code换access token,再获取用户信息
     */
    function codeToInfo($authCode):?User
    {
        return null;
    }
}