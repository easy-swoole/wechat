<?php
/**
 * Created by PhpStorm.
 * User: eValor
 * Date: 2019-03-18
 * Time: 09:38
 */

namespace EasySwoole\WeChat\OpenPlatform;

class ApiUrl
{
    // 授权跳转URL
    const PRE_AUTHORIZATION = 'https://open.weixin.qq.com/connect/qrconnect?appid=APPID&redirect_uri=REDIRECT_URI&response_type=code&scope=SCOPE&state=STATE#wechat_redirect';

    // 换取访问令牌
    const ACCESS_TOKEN = 'https://api.weixin.qq.com/sns/oauth2/access_token?appid=APPID&secret=SECRET&code=CODE&grant_type=authorization_code';

    // 刷新访问令牌有效期
    const REFRESH_TOKEN = 'https://api.weixin.qq.com/sns/oauth2/refresh_token?appid=APPID&grant_type=refresh_token&refresh_token=REFRESH_TOKEN';

    // 确认访问令牌是否仍然有效
    const ACCESS_AUTH_CHECK = 'https://api.weixin.qq.com/sns/auth?access_token=ACCESS_TOKEN&openid=OPENID';

    // 获取用户信息
    const GET_USER_INFO = 'https://api.weixin.qq.com/sns/userinfo?access_token=ACCESS_TOKEN&openid=OPENID';

    public static function generateURL(string $baseUrl, array $data): string
    {
        foreach ($data as $key => $item) {
            $baseUrl = str_replace($key, $item, $baseUrl);
        }
        return $baseUrl;
    }
}