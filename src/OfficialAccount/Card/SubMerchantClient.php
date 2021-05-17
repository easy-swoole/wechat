<?php

namespace EasySwoole\WeChat\OfficialAccount\Card;

use EasySwoole\WeChat\Kernel\BaseClient;
use EasySwoole\WeChat\Kernel\ServiceProviders;
use EasySwoole\WeChat\Kernel\Exceptions\HttpException;

class SubMerchantClient extends BaseClient
{
    /**
     * 添加子商户
     * doc link: https://developers.weixin.qq.com/doc/offiaccount/Cards_and_Offer/Third-party_developer_mode.html#1
     *
     * @param array $info
     * @return mixed
     * @throws HttpException
     */
    public function create(array $info = [])
    {
        $params = [
            'info' => array_intersect_key($info, array_flip([
                'brand_name',
                'logo_url',
                'protocol',
                'end_time',
                'primary_category_id',
                'secondary_category_id',
                'agreement_media_id',
                'operator_media_id',
                'app_id',
            ]))
        ];

        $response = $this->getClient()
            ->setMethod("POST")
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/card/submerchant/submit',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        $this->checkResponse($response, $parseData);
        return $parseData;
    }

    /**
     * 更新子商户
     * doc link: https://developers.weixin.qq.com/doc/offiaccount/Cards_and_Offer/Third-party_developer_mode.html#4
     *
     * @param int $merchantId
     * @param array $info
     * @return mixed
     * @throws HttpException
     */
    public function update(int $merchantId, array $info = [])
    {
        $info = array_merge(['merchant_id' => $merchantId], array_intersect_key($info, array_flip([
            'brand_name',
            'logo_url',
            'protocol',
            'end_time',
            'primary_category_id',
            'secondary_category_id',
            'agreement_media_id',
            'operator_media_id',
            'app_id',
        ])));

        $params = [
            'info' => $info,
        ];

        $response = $this->getClient()
            ->setMethod("POST")
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/card/submerchant/update',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        $this->checkResponse($response, $parseData);
        return $parseData;
    }

    /**
     * 获取子商户信息（拉取单个子商户信息接口）
     * doc link: https://developers.weixin.qq.com/doc/offiaccount/Cards_and_Offer/Third-party_developer_mode.html#5
     *
     * @param int $merchantId
     * @return mixed
     * @throws HttpException
     */
    public function get(int $merchantId)
    {
        $response = $this->getClient()
            ->setMethod("POST")
            ->setBody($this->jsonDataToStream(['merchant_id' => $merchantId]))
            ->send($this->buildUrl(
                '/card/submerchant/get',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        $this->checkResponse($response, $parseData);
        return $parseData;
    }

    /**
     * 批量获取子商户信息（批量拉取子商户信息接口）
     * doc link: https://developers.weixin.qq.com/doc/offiaccount/Cards_and_Offer/Third-party_developer_mode.html#6
     *
     * @param int $beginId
     * @param int $limit
     * @param string $status
     * @return mixed
     * @throws HttpException
     */
    public function list(int $beginId = 0, int $limit = 50, string $status = 'CHECKING')
    {
        $params = [
            'begin_id' => $beginId,
            'limit' => $limit,
            'status' => $status,
        ];

        $response = $this->getClient()
            ->setMethod("POST")
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/card/submerchant/batchget',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        $this->checkResponse($response, $parseData);
        return $parseData;
    }
}