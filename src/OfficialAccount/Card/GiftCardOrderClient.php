<?php


namespace EasySwoole\WeChat\OfficialAccount\Card;


use EasySwoole\WeChat\Kernel\BaseClient;
use EasySwoole\WeChat\Kernel\ServiceProviders;
use EasySwoole\WeChat\Kernel\Exceptions\HttpException;

class GiftCardOrderClient extends BaseClient
{
    /**
     * 查询-单个礼品卡订单信息
     * @param string $orderId
     * @return mixed
     * @throws HttpException
     */
    public function get(string $orderId)
    {
        $params = [
            'order_id' => $orderId,
        ];

        $response = $this->getClient()
            ->setMethod("POST")
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/card/giftcard/order/get',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        $this->checkResponse($response, $parseData);
        return $parseData;
    }


    /**
     * 查询-批量查询礼品卡订单信息
     * @param int $beginTime
     * @param int $endTime
     * @param int $offset
     * @param int $count
     * @param string $sortType
     * @return mixed
     * @throws HttpException
     */
    public function list(int $beginTime, int $endTime, int $offset = 0, int $count = 10, string $sortType = 'ASC')
    {
        $params = [
            'begin_time' => $beginTime,
            'end_time' => $endTime,
            'sort_type' => $sortType,
            'offset' => $offset,
            'count' => $count,
        ];

        $response = $this->getClient()
            ->setMethod("POST")
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/card/giftcard/order/batchget',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        $this->checkResponse($response, $parseData);
        return $parseData;
    }


    /**
     * 退款
     * @param string $orderId
     * @return bool
     * @throws HttpException
     */
    public function refund(string $orderId)
    {
        $params = [
            'order_id' => $orderId,
        ];

        $response = $this->getClient()
            ->setMethod("POST")
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/card/giftcard/order/refund',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        return $this->checkResponse($response);
    }
}