<?php


namespace EasySwoole\WeChat\OpenPlatform\Base;


use EasySwoole\WeChat\Kernel\Exceptions\HttpException;
use EasySwoole\WeChat\Kernel\ServiceProviders;
use EasySwoole\WeChat\OpenPlatform\BaseClient;

class Client extends BaseClient
{
    /**
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
            'pre_auth_code' => $preAuthCode,
            'component_appid' => $this->app[ServiceProviders::Config]->get('appId'),
            'redirect_uri' => $callbackUrl,
            'action' => 'bindcomponent',
            'no_scan' => 1,
        ]);

        return 'https://mp.weixin.qq.com/safe/bindcomponent?' . http_build_query($queries) . '#wechat_redirect';
    }

    /**
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

    /**
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
