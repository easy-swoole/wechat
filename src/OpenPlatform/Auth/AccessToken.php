<?php

namespace EasySwoole\WeChat\OpenPlatform\Auth;

use EasySwoole\WeChat\Kernel\AccessToken as BaseAccessToken;
use EasySwoole\WeChat\Kernel\ServiceProviders;
use EasySwoole\WeChat\OpenPlatform\Application;

class AccessToken extends BaseAccessToken
{
    protected $requestMethod = 'POST';

    protected $responseTokenKey = 'component_access_token';

    /**
     * 第三方平台 - 获取令牌
     * doc link: https://developers.weixin.qq.com/doc/oplatform/Third-party_Platforms/api/component_access_token.html
     *
     * @return string
     */
    protected function getEndpoint(): string
    {
        return 'https://api.weixin.qq.com/cgi-bin/component/api_component_token';
    }

    /**
     * @return string
     */
    protected function getCredentials(): string
    {
        return json_encode([
            'component_appid' => $this->app[ServiceProviders::Config]->get('appId'),
            'component_appsecret' => $this->app[ServiceProviders::Config]->get('appSecret'),
            'component_verify_ticket' => $this->app[Application::VerifyTicket]->getTicket()
        ], JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_SLASHES);
    }
}
