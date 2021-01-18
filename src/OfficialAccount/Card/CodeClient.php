<?php


namespace EasySwoole\WeChat\OfficialAccount\Card;


use EasySwoole\WeChat\Kernel\BaseClient;
use EasySwoole\WeChat\Kernel\ServiceProviders;
use EasySwoole\WeChat\Kernel\Exceptions\HttpException;

class CodeClient extends BaseClient
{
    /**
     * 导入code
     * @param string $cardId
     * @param array $codes
     * @return bool
     * @throws HttpException
     * @link https://developers.weixin.qq.com/doc/offiaccount/Cards_and_Offer/Distributing_Coupons_Vouchers_and_Cards.html
     */
    public function deposit(string $cardId, array $codes)
    {
        $params = [
            'card_id' => $cardId,
            'code' => $codes,
        ];

        $response = $this->getClient()
            ->setMethod("POST")
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/card/code/deposit',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        return $this->checkResponse($response);
    }

    /**
     * 查询导入code数目
     * @param string $cardId
     * @return mixed
     * @throws HttpException
     */
    public function getDepositedCount(string $cardId)
    {
        $params = [
            'card_id' => $cardId,
        ];

        $response = $this->getClient()
            ->setMethod("POST")
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/card/code/getdepositcount',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        $this->checkResponse($response, $parseData);
        return $parseData;
    }

    /**
     * 核查code
     * @param string $cardId
     * @param array $codes
     * @return mixed
     * @throws HttpException
     */
    public function check(string $cardId, array $codes)
    {
        $params = [
            'card_id' => $cardId,
            'code' => $codes,
        ];

        $response = $this->getClient()
            ->setMethod("POST")
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/card/code/checkcode',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        $this->checkResponse($response, $parseData);
        return $parseData;
    }

    /**
     * 查询code
     * @param string $code
     * @param string $cardId
     * @param bool $checkConsume
     * @return mixed
     * @throws HttpException
     */
    public function get(string $code, string $cardId = '', bool $checkConsume = true)
    {
        $params = [
            'code' => $code,
            'check_consume' => $checkConsume,
            'card_id' => $cardId,
        ];

        $response = $this->getClient()
            ->setMethod("POST")
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/card/code/get',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        $this->checkResponse($response, $parseData);
        return $parseData;
    }

    /**
     * 更新code
     * @param string $code
     * @param string $newCode
     * @param string $cardId
     * @return bool
     * @throws HttpException
     */
    public function update(string $code, string $newCode, string $cardId = '')
    {
        $params = [
            'code' => $code,
            'new_code' => $newCode,
            'card_id' => $cardId,
        ];

        $response = $this->getClient()
            ->setMethod("POST")
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/card/code/update',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        return $this->checkResponse($response);
    }

    /**
     * 设置卡劵失效
     * @param string $code
     * @param string $cardId
     * @return bool
     * @throws HttpException
     */
    public function disable(string $code, string $cardId = '')
    {
        $params = [
            'code' => $code,
            'card_id' => $cardId,
        ];

        $response = $this->getClient()
            ->setMethod("POST")
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/card/code/unavailable',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        return $this->checkResponse($response);
    }


    /**
     * 核销code
     * @param string $code
     * @param string|null $cardId
     * @return mixed
     * @throws HttpException
     */
    public function consume(string $code, string $cardId = null)
    {
        $params = [
            'code' => $code,
        ];

        if (!is_null($cardId)) {
            $params['card_id'] = $cardId;
        }

        $response = $this->getClient()
            ->setMethod("POST")
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/card/code/consume',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        $this->checkResponse($response, $parseData);
        return $parseData;
    }


    /**
     * code解码
     * @param string $encryptedCode
     * @return mixed
     * @throws HttpException
     */
    public function decrypt(string $encryptedCode)
    {
        $params = [
            'encrypt_code' => $encryptedCode,
        ];

        $response = $this->getClient()
            ->setMethod("POST")
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/card/code/decrypt',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        $this->checkResponse($response, $parseData);
        return $parseData;
    }
}