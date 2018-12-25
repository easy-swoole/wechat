<?php
/**
 * Created by PhpStorm.
 * User: yf
 * Date: 2018/12/25
 * Time: 12:10 AM
 */

namespace EasySwoole\WeChat\OfficialAccount;


class ServiceBase
{
    private $officialAccount;

    function __construct(OfficialAccount $officialAccount)
    {
        $this->officialAccount = $officialAccount;;
    }

    protected function getOfficialAccount():OfficialAccount
    {
        return $this->officialAccount;
    }
}