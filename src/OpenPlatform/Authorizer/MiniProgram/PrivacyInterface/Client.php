<?php

namespace EasySwoole\WeChat\OpenPlatform\Authorizer\MiniProgram\PrivacyInterface;

use EasySwoole\WeChat\Kernel\ServiceProviders;
use EasySwoole\WeChat\OpenPlatform\BaseClient;

class Client extends BaseClient
{
    /**
     * 代小程序实现业务 - 申请隐私接口 - 获取接口列表
     * doc link: https://developers.weixin.qq.com/doc/oplatform/Third-party_Platforms/2.0/api/apply_api/get_privacy_interface.html
     *
     * @return bool
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function get()
    {
        $response = $this->getClient()
            ->setMethod("GET")
            ->send($this->buildUrl(
                "/wxa/security/get_privacy_interface",
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        $this->checkResponse($response, $jsonData);

        return $jsonData;
    }

    /**
     * 代小程序实现业务 - 申请隐私接口 - 申请接口
     * doc link: https://developers.weixin.qq.com/doc/oplatform/Third-party_Platforms/2.0/api/apply_api/apply_privacy_interface.html
     *
     * @param array $params
     *
     * @return bool
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function apply(array $params)
    {
        $response = $this->getClient()
            ->setMethod("POST")
            ->setHeaders(['content-type' => 'application/json'])
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                "/wxa/security/apply_privacy_interface",
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        $this->checkResponse($response, $jsonData);

        return $jsonData;
    }
}