<?php

namespace EasySwoole\WeChat\Work\QrConnect;

use EasySwoole\WeChat\Kernel\ServiceProviders;
use EasySwoole\WeChat\Work\BaseClient;
use EasySwoole\WeChat\Work\QrConnect\User\ExternalUser;
use EasySwoole\WeChat\Work\QrConnect\User\User;

/**
 * doc link: https://open.work.weixin.qq.com/api/doc/90000/90135/90988
 *
 * Class Client
 * @package EasySwoole\WeChat\Work\QrConnect
 * @Date: 2021/4/27 18:10
 * @author XueSi <1592328848@qq.com>
 */
class Client extends BaseClient
{
    private $state;

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
     * 构造独立窗口登录二维码
     * doc link: https://open.work.weixin.qq.com/api/doc/90000/90135/91019
     *
     * @param string $redirectUri
     * @param string|null $scope
     * @param string|null $state
     * @return string
     */
    public function redirect(string $redirectUri, string $state = null): string
    {
        /**
         * NOTE: 出于性能考虑建议直接使用此方法, 避免clone带来的额外性能开销
         */
        if (empty($state)) {
            $state = $this->state ?? '';
        }

        return "https://open.work.weixin.qq.com/wwopen/sso/qrConnect?" . http_build_query([
                "appid" => $this->app[ServiceProviders::Config]->get('corpId'),
                "agentid" => $this->app[ServiceProviders::Config]->get('agentId'),
                "redirect_uri" => $redirectUri,
                "state" => $state,
            ]);
    }

    /**
     * 获取访问用户身份
     * doc link: https://open.work.weixin.qq.com/api/doc/90000/90135/91437
     *
     *
     * @param string $code
     * @return ExternalUser|User
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     * @date: 2021/4/27 20:16
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
         *     "UserId":"USERID"
         * }
         *
         * 或者 用户为 非企业成员
         * {
         *     "errcode": 0,
         *     "errmsg": "ok",
         *     "OpenId":"OPENID"
         * }
         */

        if (isset($parseData['OpenId']) && !empty($parseData['OpenId'])) {
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
        ]);
    }
}
