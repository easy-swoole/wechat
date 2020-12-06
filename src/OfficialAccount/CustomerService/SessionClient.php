<?php

namespace EasySwoole\WeChat\OfficialAccount\CustomerService;


use EasySwoole\WeChat\Kernel\ServiceProviders;
use EasySwoole\WeChat\Work\BaseClient;

class SessionClient extends BaseClient
{

    public function list(string $account)
    {
        $response = $this->getClient()
            ->setMethod('GET')
            ->send($this->buildUrl(
                '/customservice/kfsession/getsessionlist',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken(), 'kf_account' => $account])
            );

        $this->checkResponse($response, $parseData);

        return $parseData;
    }

    public function waiting()
    {
        $response = $this->getClient()
            ->setMethod('GET')
            ->send($this->buildUrl(
                '/customservice/kfsession/getwaitcase',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()])
            );

        $this->checkResponse($response, $parseData);

        return $parseData;
    }


    public function create(string $account, string $openid)
    {
        $params = [
            'kf_account' => $account,
            'openid' => $openid,
        ];

        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/customservice/kfsession/create',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()])
            );

        return $this->checkResponse($response);
    }


    public function close(string $account, string $openid)
    {
        $params = [
            'kf_account' => $account,
            'openid' => $openid,
        ];

        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/customservice/kfsession/close',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()])
            );

        return $this->checkResponse($response);
    }

    public function get(string $openid)
    {
        $response = $this->getClient()
            ->setMethod('GET')
            ->send($this->buildUrl(
                '/customservice/kfsession/getsession',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken(), 'openid' => $openid])
            );

        $this->checkResponse($response, $parseData);

        return $parseData;
    }
}