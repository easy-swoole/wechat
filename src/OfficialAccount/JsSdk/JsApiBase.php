<?php
/**
 * Created by PhpStorm.
 * User: yf
 * Date: 2018-12-30
 * Time: 14:58
 */

namespace EasySwoole\WeChat\OfficialAccount\JsSdk;


use EasySwoole\WeChat\OfficialAccount\OfficialAccount;

class JsApiBase
{
    private $officialAccount;

    function __construct(OfficialAccount $account)
    {
        $this->officialAccount = $account;
    }

    /**
     * @return OfficialAccount
     */
    protected function getOfficialAccount(): OfficialAccount
    {
        return $this->officialAccount;
    }
}