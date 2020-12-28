<?php


namespace EasySwoole\WeChat\OfficialAccount\Card;


use EasySwoole\WeChat\Kernel\BaseClient;
use EasySwoole\WeChat\Kernel\ServiceProviders;

class InvoiceClient extends BaseClient
{
    public function set(string $mchId, string $spAppId)
    {
        $params = [
            'paymch_info' => [
                'mchid' => $mchId,
                's_pappid' => $spAppId,
            ],
        ];

        return $this->setBizAttr('set_pay_mch', $params, false);
    }

    public function get()
    {
        return $this->setBizAttr('get_pay_mch');
    }

    public function setAuthField(array $userData, array $bizData)
    {
        $params = [
            'auth_field' => [
                'user_field' => $userData,
                'biz_field' => $bizData,
            ],
        ];

        return $this->setBizAttr('set_auth_field', $params, true);
    }

    public function getAuthField()
    {
        return $this->setBizAttr('get_auth_field', [], true);
    }

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