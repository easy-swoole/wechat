<?php

namespace EasySwoole\WeChat\OfficialAccount\OAuth;

use EasySwoole\WeChat\Kernel\BaseClient;
use EasySwoole\WeChat\Kernel\Exceptions\HttpException;
use EasySwoole\WeChat\Kernel\ServiceProviders;

class Client extends BaseClient
{
    const SCOPE_SNSAPI_BASE = 'snsapi_base';
    const SCOPE_SNSAPI_USER_INFO = 'snsapi_userinfo';

    private $state;
    private $scopes;

    /**
     * @param array|string[] $scopes
     * @return Client
     */
    public function scopes(array $scopes = [self::SCOPE_SNSAPI_BASE])
    {
        $oauth = clone $this;
        $oauth->scopes = $scopes;
        return $oauth;
    }

    /**
     * 构建授权连接
     * doc link: https://developers.weixin.qq.com/doc/offiaccount/OA_Web_Apps/Wechat_webpage_authorization.html
     *
     * @param string $redirectUri
     * @param string|null $scope
     * @param string|null $state
     * @return string
     */
    public function redirect(string $redirectUri, string $scope = null, string $state = null): string
    {
        /**
         * NOTE: 出于性能考虑建议直接使用此方法, 避免clone带来的额外性能开销
         */

        if (empty($scope)) {
            $scope = empty($this->scopes) ? self::SCOPE_SNSAPI_BASE : array_shift($this->scopes);
        }

        if (empty($state)) {
            $state = $this->state ?? '';
        }

        return "https://open.weixin.qq.com/connect/oauth2/authorize?" . http_build_query([
                "appid" => $this->app[ServiceProviders::Config]->get('appId'),
                "redirect_uri" => $redirectUri,
                "response_type" => "code",
                "scope" => $scope,
                "state" => $state,
            ]) . "#wechat_redirect";
    }

    /**
     * @param string $code
     * @return mixed
     * @throws HttpException
     */
    public function snsAuthFromCode(string $code)
    {
        $url = $this->buildUrl('/sns/oauth2/access_token', [
            "appid" => $this->app[ServiceProviders::Config]->get('appId'),
            "secret" => $this->app[ServiceProviders::Config]->get('appSecret'),
            "code" => $code,
            "grant_type" => "authorization_code"
        ]);

        $response = $this->getClient()->setMethod("GET")->send($url);
        $this->checkResponse($response, $jsonData);

        /**
         * {
         *    "access_token":"ACCESS_TOKEN",
         *    "expires_in":7200,
         *    "refresh_token":"REFRESH_TOKEN",
         *    "openid":"OPENID",
         *    "scope":"SCOPE"
         * }
         */
        return $jsonData;
    }

    /**
     * @param string $code
     * @param string $lang
     * @return User
     * @throws HttpException
     */
    public function userFromCode(string $code, string $lang = 'zh_CN'): User
    {
        $authData = $this->snsAuthFromCode($code);

        return $this->userFromToken($authData['access_token'], $authData['openid'], $lang)->setTokenResponse($authData);
    }

    /**
     * @param string $token
     * @param string $openId
     * @param string $lang
     * @return User
     * @throws HttpException
     */
    public function userFromToken(string $token, string $openId, string $lang = 'zh_CN'): User
    {
        $url = $this->buildUrl('/sns/userinfo', [
            "access_token" => $token,
            "openid" => $openId,
            "lang" => $lang
        ]);

        $response = $this->getClient()->setMethod("GET")->send($url);
        $this->checkResponse($response, $jsonData);

        /**
         * {
         *   "openid":" OPENID",
         *   "nickname": NICKNAME,
         *   "sex":"1",
         *   "province":"PROVINCE",
         *   "city":"CITY",
         *   "country":"COUNTRY",
         *   "headimgurl":"https://thirdwx.qlogo.cn/mmopen/g3MonUZtNHkdmzicIlibx6iaFqAc56vxLSUfpb6n5WKSYVY0ChQKkiaJSgQ1dZuTOgvLLrhJbERQQ4eMsv84eavHiaiceqxibJxCfHe/46",
         *   "privilege":[ "PRIVILEGE1" "PRIVILEGE2"     ],
         *   "unionid": "o6_bmasdasdsad6_2sgVt7hMZOPfL"
         * }
         */

        return $this->mapUserToObject($jsonData)->setRaw($jsonData)->setAccessToken($token);
    }

    /**
     * @param array $user
     * @return User
     */
    protected function mapUserToObject(array $user): User
    {
        return new User([
            'id' => $user['openid'] ?? null,
            'name' => $user['nickname'] ?? null,
            'nickname' => $user['nickname'] ?? null,
            'avatar' => $user['headimgurl'] ?? null,
        ]);
    }

    /**
     * @param string $state
     * @return Client
     */
    public function withState(string $state): Client
    {
        $oauth = clone $this;
        $oauth->state = $state;
        return $oauth;
    }


}
