<?php

namespace EasySwoole\WeChat\OfficialAccount\WiFi;


use EasySwoole\WeChat\Kernel\BaseClient;
use EasySwoole\WeChat\Kernel\Exceptions\HttpException;
use EasySwoole\WeChat\Kernel\ServiceProviders;


class ShopClient extends BaseClient
{

    /**
     * @param int $shopId
     * @return mixed
     * @throws HttpException
     */
    public function get(int $shopId)
    {
        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream(['shop_id' => $shopId]))
            ->send($this->buildUrl(
                '/bizwifi/shop/get',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        $this->checkResponse($response, $parseData);
        return $parseData;
    }


    /**
     * @param int $page
     * @param int $size
     * @return mixed
     * @throws HttpException
     */
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
                '/bizwifi/shop/list',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        $this->checkResponse($response, $parseData);
        return $parseData;
    }


    /**
     * @param int $shopId
     * @param array $data
     * @return bool
     * @throws HttpException
     */
    public function update(int $shopId, array $data)
    {
        $data = array_merge(['shop_id' => $shopId], $data);

        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($data))
            ->send($this->buildUrl(
                '/bizwifi/shop/update',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        return $this->checkResponse($response);
    }

    /**
     * @param int $shopId
     * @param string|null $ssid
     * @return bool
     * @throws HttpException
     */
    public function clearDevice(int $shopId, string $ssid = null)
    {
        $data = [
            'shop_id' => $shopId,
        ];

        if (!is_null($ssid)) {
            $data['ssid'] = $ssid;
        }

        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($data))
            ->send($this->buildUrl(
                '/bizwifi/shop/clean',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        return $this->checkResponse($response);
    }
}
