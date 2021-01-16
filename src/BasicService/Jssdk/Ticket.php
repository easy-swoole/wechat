<?php


namespace EasySwoole\WeChat\BasicService\Jssdk;


use EasySwoole\WeChat\Kernel\AccessToken;
use EasySwoole\WeChat\Kernel\ServiceContainer;
use EasySwoole\WeChat\Kernel\ServiceProviders;

class Ticket extends AccessToken
{
    /** @var ServiceContainer */
    protected $app;

    /** @var string */
    protected $cachePrefix = 'easyswoole_wechat_js_ticket_';

    /** @var string */
    protected $responseTokenKey = 'ticket';

    /**
     * @return string
     */
    protected function getEndpoint(): string
    {
        return 'https://api.weixin.qq.com/cgi-bin/ticket/getticket?' . http_build_query([
                'access_token' => $this->app[ServiceProviders::AccessToken]->getToken(),
                'type' => 'jsapi'
            ]);
    }

    /**
     * @return string
     */
    protected function getCredentials(): string
    {
        return $this->app[ServiceProviders::Config]->get('appId');
    }
}