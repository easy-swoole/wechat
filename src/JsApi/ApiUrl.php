<?php
/**
 * Created by PhpStorm.
 * User: yf
 * Date: 2018/12/24
 * Time: 10:37 PM
 */

namespace EasySwoole\WeChat\JsApi;


class ApiUrl
{
    public static function generateURL(string $baseUrl,array $data):string
    {
        foreach ($data as $key => $item){
            $baseUrl = str_replace($key,$item,$baseUrl);
        }
        return $baseUrl;
    }
}