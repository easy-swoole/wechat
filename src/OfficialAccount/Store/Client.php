<?php

namespace EasySwoole\WeChat\OfficialAccount\Store;


use EasySwoole\WeChat\Kernel\BaseClient;
use EasySwoole\WeChat\Kernel\Exceptions\HttpException;
use EasySwoole\WeChat\Kernel\ServiceProviders;

class Client extends BaseClient
{

    /**
     * @return mixed
     * @throws HttpException
     */
    public function categories()
    {
        $response = $this->getClient()
            ->setMethod('GET')
            ->send($this->buildUrl(
                '/wxa/get_merchant_category',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        $this->checkResponse($response, $parseData);

        return $parseData;
    }

    /**
     * @return mixed
     * @throws HttpException
     */
    public function districts()
    {
        $response = $this->getClient()
            ->setMethod('GET')
            ->send($this->buildUrl(
                '/wxa/get_district',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        $this->checkResponse($response, $parseData);

        return $parseData;
    }

    /**
     * @param int $districtId
     * @param string $keyword
     * @return mixed
     * @throws HttpException
     */
    public function searchFromMap(int $districtId, string $keyword)
    {
        $params = [
            'districtid' => $districtId,
            'keyword' => $keyword,
        ];

        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/wxa/search_map_poi',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        $this->checkResponse($response, $parseData);

        return $parseData;
    }

    /**
     * @return mixed
     * @throws HttpException
     */
    public function getStatus()
    {
        $response = $this->getClient()
            ->setMethod('GET')
            ->send($this->buildUrl(
                '/wxa/get_merchant_audit_info',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        $this->checkResponse($response, $parseData);

        return $parseData;
    }

    /**
     * @param array $baseInfo
     * @return bool
     * @throws HttpException
     */
    public function createMerchant(array $baseInfo)
    {
        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($baseInfo))
            ->send($this->buildUrl(
                '/wxa/apply_merchant',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        return $this->checkResponse($response);
    }

    /**
     * @param array $params
     * @return bool
     * @throws HttpException
     */
    public function updateMerchant(array $params)
    {
        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/wxa/modify_merchant',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        return $this->checkResponse($response);
    }

    /**
     * @param array $baseInfo
     * @return mixed
     * @throws HttpException
     */
    public function createFromMap(array $baseInfo)
    {
        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($baseInfo))
            ->send($this->buildUrl(
                '/wxa/create_map_poi',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        $this->checkResponse($response, $parseData);

        return $parseData;
    }

    /**
     * @param array $baseInfo
     * @return mixed
     * @throws HttpException
     */
    public function create(array $baseInfo)
    {
        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($baseInfo))
            ->send($this->buildUrl(
                '/wxa/add_store',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        $this->checkResponse($response, $parseData);

        return $parseData;
    }

    /**
     * @param int $poiId
     * @param array $baseInfo
     * @return mixed
     * @throws HttpException
     */
    public function update(int $poiId, array $baseInfo)
    {
        $params = array_merge($baseInfo, ['poi_id' => $poiId]);

        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/wxa/add_store',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        $this->checkResponse($response, $parseData);

        return $parseData;
    }

    /**
     * @param int $poiId
     * @return mixed
     * @throws HttpException
     */
    public function get(int $poiId)
    {
        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream(['poi_id' => $poiId]))
            ->send($this->buildUrl(
                '/wxa/get_store_info',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        $this->checkResponse($response, $parseData);

        return $parseData;
    }

    /**
     * @param int $offset
     * @param int $limit
     * @return mixed
     * @throws HttpException
     */
    public function list(int $offset = 0, int $limit = 10)
    {
        $params = [
            'offset' => $offset,
            'limit' => $limit,
        ];

        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/wxa/get_store_list',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        $this->checkResponse($response, $parseData);

        return $parseData;
    }

    /**
     * @param int $poiId
     * @return bool
     * @throws HttpException
     */
    public function delete(int $poiId)
    {
        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream(['poi_id' => $poiId]))
            ->send($this->buildUrl(
                '/wxa/del_store',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        return $this->checkResponse($response);
    }
}