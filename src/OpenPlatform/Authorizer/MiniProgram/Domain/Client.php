<?php

namespace EasySwoole\WeChat\OpenPlatform\Authorizer\MiniProgram\Domain;

use EasySwoole\WeChat\Kernel\Exceptions\HttpException;
use EasySwoole\WeChat\Kernel\Psr\Stream;
use EasySwoole\WeChat\Kernel\ServiceProviders;
use EasySwoole\WeChat\OpenPlatform\BaseClient;

class Client extends BaseClient
{
    /**
     * 代小程序实现业务 - 小程序域名管理 - 配置小程序服务器域名
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
     * 代小程序实现业务 - 小程序域名管理 - 配置小程序业务域名
     * doc link: https://developers.weixin.qq.com/doc/oplatform/openApi/OpenApiDoc/miniprogram-management/domain-management/modifyJumpDomain.html
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

    /**
     * 代小程序实现业务 - 小程序域名管理 - 快速配置小程序服务器域名
     * doc link: https://developers.weixin.qq.com/doc/oplatform/openApi/OpenApiDoc/miniprogram-management/domain-management/modifyServerDomainDirectly.html
     * 快速配置小程序服务器域名
     *
     * @param array $domains
     * @param string $action
     * @return mixed
     * @throws HttpException
     */
    public function modifyServerDomainDirectly(array $params)
    {
        $response = $this->getClient()
            ->setMethod("POST")
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                "/wxa/modify_domain_directly",
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        return $this->checkResponse($response);
    }

    /**
     * 代小程序实现业务 - 小程序域名管理 - 获取业务域名校验文件
     * doc link: https://developers.weixin.qq.com/doc/oplatform/openApi/OpenApiDoc/miniprogram-management/domain-management/getJumpDomainConfirmFile.html
     * 获取业务域名校验文件
     *
     * @return mixed
     * @throws HttpException
     */
    public function getJumpDomainConfirmFile()
    {
        $response = $this->getClient()
            ->setMethod("POST")
            ->setBody(new Stream('{}'))
            ->send($this->buildUrl(
                "/wxa/get_webviewdomain_confirmfile",
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        $this->checkResponse($response, $data);

        return $data;
    }

    /**
     * 代小程序实现业务 - 小程序域名管理 - 快速配置小程序业务域名
     * doc link: https://developers.weixin.qq.com/doc/oplatform/openApi/OpenApiDoc/miniprogram-management/domain-management/modifyJumpDomainDirectly.html
     * 快速配置小程序业务域名
     *
     * @param array $domains
     * @param string $action
     * @return mixed
     * @throws HttpException
     */
    public function modifyJumpDomainDirectly(array $domains, $action = 'add')
    {
        $response = $this->getClient()
            ->setMethod("POST")
            ->setBody($this->jsonDataToStream([
                'action' => $action,
                'webviewdomain' => $domains,
            ]))->send($this->buildUrl(
                "/wxa/setwebviewdomain_directly",
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        $this->checkResponse($response, $data);

        return $data;
    }

    /**
     * 代小程序实现业务 - 小程序域名管理 - 获取发布后生效服务器域名列表
     * doc link: https://developers.weixin.qq.com/doc/oplatform/openApi/OpenApiDoc/miniprogram-management/domain-management/getEffectiveServerDomain.html
     * 获取发布后生效服务器域名列表
     *
     * @return mixed
     * @throws HttpException
     */
    public function getEffectiveServerDomain()
    {
        $response = $this->getClient()
            ->setMethod("POST")
            ->setBody(new Stream('{}'))
            ->send($this->buildUrl(
                "/wxa/get_effective_domain",
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        $this->checkResponse($response, $data);

        return $data;
    }

    /**
     * 代小程序实现业务 - 小程序域名管理 - 获取发布后生效业务域名列表
     * doc link: https://developers.weixin.qq.com/doc/oplatform/openApi/OpenApiDoc/miniprogram-management/domain-management/getEffectiveJumpDomain.html
     * 获取发布后生效业务域名列表
     *
     * @return mixed
     * @throws HttpException
     */
    public function getEffectiveJumpDomain()
    {
        $response = $this->getClient()
            ->setMethod("POST")
            ->setBody(new Stream('{}'))
            ->send($this->buildUrl(
                "/wxa/get_effective_webviewdomain",
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        $this->checkResponse($response, $data);

        return $data;
    }

    /**
     * 代小程序实现业务 - 小程序域名管理 - 获取 DNS 预解析域名
     * doc link: https://developers.weixin.qq.com/doc/oplatform/openApi/OpenApiDoc/miniprogram-management/domain-management/getPrefetchDomain.html
     * 获取 DNS 预解析域名
     *
     * @return mixed
     * @throws HttpException
     */
    public function getPrefetchDomain()
    {
        $response = $this->getClient()
            ->setMethod("GET")
            ->send($this->buildUrl(
                "/wxa/get_prefetchdnsdomain",
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        $this->checkResponse($response, $data);

        return $data;
    }

    /**
     * 代小程序实现业务 - 小程序域名管理 - 设置 DNS 预解析域名
     * doc link: https://developers.weixin.qq.com/doc/oplatform/openApi/OpenApiDoc/miniprogram-management/domain-management/setPrefetchDomain.html
     * 设置 DNS 预解析域名
     *
     * @param $prefetchDnsDomain
     * @return mixed
     * @throws HttpException
     */
    public function setPrefetchDomain(array $prefetchDnsDomain)
    {
        $response = $this->getClient()
            ->setMethod("POST")
            ->setBody($this->jsonDataToStream([
                'prefetch_dns_domain' => $prefetchDnsDomain,
            ]))
            ->send($this->buildUrl(
                "/wxa/set_prefetchdnsdomain",
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        return $this->checkResponse($response);
    }
}
