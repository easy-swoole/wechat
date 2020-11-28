<?php


namespace EasySwoole\WeChat\OfficialAccount\Semantic;


use EasySwoole\WeChat\Kernel\BaseClient;
use EasySwoole\WeChat\Kernel\ServiceProviders;

class Client extends BaseClient
{
    public function query(string $keyword, string $categories, array $optional = [])
    {
        $params = [
            'query' => $keyword,
            'category' => $categories,
            'appid' => $this->app->getConfig()['appId'],
        ];

        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream(array_merge($params, $optional)))
            ->send($this->buildUrl(
                '/semantic/semproxy/search',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()])
            );

        $this->checkResponse($response, $parseData);

        return $parseData;
    }
}