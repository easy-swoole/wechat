<?php

namespace EasySwoole\WeChat\OfficialAccount\ShakeAround;


use EasySwoole\WeChat\Kernel\BaseClient;
use EasySwoole\WeChat\Kernel\Exceptions\HttpException;
use EasySwoole\WeChat\Kernel\ServiceProviders;

class DeviceClient extends BaseClient
{

    /**
     * @param array $data
     * @return mixed
     * @throws HttpException
     */
    public function apply(array $data)
    {
        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($data))
            ->send($this->buildUrl(
                '/shakearound/device/applyid',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        $this->checkResponse($response, $parseData);

        return $parseData;
    }

    /**
     * @param int $applyId
     * @return mixed
     * @throws HttpException
     */
    public function status(int $applyId)
    {
        $params = [
            'apply_id' => $applyId,
        ];

        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/shakearound/device/applystatus',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        $this->checkResponse($response, $parseData);

        return $parseData;
    }

    /**
     * @param array $deviceIdentifier
     * @param string $comment
     * @return mixed
     * @throws HttpException
     */
    public function update(array $deviceIdentifier, string $comment)
    {
        $params = [
            'device_identifier' => $deviceIdentifier,
            'comment' => $comment,
        ];

        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/shakearound/device/update',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        $this->checkResponse($response, $parseData);

        return $parseData;
    }

    /**
     * @param array $deviceIdentifier
     * @param int $poiId
     * @return mixed
     * @throws HttpException
     */
    public function bindPoi(array $deviceIdentifier, int $poiId)
    {
        $params = [
            'device_identifier' => $deviceIdentifier,
            'poi_id' => $poiId,
        ];

        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/shakearound/device/bindlocation',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        $this->checkResponse($response, $parseData);

        return $parseData;
    }


    /**
     * @param array $deviceIdentifier
     * @param int $poiId
     * @param string $appId
     * @return mixed
     * @throws HttpException
     */
    public function bindThirdPoi(array $deviceIdentifier, int $poiId, string $appId)
    {
        $params = [
            'device_identifier' => $deviceIdentifier,
            'poi_id' => $poiId,
            'type' => 2,
            'poi_appid' => $appId,
        ];

        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/shakearound/device/bindlocation',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        $this->checkResponse($response, $parseData);

        return $parseData;
    }


    /**
     * @param array $deviceIdentifiers
     * @return mixed
     * @throws HttpException
     */
    public function listByIds(array $deviceIdentifiers)
    {
        $params = [
            'type' => 1,
            'device_identifiers' => $deviceIdentifiers,
        ];

        return $this->search($params);
    }

    /**
     * @param int $lastId
     * @param int $count
     * @return mixed
     * @throws HttpException
     */
    public function list(int $lastId, int $count)
    {
        $params = [
            'type' => 2,
            'last_seen' => $lastId,
            'count' => $count,
        ];

        return $this->search($params);
    }

    /**
     * @param int $applyId
     * @param int $lastId
     * @param int $count
     * @return mixed
     * @throws HttpException
     */
    public function listByApplyId(int $applyId, int $lastId, int $count)
    {
        $params = [
            'type' => 3,
            'apply_id' => $applyId,
            'last_seen' => $lastId,
            'count' => $count,
        ];

        return $this->search($params);
    }


    /**
     * @param array $params
     * @return mixed
     * @throws HttpException
     */
    public function search(array $params)
    {
        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/shakearound/device/search',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        $this->checkResponse($response, $parseData);

        return $parseData;
    }
}
