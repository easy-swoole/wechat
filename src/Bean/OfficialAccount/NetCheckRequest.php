<?php
/**
 * Created by PhpStorm.
 * User: yf
 * Date: 2018-12-30
 * Time: 12:14
 */

namespace EasySwoole\WeChat\Bean\OfficialAccount;


use EasySwoole\Spl\SplBean;

class NetCheckRequest extends SplBean
{
    const ACTION_ALL = 'all';
    const ACTION_DNS = 'dns';
    const ACTION_PING = 'ping';

    const OPERATOR_CHINANET = 'CHINANET';//电信出口
    const OPERATOR_UNICOM = 'UNICOM';//联通出口
    const OPERATOR_CAP = 'CAP';//腾讯自建出口
    const OPERATOR_DEFAULT = 'DEFAULT';//根据ip来选择运营商

    protected $action = 'all';
    protected $check_operator = 'DEFAULT';

    /**
     * @return string
     */
    public function getAction(): string
    {
        return $this->action;
    }

    /**
     * @param string $action
     */
    public function setAction(string $action): void
    {
        $this->action = $action;
    }

    /**
     * @return string
     */
    public function getCheckOperator(): string
    {
        return $this->check_operator;
    }

    /**
     * @param string $check_operator
     */
    public function setCheckOperator(string $check_operator): void
    {
        $this->check_operator = $check_operator;
    }


}