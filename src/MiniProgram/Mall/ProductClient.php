<?php

namespace EasySwoole\WeChat\MiniProgram\Mall;


use EasySwoole\WeChat\Kernel\ServiceProviders;
use EasySwoole\WeChat\MiniProgram\BaseClient;

class ProductClient extends BaseClient
{
    /**
     * 更新或导入物品信息.
     *
     * doc link: https://wsad.weixin.qq.com/wsad/zh_CN/htmledition/order/html/document/goods/update.part.html
     *
     * @param $params
     * @param bool $isTest
     * @return bool
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function import($params, $isTest = false)
    {
        $query = [
            'access_token' => $this->app[ServiceProviders::AccessToken]->getToken(),
            'is_test' => (int) $isTest
        ];

        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/mall/importproduct',
                $query)
            );

        return $this->checkResponse($response);
    }

    /**
     * 查询物品信息.
     *
     * doc link: https://wsad.weixin.qq.com/wsad/zh_CN/htmledition/order/html/document/goods/query.part.html
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
                '/mall/queryproduct',
                $query)
            );

        $this->checkResponse($response, $parseData);

        return $parseData;
    }

    /**
     * 小程序的物品是否可被搜索.
     *
     * doc link: https://wsad.weixin.qq.com/wsad/zh_CN/htmledition/order/html/document/goods/shop_can_be_search.part.html
     *
     * @param $value
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function setSearchable($value)
    {
        $query = [
            'access_token' => $this->app[ServiceProviders::AccessToken]->getToken(),
            'action' => 'set_biz_can_be_search'
        ];

        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream(['can_be_search' => $value]))
            ->send($this->buildUrl(
                '/mall/brandmanage',
                $query)
            );

        return $this->checkResponse($response);
    }
}