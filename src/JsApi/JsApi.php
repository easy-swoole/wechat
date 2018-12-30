<?php
/**
 * Created by PhpStorm.
 * User: yf
 * Date: 2018/12/24
 * Time: 4:51 PM
 */

namespace EasySwoole\WeChat\JsApi;


use EasySwoole\WeChat\OfficialAccount\OfficialAccountBase;

class JsApi extends OfficialAccountBase
{
    private $sdk;
    private $auth;
    /*
     * 用户网页授权
     */
    function auth():Auth
    {
        if(!isset($this->auth)){
            $this->auth = new Auth($this);
        }
        return $this->auth;
    }

    /*
     * js sdk
     */
    function sdk():Sdk
    {
        if(!isset($this->sdk)){
            $this->sdk = new Sdk($this);
        }
        return $this->sdk;
    }
}