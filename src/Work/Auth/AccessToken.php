<?php


namespace EasySwoole\WeChat\Work\Auth;


use EasySwoole\WeChat\Kernel\AccessToken as BaseAccessToken;
use EasySwoole\WeChat\Kernel\ServiceProviders;

class AccessToken extends BaseAccessToken
{
    /**
     * @return string
     */
    protected function getEndpoint(): string
    {
        return 'https://api.weixin.qq.com/cgi-bin/gettoken?'. $this->getCredentials();
    }

    /**
     * @return string
     */
    protected function getCredentials(): string
    {
        return http_build_query([
            'corpid' => $this->app[ServiceProviders::Config]->get('corpId'),
            'corpsecret' => $this->app[ServiceProviders::Config]->get('corpSecret')
        ]);
    }
}