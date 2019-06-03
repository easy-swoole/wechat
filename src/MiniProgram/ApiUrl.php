<?php


namespace EasySwoole\WeChat\MiniProgram;


class ApiUrl
{
    /**
     * 获取 ACCESS TOKEN
     */
    const ACCESS_TOKEN = "https://api.weixin.qq.com/cgi-bin/token?grant_type=client_credential&appid=APPID&secret=APPSECRET";

    /**
     * JSCODE 换取 SESSION KEY
     */
    const JSCODE2_SESSION = "https://api.weixin.qq.com/sns/jscode2session?appid=APPID&secret=SECRET&js_code=JSCODE&grant_type=authorization_code";

    // 二维码接口ABC
    const QRCODE_GETWXACODE = 'https://api.weixin.qq.com/wxa/getwxacode?access_token=ACCESS_TOKEN';
    const QRCODE_GETWXACODE_UNLIMIT = 'https://api.weixin.qq.com/wxa/getwxacodeunlimit?access_token=ACCESS_TOKEN';
    const QRCODE_CREATE_WXACODE = 'https://api.weixin.qq.com/cgi-bin/wxaapp/createwxaqrcode?access_token=ACCESS_TOKEN';


    public static function generateURL(string $baseUrl, array $data): string
    {
        foreach ($data as $key => $item) {
            $baseUrl = str_replace($key, $item, $baseUrl);
        }
        return $baseUrl;
    }
}