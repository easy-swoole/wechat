<?php


namespace EasySwoole\WeChat\Work\Agent;


use EasySwoole\WeChat\Kernel\Exceptions\HttpException;
use EasySwoole\WeChat\Kernel\ServiceProviders;
use EasySwoole\WeChat\Work\BaseClient;

class Client extends BaseClient
{
    /**
     * 获取应用
     * Get agent.
     * doc link: https://work.weixin.qq.com/api/doc/90000/90135/90227#获取应用
     *
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
     * 设置应用
     * Set agent.
     * doc link: https://work.weixin.qq.com/api/doc/90000/90135/90228
     *
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

        return $this->checkResponse($response, $jsonData);
    }

    /**
     * 获取access_token对应的应用列表
     * doc link: https://work.weixin.qq.com/api/doc/90000/90135/90227#获取access_token对应的应用列表
     *
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