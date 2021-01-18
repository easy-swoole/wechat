<?php


namespace EasySwoole\WeChat\OfficialAccount\Card;


use EasySwoole\WeChat\Kernel\BaseClient;
use EasySwoole\WeChat\Kernel\ServiceProviders;
use EasySwoole\WeChat\Kernel\Exceptions\HttpException;

class GiftCardClient extends BaseClient
{
    /**
     * 申请微信支付礼品卡权限
     * @param string $subMchId
     * @return mixed
     * @throws HttpException
     */
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


    /**
     * 绑定商户号到礼品卡小程序接口
     * @param string $subMchId
     * @param string $wxaAppId
     * @return bool
     * @throws HttpException
     */
    public function bind(string $subMchId, string $wxaAppId)
    {
        $params = [
            'sub_mch_id' => $subMchId,
            'wxa_appid' => $wxaAppId,
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

    /**
     * 上传小程序代码
     * @param string $wxaAppId
     * @param string $pageId
     * @return bool
     * @throws HttpException
     */
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