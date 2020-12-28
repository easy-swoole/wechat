<?php


namespace EasySwoole\WeChat\OfficialAccount\Card;


use EasySwoole\WeChat\Kernel\BaseClient;
use EasySwoole\WeChat\Kernel\ServiceProviders;

class GiftCardPageClient extends BaseClient
{
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