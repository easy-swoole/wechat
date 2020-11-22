<?php


namespace EasySwoole\WeChat\Work\Agent;


use EasySwoole\WeChat\Kernel\Exceptions\HttpException;
use EasySwoole\WeChat\Kernel\ServiceProviders;
use EasySwoole\WeChat\Work\BaseClient;

class Client extends BaseClient
{
    /**
     * @param int $agentId
     * @return array
     * @throws HttpException
     */
    public function get(int $agentId)
    {
        $response = $this->getClient()
            ->setMethod('GET')
            ->send($this->buildUrl(
                '/cgi-bin/agent/get',
                [
                    'agentid' => $agentId,
                    'access_token' => $this->app[ServiceProviders::AccessToken]->getToken()
                ]
            ));

        $this->checkResponse($response, $jsonData);
        return $jsonData;
    }

    /**
     * @param int $agentId
     * @param array $attributes
     * @return mixed
     * @throws HttpException
     */
    public function set(int $agentId, array $attributes)
    {
        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream([
                array_merge(['agentid' => $agentId], $attributes)
            ]))
            ->send($this->buildUrl('/cgi-bin/agent/set',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        $this->checkResponse($response, $jsonData);
        return $jsonData;
    }

    /**
     * @return mixed
     * @throws HttpException
     */
    public function list()
    {
        $response = $this->getClient()
            ->setMethod('GET')
            ->send($this->buildUrl(
                '/cgi-bin/agent/list',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        $this->checkResponse($response, $jsonData);
        return $jsonData;
    }
}