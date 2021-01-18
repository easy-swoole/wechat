<?php


namespace EasySwoole\WeChat\OfficialAccount\ShakeAround;


use EasySwoole\WeChat\Kernel\BaseClient;
use EasySwoole\WeChat\Kernel\Exceptions\HttpException;
use EasySwoole\WeChat\Kernel\ServiceProviders;

class RelationClient extends BaseClient
{

    /**
     * @param array $deviceIdentifier
     * @param array $pageIds
     * @return mixed
     * @throws HttpException
     */
    public function bindPages(array $deviceIdentifier, array $pageIds)
    {
        $params = [
            'device_identifier' => $deviceIdentifier,
            'page_ids' => $pageIds,
        ];

        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/shakearound/device/bindpage',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        $this->checkResponse($response, $parseData);

        return $parseData;
    }

    /**
     * @param array $deviceIdentifier
     * @return mixed
     * @throws HttpException
     */
    public function listByDeviceId(array $deviceIdentifier)
    {
        $params = [
            'type' => 1,
            'device_identifier' => $deviceIdentifier,
        ];

        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/shakearound/relation/search',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        $this->checkResponse($response, $parseData);

        return $parseData;
    }

    /**
     * @param int $pageId
     * @param int $begin
     * @param int $count
     * @return mixed
     * @throws HttpException
     */
    public function listByPageId(int $pageId, int $begin, int $count)
    {
        $params = [
            'type' => 2,
            'page_id' => $pageId,
            'begin' => $begin,
            'count' => $count,
        ];

        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/shakearound/relation/search',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        $this->checkResponse($response, $parseData);

        return $parseData;
    }
}
