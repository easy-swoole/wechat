<?php

namespace EasySwoole\WeChat\OfficialAccount\WiFi;


use EasySwoole\WeChat\Kernel\BaseClient;
use EasySwoole\WeChat\Kernel\ServiceProviders;


class DeviceClient extends BaseClient
{

    public function addPasswordDevice(int $shopId, string $ssid, string $password)
    {
        $data = [
            'shop_id' => $shopId,
            'ssid' => $ssid,
            'password' => $password,
        ];

        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($data))
            ->send($this->buildUrl(
                '/bizwifi/device/add',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        $this->checkResponse($response, $parseData);
        return $parseData;
    }


    public function addPortalDevice(int $shopId, string $ssid, bool $reset = false)
    {
        $data = [
            'shop_id' => $shopId,
            'ssid' => $ssid,
            'reset' => $reset,
        ];

        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($data))
            ->send($this->buildUrl(
                '/bizwifi/apportal/register',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        $this->checkResponse($response, $parseData);
        return $parseData;
    }

    public function delete(string $macAddress)
    {
        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream(['bssid' => $macAddress]))
            ->send($this->buildUrl(
                '/bizwifi/device/delete',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        $this->checkResponse($response, $parseData);
        return $parseData;
    }

    public function list(int $page = 1, int $size = 10)
    {
        $data = [
            'pageindex' => $page,
            'pagesize' => $size,
        ];

        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($data))
            ->send($this->buildUrl(
                '/bizwifi/device/list',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        $this->checkResponse($response, $parseData);
        return $parseData;
    }


    public function listByShopId(int $shopId, int $page = 1, int $size = 10)
    {
        $data = [
            'shop_id' => $shopId,
            'pageindex' => $page,
            'pagesize' => $size,
        ];

        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($data))
            ->send($this->buildUrl(
                '/bizwifi/device/list',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        $this->checkResponse($response, $parseData);
        return $parseData;
    }
}
