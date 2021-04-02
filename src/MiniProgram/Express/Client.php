<?php

namespace EasySwoole\WeChat\MiniProgram\Express;

use EasySwoole\WeChat\MiniProgram\BaseClient;

/**
 * Class Client.
 * @authar master@kyour.cn
 * @package EasySwoole\WeChat\MiniProgram\Express
 */
class Client extends BaseClient
{
    /**
    * @return mixed
    * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function listProviders()
    {
        $response = $this->getClient()
            ->setMethod('GET')
            ->send($this->buildUrl('/cgi-bin/express/business/delivery/getall');

        $this->checkResponse($response, $parseData);

        return $parseData;
    }

    /**
     * @param array $params
     *
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function createWaybill(array $params = [])
    {
        return $this->queryPost('cgi-bin/express/business/order/add', $params);
    }

    /**
     * @param array $params
     *
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function deleteWaybill(array $params = [])
    {
        return $this->queryPost('cgi-bin/express/business/order/cancel', $params);
    }

    /**
     * @param array $params
     *
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function getWaybill(array $params = [])
    {
        return $this->queryPost('cgi-bin/express/business/order/get', $params);
    }

    /**
     * @param array $params
     *
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function getWaybillTrack(array $params = [])
    {
        return $this->queryPost('cgi-bin/express/business/path/get', $params);
    }

    /**
     * @param string $deliveryId
     * @param string $bizId
     *
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function getBalance(string $deliveryId, string $bizId)
    {
        return $this->queryPost('cgi-bin/express/business/quota/get', [
            'delivery_id' => $deliveryId,
            'biz_id' => $bizId,
        ]);
    }

    /**
    * @return mixed
    * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function getPrinter()
    {
        return $this->queryPost('cgi-bin/express/business/printer/getall');
    }

    /**
     * @param string $openid
     *
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function bindPrinter(string $openid)
    {
        return $this->queryPost('cgi-bin/express/business/printer/update', [
            'update_type' => 'bind',
            'openid' => $openid,
        ]);
    }

    /**
     * @param string $openid
     *
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function unbindPrinter(string $openid)
    {
        return $this->queryPost('cgi-bin/express/business/printer/update', [
            'update_type' => 'unbind',
            'openid' => $openid,
        ]);
    }

    public function queryPost($api, $param)
    {
        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($param))
            ->send($this->buildUrl(
                '/'.$api,
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()])
            );

        $this->checkResponse($response, $parseData);

        return $parseData;
    }
}
