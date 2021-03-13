<?php


namespace EasySwoole\WeChat\OpenPlatform\Authorizer\Aggregate\Account;


use EasySwoole\WeChat\Kernel\Exceptions\HttpException;
use EasySwoole\WeChat\Kernel\ServiceProviders;
use EasySwoole\WeChat\OpenPlatform\BaseClient;

class Client extends BaseClient
{
    /**
     * @return mixed
     * @throws HttpException
     */
    public function create()
    {
        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream(
                [
                    'appid' => $this->app[ServiceProviders::Config]->get('appId'),
                ]
            ))->send($this->buildUrl(
                '/cgi-bin/open/create',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        $this->checkResponse($response, $data);
        return $data;
    }

    /**
     * @param string $openAppId
     * @return mixed
     * @throws HttpException
     */
    public function bindTo(string $openAppId)
    {
        $response = $this->getClient()
            ->setMethod("POST")
            ->setBody($this->jsonDataToStream([
                'appid' => $this->app[ServiceProviders::Config]->get('appId'),
                'open_appid' => $openAppId,
            ]))->send($this->buildUrl(
                '/cgi-bin/open/bind',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        $this->checkResponse($response, $data);
        return $data;
    }

    /**
     * @param string $openAppId
     * @return mixed
     * @throws HttpException
     */
    public function unbindFrom(string $openAppId)
    {
        $response = $this->getClient()
            ->setMethod("POST")
            ->setBody($this->jsonDataToStream([
                'appid' => $this->app[ServiceProviders::Config]->get('appId'),
                'open_appid' => $openAppId,
            ]))->send($this->buildUrl(
                '/cgi-bin/open/unbind',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        $this->checkResponse($response, $data);
        return $data;
    }

    /**
     * @return mixed
     * @throws HttpException
     */
    public function getBinding()
    {
        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream(
                [
                    'appid' => $this->app[ServiceProviders::Config]->get('appId'),
                ]
            ))->send($this->buildUrl(
                '/cgi-bin/open/get',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        $this->checkResponse($response, $data);
        return $data;
    }
}
