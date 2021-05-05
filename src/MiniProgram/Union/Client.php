<?php

namespace EasySwoole\WeChat\MiniProgram\Union;


use EasySwoole\WeChat\Kernel\ServiceProviders;
use EasySwoole\WeChat\MiniProgram\BaseClient;

/**
 * Class Client
 * @package EasySwoole\WeChat\MiniProgram\Union
 * @author: XueSi
 * @email: <1592328848@qq.com>
 *
 * doc link: https://developers.weixin.qq.com/miniprogram/dev/framework/union/access-guidelines/promoter/api/promotion.html
 */
class Client extends BaseClient
{
    /**
     * 添加推广位
     * Add promotion.
     * doc link: https://developers.weixin.qq.com/miniprogram/dev/framework/union/access-guidelines/promoter/api/promotion.html
     *
     * @param string $promotionSourceName
     *
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function createPromotion(string $promotionSourceName)
    {
        $params = [
            'promotionSourceName' => $promotionSourceName,
        ];

        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/union/promoter/promotion/add',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()])
            );

        $this->checkResponse($response, $parseData);

        return $parseData;
    }

    /**
     * 删除推广位
     * Delete promotion.
     * doc link: https://developers.weixin.qq.com/miniprogram/dev/framework/union/access-guidelines/promoter/api/promotion.html
     *
     * @param string $promotionSourceName
     *
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function deletePromotion(string $promotionSourcePid, string $promotionSourceName)
    {
        $params = [
            'promotionSourceName' => $promotionSourceName,
            'promotionSourcePid' => $promotionSourcePid,
        ];

        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/union/promoter/promotion/del',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()])
            );

        return $this->checkResponse($response);
    }

    /**
     * 编辑推广位
     * Update promotion.
     * doc link: https://developers.weixin.qq.com/miniprogram/dev/framework/union/access-guidelines/promoter/api/promotion.html
     *
     * @param array $previousPromotionInfo
     * @param array $promotionInfo
     * @return bool
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function updatePromotion(array $previousPromotionInfo, array $promotionInfo)
    {
        $params = [
            'previousPromotionInfo' => $previousPromotionInfo,
            'promotionInfo' => $promotionInfo,
        ];

        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/union/promoter/promotion/upd',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()])
            );

        return $this->checkResponse($response);
    }

    /**
     * 获取推广位列表
     * Get a list of promotion spots.
     * doc link: https://developers.weixin.qq.com/miniprogram/dev/framework/union/access-guidelines/promoter/api/promotion.html
     *
     * @param int $start
     * @param int $limit
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function getPromotionSourceList(int $start = 0, int $limit = 20)
    {
        $query = [
            'start' => $start,
            'limit' => $limit,
            'access_token' => $this->app[ServiceProviders::AccessToken]->getToken()
        ];

        $response = $this->getClient()
            ->setMethod('GET')
            ->send($this->buildUrl(
                '/union/promoter/promotion/list',
                $query)
            );

        $this->checkResponse($response, $parseData);

        return $parseData;
    }

    /********** 商品推广接口 *******************/
    # doc link: https://developers.weixin.qq.com/miniprogram/dev/framework/union/access-guidelines/promoter/api/product/category.html
    /**
     * 获取联盟商品类目列表及类目ID
     * Get the list of affiliate product categories and category IDs.
     * doc link: https://developers.weixin.qq.com/miniprogram/dev/framework/union/access-guidelines/promoter/api/product/category.html
     *
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function getProductCategory()
    {
        $response = $this->getClient()
            ->setMethod('GET')
            ->send($this->buildUrl(
                '/union/promoter/product/category',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()])
            );

        $this->checkResponse($response, $parseData);

        return $parseData;
    }

    /**
     * 查询商品详情信息
     * Get the list and detail of affiliate product.
     * doc link: https://developers.weixin.qq.com/miniprogram/dev/framework/union/access-guidelines/promoter/api/product/category.html
     *
     * @param array $params
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function getProductList(array $params)
    {
        $response = $this->getClient()
            ->setMethod('GET')
            ->send($this->buildUrl(
                '/union/promoter/product/list',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()])
            );

        $this->checkResponse($response, $parseData);

        return $parseData;
    }

    /**
     * 获取商品推广素材
     * Get product promotion materials.
     * doc link: https://developers.weixin.qq.com/miniprogram/dev/framework/union/access-guidelines/promoter/api/product/category.html
     *
     * @param string $pid
     * @param array $productList
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function getProductMaterial(string $pid, array $productList)
    {
        $params = [
            'pid' => $pid,
            'productList' => $productList,
        ];

        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/union/promoter/product/generate',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()])
            );

        $this->checkResponse($response, $parseData);

        return $parseData;
    }

    /*************** 查询订单明细接口 ******************/
    /**
     * 根据订单ID查询订单详情
     * Query order details based on order ID array.
     * doc link: https://developers.weixin.qq.com/miniprogram/dev/framework/union/access-guidelines/promoter/api/order/order-info.html
     *
     *
     * @param array $orderIdList
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function getOrderInfo(array $orderIdList)
    {
        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($orderIdList))
            ->send($this->buildUrl(
                '/union/promoter/order/info',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()])
            );

        $this->checkResponse($response, $parseData);

        return $parseData;
    }

    /**
     * 根据订单支付时间、订单分佣状态拉取订单详情
     * Query and filter the order list.
     * doc link: https://developers.weixin.qq.com/miniprogram/dev/framework/union/access-guidelines/promoter/api/order/order-info.html
     *
     * @param int $page
     * @param string $startTimestamp
     * @param string $endTimestamp
     * @param string $commissionStatus
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function searchOrder(int $page = 1, $startTimestamp = '', $endTimestamp = '', $commissionStatus = '')
    {
        $query = [
            'page' => $page,
            'startTimestamp' => $startTimestamp,
            'endTimestamp' => $endTimestamp,
            'commissionStatus' => $commissionStatus,
            'access_token' => $this->app[ServiceProviders::AccessToken]->getToken()
        ];

        $response = $this->getClient()
            ->setMethod('GET')
            ->send($this->buildUrl(
                '/union/promoter/order/search',
                $query)
            );

        $this->checkResponse($response, $parseData);

        return $parseData;
    }
}