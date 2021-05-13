<?php

namespace EasySwoole\WeChat\OpenPlatform\Base;

use EasySwoole\WeChat\Kernel\Exceptions\HttpException;
use EasySwoole\WeChat\Kernel\ServiceProviders;
use EasySwoole\WeChat\OpenPlatform\BaseClient;

class Client extends BaseClient
{
    /**
     * 第三方平台接口 - 获取预授权码
     * doc link: https://developers.weixin.qq.com/doc/oplatform/Third-party_Platforms/api/pre_auth_code.html
     *
     * @return mixed
     * @throws HttpException
     */
    public function createPreAuthorizationCode()
    {
        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream(
                [
                    'component_appid' => $this->app[ServiceProviders::Config]->get('appId'),
                ]
            ))->send($this->buildUrl(
                '/cgi-bin/component/api_create_preauthcode',
                ['component_access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        $this->checkResponse($response, $data);

        return $data;
    }

    /**
     * 扫码授权
     * doc link: https://developers.weixin.qq.com/community/develop/article/doc/0004ca6ed5450898e5c87951158413
     *
     * @param string $callbackUrl
     * @param string|null $preAuthCode
     * @param array $optional
     * @return string
     * @throws HttpException
     */
    public function getPreAuthorizationUrl(string $callbackUrl, ?string $preAuthCode = null, array $optional = [])
    {
        if (is_null($preAuthCode)) {
            $preAuthCode = $this->createPreAuthorizationCode()['pre_auth_code'];
        }

        $queries = array_merge($optional, [
            'pre_auth_code' => $preAuthCode,
            'component_appid' => $this->app[ServiceProviders::Config]->get('appId'),
            'redirect_uri' => $callbackUrl,
        ]);
        return 'https://mp.weixin.qq.com/cgi-bin/componentloginpage?' . http_build_query($queries);
    }

    /**
     * 点击移动端链接快速授权
     * doc link: https://developers.weixin.qq.com/community/develop/article/doc/0004ca6ed5450898e5c87951158413
     *
     * @param string $callbackUrl
     * @param string|null $preAuthCode
     * @param array $optional
     * @return string
     * @throws HttpException
     */
    public function getMobilePreAuthorizationUrl(string $callbackUrl, ?string $preAuthCode = null, array $optional = [])
    {
        if (is_null($preAuthCode)) {
            $preAuthCode = $this->createPreAuthorizationCode()['pre_auth_code'];
        }

        $queries = array_merge($optional, [
            'auth_type' => 3,
            'pre_auth_code' => $preAuthCode,
            'component_appid' => $this->app[ServiceProviders::Config]->get('appId'),
            'redirect_uri' => $callbackUrl,
            'action' => 'bindcomponent',
            'no_scan' => 1,
        ]);

        return 'https://mp.weixin.qq.com/safe/bindcomponent?' . http_build_query($queries) . '#wechat_redirect';
    }

    /**
     * 第三方平台接口 - 使用授权码获取授权信息
     * 使用授权码换取公众号或小程序的接口调用凭据和授权信息
     * doc link: https://developers.weixin.qq.com/doc/oplatform/Third-party_Platforms/api/authorization_info.html
     *
     * @param string $authCode
     * @return mixed
     * @throws HttpException
     */
    public function handleAuthorize(string $authCode)
    {
        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream(
                [
                    'component_appid' => $this->app[ServiceProviders::Config]->get('appId'),
                    'authorization_code' => $authCode
                ]
            ))->send($this->buildUrl(
                '/cgi-bin/component/api_query_auth',
                ['component_access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        $this->checkResponse($response, $data);
        return $data;
    }

    // 获取/刷新接口调用令牌接口 在组件基础中已封装

    /**
     * 第三方平台接口 - 获取授权方的帐号基本信息
     * doc link: https://developers.weixin.qq.com/doc/oplatform/Third-party_Platforms/api/api_get_authorizer_info.html
     *
     * @param string $appId
     * @return bool
     * @throws HttpException
     */
    public function getAuthorizer(string $appId)
    {
        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream(
                [
                    'component_appid' => $this->app[ServiceProviders::Config]->get('appId'),
                    'authorizer_appid' => $appId
                ]
            ))->send($this->buildUrl(
                '/cgi-bin/component/api_get_authorizer_info',
                ['component_access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        $this->checkResponse($response, $parseData);
        return $parseData;
    }

    /**
     * 第三方平台接口 - 获取授权方选项信息
     * doc link: https://developers.weixin.qq.com/doc/oplatform/Third-party_Platforms/api/api_get_authorizer_option.html
     *
     * @param string $appId
     * @param string $name
     * @return mixed
     * @throws HttpException
     */
    public function getAuthorizerOption(string $appId, string $name)
    {
        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream(
                [
                    'component_appid' => $this->app[ServiceProviders::Config]->get('appId'),
                    'authorizer_appid' => $appId,
                    'option_name' => $name,
                ]
            ))->send($this->buildUrl(
                '/cgi-bin/component/api_get_authorizer_option',
                ['component_access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        $this->checkResponse($response, $data);
        return $data;
    }

    /**
     * 第三方平台接口 - 设置授权方选项信息
     * doc link: https://developers.weixin.qq.com/doc/oplatform/Third-party_Platforms/api/api_set_authorizer_option.html
     *
     * @param string $appId
     * @param string $name
     * @param string $value
     * @return bool
     * @throws HttpException
     */
    public function setAuthorizerOption(string $appId, string $name, string $value)
    {
        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream(
                [
                    'component_appid' => $this->app[ServiceProviders::Config]->get('appId'),
                    'authorizer_appid' => $appId,
                    'option_name' => $name,
                    'option_value' => $value,
                ]
            ))->send($this->buildUrl(
                '/cgi-bin/component/api_set_authorizer_option',
                ['component_access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        return $this->checkResponse($response);
    }

    /**
     * 第三方平台接口 - 拉取所有已授权的帐号信息
     * doc link: https://developers.weixin.qq.com/doc/oplatform/Third-party_Platforms/api/api_get_authorizer_list.html
     *
     * @param int $offset
     * @param int $count
     * @return mixed
     * @throws HttpException
     */
    public function getAuthorizers(int $offset = 0, int $count = 500)
    {
        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream(
                [
                    'component_appid' => $this->app[ServiceProviders::Config]->get('appId'),
                    'offset' => $offset,
                    'count' => $count,
                ]
            ))->send($this->buildUrl(
                '/cgi-bin/component/api_get_authorizer_list',
                ['component_access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        $this->checkResponse($response, $data);
        return $data;
    }

    /**
     * doc link: 未找到对应的接口文档
     *
     * @return bool
     * @throws HttpException
     */
    public function clearQuota()
    {
        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream(
                [
                    'component_appid' => $this->app[ServiceProviders::Config]->get('appId'),
                ]
            ))->send($this->buildUrl(
                '/cgi-bin/component/clear_quota',
                ['component_access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        return $this->checkResponse($response);
    }
}
