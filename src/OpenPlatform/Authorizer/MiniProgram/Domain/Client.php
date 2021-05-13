<?php

namespace EasySwoole\WeChat\OpenPlatform\Authorizer\MiniProgram\Domain;

use EasySwoole\WeChat\Kernel\Exceptions\HttpException;
use EasySwoole\WeChat\Kernel\ServiceProviders;
use EasySwoole\WeChat\OpenPlatform\BaseClient;

class Client extends BaseClient
{
    /**
     * 代小程序实现业务 - 基础信息设置 - 设置服务器域名
     * doc link: https://developers.weixin.qq.com/doc/oplatform/Third-party_Platforms/Mini_Programs/Server_Address_Configuration.html
     *
     * @param array $params
     * @return mixed
     * @throws HttpException
     */
    public function modify(array $params)
    {
        $response = $this->getClient()
            ->setMethod("POST")
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                "/wxa/modify_domain",
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        $this->checkResponse($response, $data);

        return $data;
    }

    /**
     * 代小程序实现业务 - 基础信息设置 - 设置业务域名
     * doc link: https://developers.weixin.qq.com/doc/oplatform/Third-party_Platforms/Mini_Programs/Server_Address_Configuration.html
     * 设置小程序业务域名
     *
     * @param array $domains
     * @param string $action
     * @return mixed
     * @throws HttpException
     */
    public function setWebviewDomain(array $domains, $action = 'add')
    {
        $response = $this->getClient()
            ->setMethod("POST")
            ->setBody($this->jsonDataToStream([
                'action' => $action,
                'webviewdomain' => $domains,
            ]))->send($this->buildUrl(
                "/wxa/setwebviewdomain",
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        return $this->checkResponse($response);
    }
}
