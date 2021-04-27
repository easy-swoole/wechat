<?php

namespace EasySwoole\WeChat\Work\OAuth;

use EasySwoole\WeChat\Kernel\ServiceProviders;
use EasySwoole\WeChat\Work\BaseClient;
use EasySwoole\WeChat\Work\OAuth\User\ExternalUser;
use EasySwoole\WeChat\Work\OAuth\User\User;

/**
 * doc link: https://open.work.weixin.qq.com/api/doc/90000/90135/91020
 *
 * Class Client
 * @package EasySwoole\WeChat\Work\OAuth
 * @Date: 2021/4/27 17:41
 * @author XueSi <1592328848@qq.com>
 */
class Client extends BaseClient
{
    const SCOPE_SNSAPI_BASE = 'snsapi_base';

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
     * @param string $state
     * @return Client
     */
    public function withState(string $state): Client
    {
        $oauth = clone $this;
        $oauth->state = $state;
        return $oauth;
    }

    /**
     * 构造网页授权链接
     * doc link: https://open.work.weixin.qq.com/api/doc/90000/90135/91022
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
                "appid" => $this->app[ServiceProviders::Config]->get('corpId'),
                "redirect_uri" => $redirectUri,
                "response_type" => "code",
                "scope" => $scope,
                "state" => $state,
            ]) . "#wechat_redirect";
    }

    /**
     * 获取访问用户身份
     * doc link: https://open.work.weixin.qq.com/api/doc/90000/90135/91023
     *
     * @param string $code
     * @return ExternalUser|User
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     * @date: 2021/4/27 20:10
     * @author XueSi <1592328848@qq.com>
     */
    public function userFromCode(string $code)
    {
        $response = $this->getClient()
            ->setMethod('GET')
            ->send($this->buildUrl(
                '/cgi-bin/user/getuserinfo',
                [
                    'access_token' => $this->app[ServiceProviders::AccessToken]->getToken(),
                    'code' => $code
                ]
            ));

        $this->checkResponse($response, $parseData);

        /**
         * 用户为 企业成员
         * {
         *     "errcode": 0,
         *     "errmsg": "ok",
         *     "UserId":"USERID",
         *     "DeviceId":"DEVICEID"
         * }
         *
         * 或者 用户为 非企业成员
         * {
         *     "errcode": 0,
         *     "errmsg": "ok",
         *     "OpenId":"OPENID",
         *     "DeviceId":"DEVICEID",
         *     "external_userid":"EXTERNAL_USERID"
         * }
         */

        if (isset($parseData['external_userid']) && !empty($parseData['external_userid'])) {
            return $this->mapExternalUserToObject($parseData)->setRaw($parseData);
        }

        return $this->mapUserToObject($parseData)->setRaw($parseData);
    }

    /**
     * @param array $user
     * @return User
     */
    protected function mapUserToObject(array $user): User
    {
        return new User([
            'userId' => $user['UserId'] ?? null,
            'deviceId' => $user['DeviceId'] ?? null,
        ]);
    }

    /**
     * @param array $user
     * @return User
     */
    protected function mapExternalUserToObject(array $user): ExternalUser
    {
        return new ExternalUser([
            'openId' => $user['OpenId'] ?? null,
            'deviceId' => $user['DeviceId'] ?? null,
            'externalUserId' => $user['external_userid'] ?? null,
        ]);
    }
}
