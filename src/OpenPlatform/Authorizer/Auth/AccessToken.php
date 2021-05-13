<?php

namespace EasySwoole\WeChat\OpenPlatform\Authorizer\Auth;

use EasySwoole\WeChat\Kernel\AccessToken as BaseAccessToken;
use EasySwoole\WeChat\Kernel\ServiceContainer;
use EasySwoole\WeChat\Kernel\ServiceProviders;
use EasySwoole\WeChat\OpenPlatform\Application;

class AccessToken extends BaseAccessToken
{
    protected $requestMethod = 'POST';

    protected $responseTokenKey = 'authorizer_access_token';

    protected $component;

    /**
     * AccessToken constructor.
     * @param ServiceContainer $app
     * @param Application $component
     */
    public function __construct(ServiceContainer $app, Application $component)
    {
        parent::__construct($app);
        $this->component = $component;
    }

    /**
     * 获取公众号/小程序接口调用令牌
     * doc link: https://developers.weixin.qq.com/doc/oplatform/Third-party_Platforms/api/api_authorizer_token.html
     *
     * @return string
     */
    protected function getEndpoint(): string
    {
        return "https://api.weixin.qq.com/cgi-bin/component/api_authorizer_token?" . http_build_query([
                'component_access_token' => $this->component[ServiceProviders::AccessToken]->getToken(),
            ]);
    }

    /**
     * @return string
     */
    protected function getCredentials(): string
    {
        return json_encode([
            'component_appid' => $this->component[ServiceProviders::Config]->get('appId'),
            'authorizer_appid' => $this->app[ServiceProviders::Config]->get('appId'),
            'authorizer_refresh_token' => $this->app[ServiceProviders::Config]->get('refreshToken')
        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
    }
}
