<?php
/**
 * Created by PhpStorm.
 * User: yf
 * Date: 2018-12-30
 * Time: 13:57
 */

namespace EasySwoole\WeChat\JsApi;


class JsApiBase
{
    private $jsApi;

    function __construct(JsApi $jsApi)
    {
        $this->jsApi = $jsApi;
    }

    /**
     * @return JsApi
     */
    public function getJsApi(): JsApi
    {
        return $this->jsApi;
    }
}