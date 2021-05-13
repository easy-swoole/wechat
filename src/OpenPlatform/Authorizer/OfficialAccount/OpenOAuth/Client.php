<?php

namespace EasySwoole\WeChat\OpenPlatform\Authorizer\OfficialAccount\OpenOAuth;

use EasySwoole\WeChat\Kernel\ServiceContainer;
use EasySwoole\WeChat\Kernel\ServiceProviders;
use EasySwoole\WeChat\OpenPlatform\Application;
use EasySwoole\WeChat\OpenPlatform\BaseClient;
use EasySwoole\WeChat\Kernel\Exceptions\HttpException;

/**
 * 代公众号实现业务 - 代公众号发起网页授权
 *
 * Class Client
 * @package EasySwoole\WeChat\OpenPlatform\Authorizer\OfficialAccount\OpenOAuth
 * @author: XueSi
 * @email: <1592328848@qq.com>
 */
class Client extends BaseClient
{
    const SCOPE_SNSAPI_BASE = 'snsapi_base';
    const SCOPE_SNSAPI_USER_INFO = 'snsapi_userinfo';

    private $state;
    private $scopes;

    protected $component;

    /**
     * Client constructor.
     * @param ServiceContainer $app
     * @param Application $component
     */
    public function __construct(ServiceContainer $app, Application $component)
    {
        parent::__construct($app);

        $this->component = $component;
    }

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
     * 构建请求链接
     * doc link: https://developers.weixin.qq.com/doc/oplatform/Third-party_Platforms/Official_Accounts/official_account_website_authorization.html
     *
     * @param string $appId 公众号的 appid
     * @param string $redirectUri
     * @param string $componentAppid
     * @param $scope
     * @param string|null $state
     * @return string
     */
    public function redirect(string $redirectUri, $scope, string $state = null): string
    {
        /**
         * NOTE: 出于性能考虑建议直接使用此方法, 避免clone带来的额外性能开销
         */

        if (empty($scope)) {
            $scope = empty($this->scopes) ? [self::SCOPE_SNSAPI_BASE] : $this->scopes;
        }

        if (is_array($scope)) {
            $scope = join(',', $scope);
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
                "component_appid" => $this->component[ServiceProviders::Config]->get('componentAppId')
            ]) . "#wechat_redirect";
    }

    /**
     * 通过 code 换取 access_token 请求方法
     * doc link: https://developers.weixin.qq.com/doc/oplatform/Third-party_Platforms/Official_Accounts/official_account_website_authorization.html
     *
     * @param string $code
     * @return mixed
     * @throws HttpException
     */
    public function snsAuthFromCode(string $code)
    {
        $url = $this->buildUrl('/sns/oauth2/component/access_token', [
            "appid" => $this->app[ServiceProviders::Config]->get('appId'),
            "code" => $code,
            "grant_type" => "authorization_code",
            "component_appid" => $this->component[ServiceProviders::Config]->get('componentAppId'),
            "component_access_token" => $this->component[ServiceProviders::AccessToken]->getToken(),
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
     * 根据 code 获取用户信息
     *
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
     * 根据 token 获取用户信息
     *
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
         *   "privilege":[
         *     "PRIVILEGE1",
         *     "PRIVILEGE2"
         *   ],
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