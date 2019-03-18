<?php
/**
 * Created by PhpStorm.
 * User: eValor
 * Date: 2019-03-18
 * Time: 10:52
 */

namespace EasySwoole\WeChat\OpenPlatform;

use EasySwoole\WeChat\Bean\OpenPlatform\AuthRequest;
use EasySwoole\WeChat\Bean\OpenPlatform\SnsAuthBean;
use EasySwoole\WeChat\Bean\OpenPlatform\User;

class Auth extends OpenPlatformBase
{
    /**
     * 获取授权跳转链接
     * @param AuthRequest $request
     * @return string
     */
    function generateURL(AuthRequest $request): string
    {

    }

    /**
     * 换取访问令牌
     * @param $authCode
     * @return SnsAuthBean
     */
    function codeToToken($authCode): SnsAuthBean
    {

    }

    /**
     * 获取用户信息
     * @param SnsAuthBean $authBean
     * @return User
     */
    function tokenToUser(SnsAuthBean $authBean): User
    {

    }

    /**
     * CODE直接获取用户信息
     * @return User
     */
    function codeToUser(): User
    {

    }

    /**
     * 刷新访问令牌有效期
     * @param $refreshToken
     */
    function refreshToken($refreshToken)
    {

    }

    /**
     * 确认访问令牌是否有效
     * @param SnsAuthBean $authBean
     */
    function authCheck(SnsAuthBean $authBean)
    {

    }
}