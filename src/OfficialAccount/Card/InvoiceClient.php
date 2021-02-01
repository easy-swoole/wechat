<?php


namespace EasySwoole\WeChat\OfficialAccount\Card;


use EasySwoole\WeChat\Kernel\BaseClient;
use EasySwoole\WeChat\Kernel\ServiceProviders;
use EasySwoole\WeChat\Kernel\Exceptions\HttpException;


class InvoiceClient extends BaseClient
{
    /**
     * 设置支付开票信息
     * @param string $mchId
     * @param string $spAppId
     * @return bool
     * @throws HttpException
     */
    public function set(string $mchId, string $spAppId)
    {
        $params = [
            'paymch_info' => [
                'mchid' => $mchId,
                's_pappid' => $spAppId,
            ],
        ];

        return $this->setBizAttr('set_pay_mch', $params);
    }

    /**
     * 查询支付后开票信息
     * @return bool
     * @throws HttpException
     */
    public function get()
    {
        return $this->setBizAttr('get_pay_mch', [], true);
    }

    /**
     * 设置授权页字段信息
     * @param array $userData
     * @param array $bizData
     * @return bool
     * @throws HttpException
     */
    public function setAuthField(array $userData, array $bizData)
    {
        $params = [
            'auth_field' => [
                'user_field' => $userData,
                'biz_field' => $bizData,
            ],
        ];

        return $this->setBizAttr('set_auth_field', $params);
    }

    /**
     * 查询授权页字段信息
     * @return bool
     * @throws HttpException
     */
    public function getAuthField()
    {
        return $this->setBizAttr('get_auth_field', [], true);
    }

    /**
     * 查询开票信息
     * @param string $appId
     * @param string $orderId
     * @return mixed
     * @throws HttpException
     */
    public function getAuthData(string $appId, string $orderId)
    {
        $params = [
            'order_id' => $orderId,
            's_appid' => $appId,
        ];

        $response = $this->getClient()
            ->setMethod("POST")
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/card/invoice/getauthdata',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        $this->checkResponse($response, $parseData);
        return $parseData;
    }

    /**
     * @param string $action
     * @param array $params
     * @param bool $returnParseData
     * @return bool
     * @throws HttpException
     */
    private function setBizAttr(string $action, array $params = [], bool $returnParseData = false)
    {
        $client = $this->getClient()
            ->setMethod("POST");

        if ($params) {
            $client->setBody($this->jsonDataToStream($params));
        }

        $response = $client->send($this->buildUrl(
            '/card/invoice/setbizattr',
            [
                'action' => $action,
                'access_token' => $this->app[ServiceProviders::AccessToken]->getToken()
            ]
        ));

        if (!$returnParseData) {
            return $this->checkResponse($response);
        }

        $this->checkResponse($response, $parseData);
        return $parseData;
    }
}