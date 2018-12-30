<?php
/**
 * Created by PhpStorm.
 * User: yf
 * Date: 2018/12/25
 * Time: 12:19 AM
 */

namespace EasySwoole\WeChat\OfficialAccount;


use EasySwoole\WeChat\Bean\OfficialAccount\User as UserBean;

class User extends OfficialAccountBase
{
    function remark(UserBean $user)
    {

    }

    function info(UserBean $user):?UserBean
    {

    }

    function list($next_openid = null)
    {

    }

    function blackList($begin_openid = null)
    {

    }

    function setBlack(UserBean $user)
    {

    }

    function setWhite(UserBean $user)
    {

    }
}