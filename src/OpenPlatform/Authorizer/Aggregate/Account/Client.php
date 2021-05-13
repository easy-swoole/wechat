<?php

namespace EasySwoole\WeChat\OpenPlatform\Authorizer\Aggregate\Account;

use EasySwoole\WeChat\Kernel\Exceptions\HttpException;
use EasySwoole\WeChat\Kernel\ServiceProviders;
use EasySwoole\WeChat\OpenPlatform\BaseClient;

class Client extends BaseClient
{
    /**
     * 微信开放平台账号管理 - 创建开放平台帐号并绑定公众号/小程序
     * doc link: https://developers.weixin.qq.com/doc/oplatform/Third-party_Platforms/api/account/create.html
     * @return mixed
     * @throws HttpException
     */
    public function create()
    {
        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream(
                [
                    'appid' => $this->app[ServiceProviders::Config]->get('appId'),
                ]
            ))->send($this->buildUrl(
                '/cgi-bin/open/create',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        $this->checkResponse($response, $data);
        return $data;
    }

    /**
     * 微信开放平台账号管理 - 将公众号/小程序绑定到开放平台帐号下
     * doc link: https://developers.weixin.qq.com/doc/oplatform/Third-party_Platforms/api/account/bind.html
     * @param string $openAppId
     * @return mixed
     * @throws HttpException
     */
    public function bindTo(string $openAppId)
    {
        $response = $this->getClient()
            ->setMethod("POST")
            ->setBody($this->jsonDataToStream([
                'appid' => $this->app[ServiceProviders::Config]->get('appId'),
                'open_appid' => $openAppId,
            ]))->send($this->buildUrl(
                '/cgi-bin/open/bind',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        return $this->checkResponse($response);
    }

    /**
     * 微信开放平台账号管理 - 将公众号/小程序从开放平台帐号下解绑
     * doc link: https://developers.weixin.qq.com/doc/oplatform/Third-party_Platforms/api/account/unbind.html
     * @param string $openAppId
     * @return mixed
     * @throws HttpException
     */
    public function unbindFrom(string $openAppId)
    {
        $response = $this->getClient()
            ->setMethod("POST")
            ->setBody($this->jsonDataToStream([
                'appid' => $this->app[ServiceProviders::Config]->get('appId'),
                'open_appid' => $openAppId,
            ]))->send($this->buildUrl(
                '/cgi-bin/open/unbind',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        return $this->checkResponse($response);
    }

    /**
     * 微信开放平台账号管理 - 获取公众号/小程序所绑定的开放平台帐号
     * doc link: https://developers.weixin.qq.com/doc/oplatform/Third-party_Platforms/api/account/get.html
     * @return mixed
     * @throws HttpException
     */
    public function getBinding()
    {
        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream(
                [
                    'appid' => $this->app[ServiceProviders::Config]->get('appId'),
                ]
            ))->send($this->buildUrl(
                '/cgi-bin/open/get',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        $this->checkResponse($response, $data);
        return $data;
    }
}
