<?php

namespace EasySwoole\WeChat\MiniProgram\Mall;

use EasySwoole\WeChat\Kernel\ServiceProviders;
use EasySwoole\WeChat\MiniProgram\BaseClient;

/**
 * Class OrderClient
 * @package EasySwoole\WeChat\MiniProgram\Mall
 * @author: XueSi
 * @email: <1592328848@qq.com>
 */
class OrderClient extends BaseClient
{
    /**
     * 导入订单.
     *
     * doc link: https://wsad.weixin.qq.com/wsad/zh_CN/htmledition/order/html/document/orderlist/import.part.html
     *
     * @param $params
     * @param bool $isHistory
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function add($params, $isHistory = false)
    {
        $query = [
            'access_token' => $this->app[ServiceProviders::AccessToken]->getToken(),
            'action' => 'add-order',
            'is_history' => (int)$isHistory
        ];

        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/mall/importorder',
                $query)
            );

        $this->checkResponse($response, $parseData);

        return $parseData;
    }

    /**
     * 更新订单信息.
     *
     * doc link: https://wsad.weixin.qq.com/wsad/zh_CN/htmledition/order/html/document/orderlist/import.part.html
     *
     * @param $params
     * @param bool $isHistory
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function update($params, $isHistory = false)
    {
        $query = [
            'access_token' => $this->app[ServiceProviders::AccessToken]->getToken(),
            'action' => 'update-order',
            'is_history' => (int)$isHistory
        ];

        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/mall/importorder',
                $query)
            );

        return $this->checkResponse($response, $parseData);
    }

    /**
     * 删除订单.
     *
     * doc link: https://wsad.weixin.qq.com/wsad/zh_CN/htmledition/order/html/document/orderlist/delete.part.html
     *
     * @param $openid
     * @param $orderId
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function delete($openid, $orderId)
    {
        $params = [
            'user_open_id' => $openid,
            'order_id' => $orderId,
        ];

        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/mall/deleteorder',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()])
            );

        return $this->checkResponse($response);
    }
}