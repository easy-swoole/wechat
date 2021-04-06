<?php

namespace EasySwoole\WeChat\MiniProgram\Express;

use EasySwoole\WeChat\Kernel\ServiceProviders;
use EasySwoole\WeChat\MiniProgram\BaseClient;

/**
 * Class Client.
 * @author master@kyour.cn
 * @package EasySwoole\WeChat\MiniProgram\Express
 * doc link: https://developers.weixin.qq.com/miniprogram/dev/api-backend/open-api/express/by-business/logistics.addOrder.html
 */
class Client extends BaseClient
{
    /**
     * logistics.getAllDelivery
     * 获取支持的快递公司列表
     *
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function listProviders()
    {
        $response = $this->getClient()
            ->setMethod('GET')
            ->send($this->buildUrl('/cgi-bin/express/business/delivery/getall', ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]));

        $this->checkResponse($response, $parseData);

        return $parseData;
    }

    /**
     * logistics.addOrder
     * 生成运单
     *
     * @param array $params
     *
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function createWaybill(array $params = [])
    {
        return $this->queryPost('/cgi-bin/express/business/order/add', $params);
    }

    /**
     * logistics.cancelOrder
     * 取消运单
     *
     * @param array $params
     *
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function deleteWaybill(array $params = [])
    {
        return $this->queryPost('/cgi-bin/express/business/order/cancel', $params);
    }

    /**
     * logistics.getOrder
     * 获取运单数据
     *
     * @param array $params
     *
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function getWaybill(array $params = [])
    {
        return $this->queryPost('/cgi-bin/express/business/order/get', $params);
    }

    /**
     * logistics.getPath
     * 查询运单轨迹
     *
     * @param array $params
     *
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function getWaybillTrack(array $params = [])
    {
        return $this->queryPost('/cgi-bin/express/business/path/get', $params);
    }

    /**
     * logistics.getQuota
     * 获取电子面单余额
     *
     * @param string $deliveryId
     * @param string $bizId
     *
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function getBalance(string $deliveryId, string $bizId)
    {
        return $this->queryPost('/cgi-bin/express/business/quota/get', [
            'delivery_id' => $deliveryId,
            'biz_id' => $bizId,
        ]);
    }

    /**
     * logistics.getPrinter
     * 获取打印员
     *
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function getPrinter()
    {
        $response = $this->getClient()
            ->setMethod('GET')
            ->send($this->buildUrl('/cgi-bin/express/business/printer/getall', ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]));

        $this->checkResponse($response, $parseData);

        return $parseData;
    }

    /**
     * logistics.updatePrinter
     * (绑定打印员) 配置面单打印员，可以设置多个
     *
     * @param string $openid
     *
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function bindPrinter(string $openid)
    {
        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream([
                'update_type' => 'bind',
                'openid' => $openid,
            ]))
            ->send($this->buildUrl(
                '/cgi-bin/express/business/printer/update',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()])
            );

        return $this->checkResponse($response, $parseData);
    }

    /**
     * logistics.updatePrinter
     * (解除绑定打印员) 配置面单打印员，可以设置多个
     *
     * @param string $openid
     *
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function unbindPrinter(string $openid)
    {
        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream([
                'update_type' => 'unbind',
                'openid' => $openid,
            ]))
            ->send($this->buildUrl(
                '/cgi-bin/express/business/printer/update',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()])
            );

        return $this->checkResponse($response, $parseData);
    }

    public function queryPost($api, $param)
    {
        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($param))
            ->send($this->buildUrl(
                $api,
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()])
            );

        $this->checkResponse($response, $parseData);

        return $parseData;
    }
}
