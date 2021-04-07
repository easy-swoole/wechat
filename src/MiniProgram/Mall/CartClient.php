<?php

namespace EasySwoole\WeChat\MiniProgram\Mall;


use EasySwoole\WeChat\Kernel\ServiceProviders;
use EasySwoole\WeChat\MiniProgram\BaseClient;

/**
 * Class CartClient
 * @package EasySwoole\WeChat\MiniProgram\Mall
 * @author: XueSi
 * @email: <1592328848@qq.com>
 */
class CartClient extends BaseClient
{
    /**
     * 导入收藏.
     *
     * doc link: https://wsad.weixin.qq.com/wsad/zh_CN/htmledition/order/html/document/cartlist/import.part.html
     *
     * @param $params
     * @param bool $isTest
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function add($params, $isTest = false)
    {
        $query = [
            'access_token' => $this->app[ServiceProviders::AccessToken]->getToken(),
            'is_test' => (int) $isTest
        ];

        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/mall/addshoppinglist',
                $query)
            );

        return $this->checkResponse($response, $parseData);
    }

    /**
     * 查询用户收藏信息.
     *
     * doc link: https://wsad.weixin.qq.com/wsad/zh_CN/htmledition/order/html/document/cartlist/query.part.html
     *
     * @param $params
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function query($params)
    {
        $query = [
            'access_token' => $this->app[ServiceProviders::AccessToken]->getToken(),
            'type' => 'batchquery'
        ];

        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/mall/queryshoppinglist',
                $query)
            );

        $this->checkResponse($response, $parseData);

        return $parseData;
    }

    /**
     * 查询用户收藏信息.
     *
     * doc link: https://wsad.weixin.qq.com/wsad/zh_CN/htmledition/order/html/document/cartlist/query.part.html
     *
     * @param $params
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function queryByPage($params)
    {
        $query = [
            'access_token' => $this->app[ServiceProviders::AccessToken]->getToken(),
            'type' => 'getbypage'
        ];

        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/mall/queryshoppinglist',
                $query)
            );

        $this->checkResponse($response, $parseData);

        return $parseData;
    }

    /**
     * 删除收藏/删除用户的所有收藏.
     *
     * doc link: https://wsad.weixin.qq.com/wsad/zh_CN/htmledition/order/html/document/cartlist/delete.part.html
     *
     * @param $openid
     * @param array $products
     * @return bool
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function delete($openid, array $products = [])
    {
        if (empty($products)) {
            // 删除用户的所有收藏
            $response = $this->getClient()
                ->setMethod('POST')
                ->setBody($this->jsonDataToStream([
                    'user_open_id' => $openid
                ]))
                ->send($this->buildUrl(
                    '/mall/deletebizallshoppinglist',
                    ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()])
                );

            $this->checkResponse($response, $parseData);

            return $parseData;
        }

        // 删除收藏
        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream([
                'user_open_id' => $openid,
                'sku_product_list' => $products
            ]))
            ->send($this->buildUrl(
                '/mall/deleteshoppinglist',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()])
            );

        return $this->checkResponse($response);
    }
}