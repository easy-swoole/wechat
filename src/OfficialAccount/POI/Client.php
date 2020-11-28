<?php


namespace EasySwoole\WeChat\OfficialAccount\POI;


use EasySwoole\WeChat\Kernel\BaseClient;
use EasySwoole\WeChat\Kernel\ServiceProviders;

class Client extends BaseClient
{

    public function categories()
    {
        $response = $this->getClient()
            ->setMethod('GET')
            ->send($this->buildUrl(
                '/cgi-bin/poi/getwxcategory',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()])
            );

        $this->checkResponse($response, $parseData);

        return $parseData;
    }


    public function get(int $poiId)
    {
        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream(['poi_id' => $poiId]))
            ->send($this->buildUrl(
                '/cgi-bin/poi/getpoi',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()])
            );

        $this->checkResponse($response, $parseData);

        return $parseData;
    }


    public function list(int $offset = 0, int $limit = 10)
    {
        $params = [
            'begin' => $offset,
            'limit' => $limit,
        ];

        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/cgi-bin/poi/getpoilist',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()])
            );

        $this->checkResponse($response, $parseData);

        return $parseData;
    }

    public function create(array $baseInfo)
    {
        $params = [
            'business' => [
                'base_info' => $baseInfo,
            ],
        ];

        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/cgi-bin/poi/addpoi',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()])
            );

        $this->checkResponse($response, $parseData);

        return $parseData;
    }


    public function update(int $poiId, array $baseInfo)
    {
        $params = [
            'business' => [
                'base_info' => array_merge($baseInfo, ['poi_id' => $poiId]),
            ],
        ];

        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/cgi-bin/poi/updatepoi',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()])
            );

        return $this->checkResponse($response);
    }


    public function delete(int $poiId)
    {
        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream(['poi_id' => $poiId]))
            ->send($this->buildUrl(
                '/cgi-bin/poi/delpoi',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()])
            );

        return $this->checkResponse($response);
    }
}
