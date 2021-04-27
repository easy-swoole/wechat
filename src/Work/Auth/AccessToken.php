<?php


namespace EasySwoole\WeChat\Work\Auth;


use EasySwoole\WeChat\Kernel\AccessToken as BaseAccessToken;
use EasySwoole\WeChat\Kernel\ServiceProviders;

class AccessToken extends BaseAccessToken
{
    /**
     * doc link: https://work.weixin.qq.com/api/doc/90000/90135/91039
     * @return string
     */
    protected function getEndpoint(): string
    {
        return 'https://qyapi.weixin.qq.com/cgi-bin/gettoken?'. $this->getCredentials();
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