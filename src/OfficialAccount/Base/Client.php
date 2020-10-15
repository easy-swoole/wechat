<?php


namespace EasySwoole\WeChat\OfficialAccount\Base;


use EasySwoole\WeChat\Kernel\BaseClient;
use EasySwoole\WeChat\Kernel\Exceptions\HttpException;
use EasySwoole\WeChat\Kernel\ServiceProviders;

class Client extends BaseClient
{
    /**
     * @return bool
     * @throws HttpException
     */
    public function clearQuota(): bool
    {
        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream(
                ['appid' => $this->app[ServiceProviders::Config]->get('appId')]
            ))->send($this->buildUrl(
                '/cgi-bin/clear_quota',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        return $this->checkResponse($response);
    }

    /**
     * @return array
     * @throws HttpException
     */
    public function getValidIps():array
    {
        $response = $this->getClient()
            ->setMethod('GET')
            ->send($this->buildUrl('/cgi-bin/getcallbackip',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        $this->checkResponse($response, $jsonData);
        return $jsonData;
    }
}