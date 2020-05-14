<?php
/**
 * Created by PhpStorm.
 * User: yf
 * Date: 2018-12-30
 * Time: 14:58
 */

namespace EasySwoole\WeChat\OfficialAccount\JsSdk;


use EasySwoole\WeChat\Bean\OfficialAccount\JsAuthRequest;
use EasySwoole\WeChat\Bean\OfficialAccount\SnsAuthBean;
use EasySwoole\WeChat\Bean\OfficialAccount\User;
use EasySwoole\WeChat\Exception\OfficialAccountError;
use EasySwoole\WeChat\OfficialAccount\ApiUrl;
use EasySwoole\WeChat\Utility\NetWork;

class Auth extends JsApiBase
{
    /**
     * 获取授权跳转链接
     * @param JsAuthRequest $request
     * @return string
     */
    function generateURL(JsAuthRequest $request)
    {
        $officialAccountConfig = $this->getOfficialAccount()->getConfig();
        $appid = $officialAccountConfig->getAppId();
        $scope = $request->getType();
        $state = $request->getState();
        $redirect_uri = urlencode($request->getRedirectUri());
        return ApiUrl::generateURL(ApiUrl::JSAPI_AUTHORIZE, [
            'APPID' => $appid,
            'REDIRECT_URI' => $redirect_uri,
            'SCOPE' => $scope,
            'STATE' => $state
        ]);
    }

    /**
     * 授权CODE换取用户令牌
     * @param $authCode
     * @return SnsAuthBean|null
     * @throws OfficialAccountError
     * @throws \EasySwoole\WeChat\Exception\RequestError
     */
    function codeToToken($authCode): ?SnsAuthBean
    {
        $officialAccountConfig = $this->getOfficialAccount()->getConfig();
        $appid = $officialAccountConfig->getAppId();
        $secret = $officialAccountConfig->getAppSecret();
        $response = NetWork::getForJson(ApiUrl::generateURL(ApiUrl::JSAPI_CODE_TO_TOKEN, [
            'APPID' => $appid,
            'SECRET' => $secret,
            'CODE' => $authCode
        ]));
        $ex = OfficialAccountError::hasException($response);
        if ($ex) {
            throw $ex;
        } else {
            return new SnsAuthBean($response);
        }
    }

    /**
     * 用户令牌获取用户信息
     * @param SnsAuthBean $authBean
     * @return User|null
     * @throws OfficialAccountError
     * @throws \EasySwoole\WeChat\Exception\RequestError
     */
    function tokenToUser(SnsAuthBean $authBean): ?User
    {
        $response = NetWork::getForJson(ApiUrl::generateURL(ApiUrl::JSAPI_SNS_USERINFO, [
            'ACCESS_TOKEN' => $authBean->getAccessToken(),
            'OPENID' => $authBean->getOpenid(),
        ]));
        $ex = OfficialAccountError::hasException($response);
        if ($ex) {
            throw $ex;
        } else {
            return new User($response);
        }
    }

    /**
     * 授权CODE获取用户信息
     * @param $authCode
     * @return User|null
     * @throws OfficialAccountError
     * @throws \EasySwoole\WeChat\Exception\RequestError
     */
    function codeToUser($authCode): ?User
    {
        $authBean = $this->codeToToken($authCode);
        return $this->tokenToUser($authBean);
    }

    /**
     * 刷新用户令牌
     * @param $refreshToken
     * @return SnsAuthBean
     * @throws OfficialAccountError
     * @throws \EasySwoole\WeChat\Exception\RequestError
     */
    function refreshToken($refreshToken)
    {
        $officialAccountConfig = $this->getOfficialAccount()->getConfig();
        $appid = $officialAccountConfig->getAppId();
        $response = NetWork::getForJson(ApiUrl::generateURL(ApiUrl::JSAPI_REFRESH_TOKEN, [
            'APPID' => $appid,
            'REFRESH_TOKEN' => $refreshToken,
        ]));
        $ex = OfficialAccountError::hasException($response);
        if ($ex) {
            throw $ex;
        } else {
            return new SnsAuthBean($response);
        }
    }


    /**
     * 授权凭证是否有效
     * @param SnsAuthBean $authBean
     * @return SnsAuthBean|bool
     * @throws OfficialAccountError
     * @throws \EasySwoole\WeChat\Exception\RequestError
     */
    function authCheck(SnsAuthBean $authBean)
    {
        $response = NetWork::getForJson(ApiUrl::generateURL(ApiUrl::JSAPI_SNS_AUTH_CHECK, [
            'OPENID' => $authBean->getOpenid(),
            'ACCESS_TOKEN' => $authBean->getAccessToken(),
        ]));
        $ex = OfficialAccountError::hasException($response);
        if ($ex) {
            throw $ex;
        } else {
            return true;
        }
    }
}