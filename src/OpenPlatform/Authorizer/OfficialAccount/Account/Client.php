<?php

namespace EasySwoole\WeChat\OpenPlatform\Authorizer\OfficialAccount\Account;

use EasySwoole\WeChat\Kernel\Exceptions\HttpException;
use EasySwoole\WeChat\Kernel\ServiceContainer;
use EasySwoole\WeChat\Kernel\ServiceProviders;
use EasySwoole\WeChat\OpenPlatform\Application;
use EasySwoole\WeChat\OpenPlatform\Authorizer\Aggregate\Account\Client as BaseClient;

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
     * 从第三方平台跳转至微信公众平台授权注册页面, 授权注册小程序.
     * doc link: 找不到对应文档
     *
     * @param string $callbackUrl
     * @param bool $copyWxVerify
     *
     * @return string
     */
    public function getFastRegistrationUrl(string $callbackUrl, bool $copyWxVerify = true): string
    {
        $queries = [
            'copy_wx_verify' => $copyWxVerify,
            'component_appid' => $this->component[ServiceProviders::Config]->get('appId'),
            'appid' => $this->app[ServiceProviders::Config]->get('appId'),
            'redirect_uri' => $callbackUrl,
        ];

        return 'https://mp.weixin.qq.com/cgi-bin/fastregisterauth?' . http_build_query($queries);
    }

    /**
     * doc link: 找不到对应文档
     *
     * @param string $ticket
     * @return mixed
     * @throws HttpException
     */
    public function register(string $ticket)
    {
        $response = $this->getClient()
            ->setMethod("POST")
            ->setBody($this->jsonDataToStream([
                'ticket' => $ticket,
            ]))->send($this->buildUrl(
                '/cgi-bin/account/fastregister',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        $this->checkResponse($response, $data);
        return $data;
    }
}
