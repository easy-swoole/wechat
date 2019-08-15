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

    /**
     * session2code
     *
     * @param string $code
     * @return array
     * @throws OpenPlatformError
     * @throws RequestError
     * @throws \EasySwoole\HttpClient\Exception\InvalidUrl
     */
    public function session(string $code): array
    {
        $accessToken = $this->getOpenPlatform()->accessToken()->getComponentAccessToken();
        $config = $this->getOpenPlatform()->getConfig();
        $data = [
            'appid'  => $config->getAppId(),
            'js_code' => $code,
            'grant_type' => 'authorization_code',
            'component_appid' => $config->getComponentAppId(),
            'component_access_token' => $accessToken,
        ];
        $responseArray = NetWork::getForJson(ApiUrl::COMPONENT_AUTH_CODE2SESSION, $data);
        $ex = OpenPlatformError::hasException($responseArray);
        if ($ex) {
            throw $ex;
        }

        return $responseArray;
    }
}