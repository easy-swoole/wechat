<?php


namespace EasySwoole\WeChat\OfficialAccount\WiFi;


use EasySwoole\WeChat\Kernel\BaseClient;
use EasySwoole\WeChat\Kernel\Exceptions\HttpException;
use EasySwoole\WeChat\Kernel\ServiceProviders;

class Client extends BaseClient
{
    /**
     * @param string $beginDate
     * @param string $endDate
     * @param int $shopId
     * @return mixed
     * @throws HttpException
     */
    public function summary(string $beginDate, string $endDate, int $shopId = -1)
    {
        $data = [
            'begin_date' => $beginDate,
            'end_date' => $endDate,
            'shop_id' => $shopId
        ];

        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($data))
            ->send($this->buildUrl(
                '/bizwifi/statistics/list',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        $this->checkResponse($response, $parseData);
        return $parseData;
    }

    /**
     * @param int $shopId
     * @param string $ssid
     * @param int $type
     * @return mixed
     * @throws HttpException
     */
    public function getQrCodeUrl(int $shopId, string $ssid, int $type = 0)
    {
        $data = [
            'shop_id' => $shopId,
            'ssid' => $ssid,
            'img_id' => $type,
        ];

        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($data))
            ->send($this->buildUrl(
                '/bizwifi/qrcode/get',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        $this->checkResponse($response, $parseData);
        return $parseData;
    }


    /**
     * @param array $data
     * @return bool
     * @throws HttpException
     */
    public function setFinishPage(array $data)
    {
        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($data))
            ->send($this->buildUrl(
                '/bizwifi/finishpage/set',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        return $this->checkResponse($response);
    }


    /**
     * @param array $data
     * @return bool
     * @throws HttpException
     */
    public function setHomePage(array $data)
    {
        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($data))
            ->send($this->buildUrl(
                '/bizwifi/homepage/set',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        return $this->checkResponse($response);
    }
}