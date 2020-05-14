<?php
/**
 * Created by PhpStorm.
 * User: yf
 * Date: 2018/12/25
 * Time: 12:10 AM
 */

namespace EasySwoole\WeChat\OfficialAccount;


use EasySwoole\WeChat\Exception\OfficialAccountError;

class OfficialAccountBase
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

    /**
     * @param array $response
     * @return mixed
     * @throws OfficialAccountError
     */
    protected function hasException(array $response)
    {
        $ex = OfficialAccountError::hasException($response);
        if ($ex) {
            throw $ex;
        }
        return $response;
    }
}