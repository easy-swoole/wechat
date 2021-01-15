<?php


namespace EasySwoole\WeChat\OfficialAccount\Card;


use EasySwoole\WeChat\Kernel\BaseClient;
use EasySwoole\WeChat\Kernel\ServiceProviders;
use EasySwoole\WeChat\Kernel\Exceptions\HttpException;

class GiftCardPageClient extends BaseClient
{
    /**
     * 创建 礼品卡货架
     * @param array $attributes
     * @return mixed
     * @throws HttpException
     */
    public function add(array $attributes)
    {
        $params = [
            'page' => $attributes,
        ];

        $response = $this->getClient()
            ->setMethod("POST")
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/card/giftcard/page/add',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        $this->checkResponse($response, $parseData);
        return $parseData;
    }


    /**
     * 查询礼品卡货架信息
     * @param string $pageId
     * @return mixed
     * @throws HttpException
     */
    public function get(string $pageId)
    {
        $params = [
            'page_id' => $pageId,
        ];

        $response = $this->getClient()
            ->setMethod("POST")
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/card/giftcard/page/get',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        $this->checkResponse($response, $parseData);
        return $parseData;
    }

    /**
     * 修改礼品卡货架信息
     * @param string $pageId
     * @param string $bannerPicUrl
     * @param array $themeList
     * @return bool
     * @throws HttpException
     */
    public function update(string $pageId, string $bannerPicUrl, array $themeList)
    {
        $params = [
            'page' => [
                'page_id' => $pageId,
                'banner_pic_url' => $bannerPicUrl,
                'theme_list' => $themeList,
            ],
        ];

        $response = $this->getClient()
            ->setMethod("POST")
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/card/giftcard/page/update',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        return $this->checkResponse($response);
    }


    /**
     * 查询 礼品卡货架列表
     * @return mixed
     * @throws HttpException
     */
    public function list()
    {
        $response = $this->getClient()
            ->setMethod("POST")
            ->send($this->buildUrl(
                '/card/giftcard/page/batchget',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        $this->checkResponse($response, $parseData);
        return $parseData;
    }

    /**
     * 下架-礼品卡货架 (下架某一个货架或者全部货架)
     * @param string $pageId
     * @return mixed
     * @throws HttpException
     */
    public function setMaintain(string $pageId = '')
    {
        $params = ($pageId ? ['page_id' => $pageId] : ['all' => true]) + [
                'maintain' => true,
            ];

        $response = $this->getClient()
            ->setMethod("POST")
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/card/giftcard/maintain/set',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        $this->checkResponse($response, $parseData);
        return $parseData;
    }
}