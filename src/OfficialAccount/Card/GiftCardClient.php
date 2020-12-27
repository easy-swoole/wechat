<?php


namespace EasySwoole\WeChat\OfficialAccount\Card;


use EasySwoole\WeChat\Kernel\BaseClient;
use EasySwoole\WeChat\Kernel\ServiceProviders;

class GiftCardClient extends BaseClient
{
    public function add(string $subMchId)
    {
        $params = [
            'sub_mch_id' => $subMchId,
        ];

        $response = $this->getClient()
            ->setMethod("POST")
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/card/giftcard/pay/whitelist/add',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        $this->checkResponse($response, $parseData);
        return $parseData;
    }


    public function bind(string $subMchId, string $wxaAppid)
    {
        $params = [
            'sub_mch_id' => $subMchId,
            'wxa_appid' => $wxaAppid,
        ];

        $response = $this->getClient()
            ->setMethod("POST")
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/card/giftcard/pay/submch/bind',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        return $this->checkResponse($response);
    }

    public function set(string $wxaAppId, string $pageId)
    {
        $params = [
            'wxa_appid' => $wxaAppId,
            'page_id' => $pageId,
        ];

        $response = $this->getClient()
            ->setMethod("POST")
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/card/giftcard/wxa/set',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        return $this->checkResponse($response);
    }
}