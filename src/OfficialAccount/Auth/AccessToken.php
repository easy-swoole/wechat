<?php

namespace EasySwoole\WeChat\OfficialAccount\Auth;

use EasySwoole\WeChat\Kernel\AccessToken as BaseAccessToken;
use EasySwoole\WeChat\Kernel\ServiceProviders;

class AccessToken extends BaseAccessToken
{
    /**
     * 获取 AccessToken
     * doc link: https://developers.weixin.qq.com/doc/offiaccount/Basic_Information/Get_access_token.html
     *
     * @return string
     */
    protected function getEndpoint(): string
    {
        return 'https://api.weixin.qq.com/cgi-bin/token?'. $this->getCredentials();
    }

    /**
     * @return string
     */
    protected function getCredentials(): string
    {
        return http_build_query([
            'grant_type' => 'client_credential',
            'appid' => $this->app[ServiceProviders::Config]->get('appId'),
            'secret' => $this->app[ServiceProviders::Config]->get('appSecret')
        ]);
    }
}