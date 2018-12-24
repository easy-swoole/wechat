<?php
/**
 * Created by PhpStorm.
 * User: yf
 * Date: 2018/12/24
 * Time: 10:37 PM
 */

namespace EasySwoole\WeChat\OfficialAccount;


class ApiUrl
{
    const ACCESS_TOKEN = 'https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=APPID&secret=APPSECRET';

    public static function generateURL(string $baseUrl,array $data):string
    {
        foreach ($data as $key => $item){
            $baseUrl = str_replace($key,$item,$baseUrl);
        }
        return $baseUrl;
    }
}