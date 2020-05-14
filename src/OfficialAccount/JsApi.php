<?php
/**
 * Created by PhpStorm.
 * User: yf
 * Date: 2018-12-30
 * Time: 14:57
 */

namespace EasySwoole\WeChat\OfficialAccount;


use EasySwoole\WeChat\OfficialAccount\JsSdk\Auth;
use EasySwoole\WeChat\OfficialAccount\JsSdk\JsSdk;

class JsApi extends OfficialAccountBase
{
    private $auth;
    private $sdk;

    function auth()
    {
        if (!isset($this->auth)) {
            $this->auth = new Auth($this->getOfficialAccount());
        }
        return $this->auth;
    }

    function sdk()
    {
        if (!isset($this->sdk)) {
            $this->sdk = new JsSdk($this->getOfficialAccount());
        }
        return $this->sdk;
    }
}