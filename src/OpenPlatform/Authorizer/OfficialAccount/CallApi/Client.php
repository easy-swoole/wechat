<?php

namespace EasySwoole\WeChat\OpenPlatform\Authorizer\OfficialAccount\CallApi;

use EasySwoole\WeChat\Kernel\Exceptions\HttpException;
use EasySwoole\WeChat\Kernel\ServiceContainer;
use EasySwoole\WeChat\Kernel\ServiceProviders;
use EasySwoole\WeChat\OpenPlatform\Application;
use EasySwoole\WeChat\OpenPlatform\BaseClient;

class Client extends BaseClient
{
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
     * 代公众号实现业务 - 代公众号调用接口 - 对公众号的所有 API 调用（包括第三方代公众号调用）次数进行清零
     * doc link: https://developers.weixin.qq.com/doc/oplatform/Third-party_Platforms/Official_Accounts/Official_account_interface.html
     *
     * @return mixed
     * @throws HttpException
     */
    public function clearQuota()
    {
        $response = $this->getClient()
            ->setMethod("POST")
            ->setBody($this->jsonDataToStream([
                'appid' => $this->app[ServiceProviders::Config]->get('appId')
            ]))
            ->send($this->buildUrl(
                "/cgi-bin/clear_quota",
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        return $this->checkResponse($response);
    }

    /**
     * 代公众号实现业务 - 代公众号调用接口 - 第三方平台对其所有 API 调用次数清零（只与第三方平台相关，与公众号无关，接口如 api_component_token）
     * doc link: https://developers.weixin.qq.com/doc/oplatform/Third-party_Platforms/Official_Accounts/Official_account_interface.html
     *
     * @param string $componentAppId
     * @return bool
     * @throws HttpException
     */
    public function clearComponentQuota()
    {
        $response = $this->getClient()
            ->setMethod("POST")
            ->setBody($this->jsonDataToStream([
                'component_appid' => $this->component[ServiceProviders::Config]->get('componentAppId'),
            ]))->send($this->buildUrl(
                "/cgi-bin/component/clear_quota",
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        return $this->checkResponse($response);
    }
}
