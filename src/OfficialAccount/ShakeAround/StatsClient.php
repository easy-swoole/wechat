<?php

namespace EasySwoole\WeChat\OfficialAccount\ShakeAround;


use EasySwoole\WeChat\Kernel\BaseClient;
use EasySwoole\WeChat\Kernel\ServiceProviders;

class StatsClient extends BaseClient
{

    public function deviceSummary(array $deviceIdentifier, int $beginTime, int $endTime)
    {
        $params = [
            'device_identifier' => $deviceIdentifier,
            'begin_date' => $beginTime,
            'end_date' => $endTime,
        ];

        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/shakearound/statistics/device',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        $this->checkResponse($response, $parseData);

        return $parseData;
    }

    public function devicesSummary(int $timestamp, int $pageIndex)
    {
        $params = [
            'date' => $timestamp,
            'page_index' => $pageIndex,
        ];

        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/shakearound/statistics/devicelist',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        $this->checkResponse($response, $parseData);

        return $parseData;
    }


    public function pageSummary(int $pageId, int $beginTime, int $endTime)
    {
        $params = [
            'page_id' => $pageId,
            'begin_date' => $beginTime,
            'end_date' => $endTime,
        ];

        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/shakearound/statistics/page',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        $this->checkResponse($response, $parseData);

        return $parseData;
    }


    public function pagesSummary(int $timestamp, int $pageIndex)
    {
        $params = [
            'date' => $timestamp,
            'page_index' => $pageIndex,
        ];

        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/shakearound/statistics/pagelist',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        $this->checkResponse($response, $parseData);

        return $parseData;
    }
}
