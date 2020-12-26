<?php


namespace EasySwoole\WeChat\OfficialAccount\Card;


use EasySwoole\WeChat\Kernel\BaseClient;
use EasySwoole\WeChat\Kernel\ServiceProviders;

class Client extends BaseClient
{
    /**
     * @return bool
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     * @link http://caibaojian.com/wxwiki/8fd30a84284538e7475c6fc714d230d5f211768b.html
     */
    public function colors()
    {
        $response = $this->getClient()
            ->setMethod("GET")
            ->send($this->buildUrl(
                '/card/getcolors',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        $this->checkResponse($response, $parseData);
        return $parseData;
    }

    /**
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     * @link https://developers.weixin.qq.com/doc/offiaccount/Cards_and_Offer/Third-party_developer_mode.html
     */
    public function categories()
    {
        $response = $this->getClient()
            ->setMethod("GET")
            ->send($this->buildUrl(
                '/card/getapplyprotocol',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        $this->checkResponse($response, $parseData);
        return $parseData;
    }

    public function create(string $cardType, array $attributes)
    {
        $params = [
            'card' => [
                'card_type' => strtoupper($cardType),
                strtolower($cardType) => $attributes,
            ],
        ];
        $response = $this->getClient()
            ->setMethod("POST")
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/card/create',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        $this->checkResponse($response, $parseData);
        return $parseData;
    }

    public function get($cardId)
    {
        $params = [
            'card_id' => $cardId,
        ];

        $response = $this->getClient()
            ->setMethod("POST")
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/card/get',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        $this->checkResponse($response, $parseData);
        return $parseData;
    }

    public function list($offset = 0, $count = 10, $statusList = 'CARD_STATUS_VERIFY_OK')
    {
        $params = [
            'offset' => $offset,
            'count' => $count,
            'status_list' => $statusList,
        ];

        $response = $this->getClient()
            ->setMethod("POST")
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/card/batchget',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        $this->checkResponse($response, $parseData);
        return $parseData;
    }

    public function update($cardId, $type, array $attributes = [])
    {
        $card = [];
        $card['card_id'] = $cardId;
        $card[strtolower($type)] = $attributes;

        $response = $this->getClient()
            ->setMethod("POST")
            ->setBody($this->jsonDataToStream($card))
            ->send($this->buildUrl(
                '/card/update',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        $this->checkResponse($response, $parseData);
        return $parseData;
    }

    public function delete($cardId)
    {
        $params = [
            'card_id' => $cardId,
        ];

        $response = $this->getClient()
            ->setMethod("POST")
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/card/delete',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        return $this->checkResponse($response);
    }

    public function createQrCode(array $cards)
    {
        $response = $this->getClient()
            ->setMethod("POST")
            ->setBody($this->jsonDataToStream($cards))
            ->send($this->buildUrl(
                '/card/qrcode/create',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        $this->checkResponse($response, $parseData);
        return $parseData;
    }

    /**
     * @param $ticket
     * @return array
     * @link https://developers.weixin.qq.com/doc/offiaccount/Account_Management/Generating_a_Parametric_QR_Code.html
     */
    public function getQrCode($ticket)
    {
        $baseUri = 'https://mp.weixin.qq.com/cgi-bin/showqrcode';
        $params = [
            'ticket' => $ticket,
            'access_token' => $this->app[ServiceProviders::AccessToken]->getToken()
        ];

        $response = $this->getClient()
            ->setMethod('GET')
            ->send($baseUri . '?' . http_build_query($params));

        return [
            'status' => $response->getStatusCode(),
            'reason' => $response->getReasonPhrase(),
            'headers' => $response->getHeaders(),
            'body' => strval($response->getBody()),
            'url' => $baseUri . '?' . http_build_query($params),
        ];
    }

    /**
     * 通过ticket换取二维码 链接.
     *
     * @param string $ticket
     *
     * @return string
     */
    public function getQrCodeUrl($ticket)
    {
        return sprintf('https://mp.weixin.qq.com/cgi-bin/showqrcode?ticket=%s', $ticket);
    }


    public function createLandingPage($banner, $pageTitle, $canShare, $scene, $cardList)
    {
        $params = [
            'banner' => $banner,
            'page_title' => $pageTitle,
            'can_share' => $canShare,
            'scene' => $scene,
            'card_list' => $cardList,
        ];

        $response = $this->getClient()
            ->setMethod("POST")
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/card/landingpage/create',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        $this->checkResponse($response, $parseData);
        return $parseData;
    }


    public function getHtml($cardId)
    {
        $params = [
            'card_id' => $cardId,
        ];

        $response = $this->getClient()
            ->setMethod("POST")
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/card/mpnews/gethtml',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        $this->checkResponse($response, $parseData);
        return $parseData;
    }

    public function setTestWhitelist($openids)
    {
        $params = [
            'openid' => $openids,
        ];

        $response = $this->getClient()
            ->setMethod("POST")
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/card/testwhitelist/set',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        return $this->checkResponse($response);
    }

    public function setTestWhitelistByName(array $usernames)
    {
        $params = [
            'username' => $usernames,
        ];

        $response = $this->getClient()
            ->setMethod("POST")
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/card/testwhitelist/set',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        return $this->checkResponse($response);
    }

    public function getUserCards($openid, $cardId = '')
    {
        $params = [
            'openid' => $openid,
            'card_id' => $cardId,
        ];

        $response = $this->getClient()
            ->setMethod("POST")
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/card/user/getcardlist',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        $this->checkResponse($response, $parseData);
        return $parseData;
    }

    public function setPayCell($cardId, $isOpen = true)
    {
        $params = [
            'card_id' => $cardId,
            'is_open' => $isOpen,
        ];

        $response = $this->getClient()
            ->setMethod("POST")
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/card/paycell/set',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        return $this->checkResponse($response);
    }

    public function setPayConsumeCell($cardId, $isOpen = true, $verifyCod = false, $remarkAmount = false)
    {
        $params = [
            'card_id' => $cardId,
            'is_open' => $isOpen,
            'need_verify_cod' => $verifyCod,
            'need_remark_amount' => $remarkAmount,
        ];


        $response = $this->getClient()
            ->setMethod("POST")
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/card/selfconsumecell/set',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        return $this->checkResponse($response);
    }


    public function increaseStock($cardId, $amount)
    {
        return $this->updateStock($cardId, $amount, 'increase');
    }


    public function reduceStock($cardId, $amount)
    {
        return $this->updateStock($cardId, $amount, 'reduce');
    }


    protected function updateStock($cardId, $amount, $action = 'increase')
    {
        $key = 'increase' === $action ? 'increase_stock_value' : 'reduce_stock_value';
        $params = [
            'card_id' => $cardId,
            $key => abs($amount),
        ];

        $response = $this->getClient()
            ->setMethod("POST")
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/card/modifystock',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        return $this->checkResponse($response);
    }
}