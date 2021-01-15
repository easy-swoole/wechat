<?php


namespace EasySwoole\WeChat\OfficialAccount\WiFi;


use EasySwoole\WeChat\Kernel\BaseClient;
use EasySwoole\WeChat\Kernel\Exceptions\HttpException;
use EasySwoole\WeChat\Kernel\ServiceProviders;

class CardClient extends BaseClient
{
    /**
     * @param array $data
     * @return bool
     * @throws HttpException
     */
    public function set(array $data)
    {
        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($data))
            ->send($this->buildUrl(
                '/bizwifi/couponput/set',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        return $this->checkResponse($response);
    }

    /**
     * @param int $shopId
     * @return mixed
     * @throws HttpException
     */
    public function get(int $shopId = 0)
    {
        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream(['shop_id' => $shopId]))
            ->send($this->buildUrl(
                '/bizwifi/couponput/get',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        $this->checkResponse($response, $parseData);
        return $parseData;
    }
}