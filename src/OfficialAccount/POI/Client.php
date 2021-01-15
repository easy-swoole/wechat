<?php


namespace EasySwoole\WeChat\OfficialAccount\POI;


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
                '/cgi-bin/poi/getwxcategory',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()])
            );

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
                '/cgi-bin/poi/getpoi',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()])
            );

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

    /**
     * @param array $baseInfo
     * @return mixed
     * @throws HttpException
     */
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

    /**
     * @param int $poiId
     * @param array $baseInfo
     * @return bool
     * @throws HttpException
     */
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
                '/cgi-bin/poi/delpoi',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()])
            );

        return $this->checkResponse($response);
    }
}
