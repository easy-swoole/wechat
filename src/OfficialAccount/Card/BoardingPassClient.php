<?php

namespace EasySwoole\WeChat\OfficialAccount\Card;

use EasySwoole\WeChat\Kernel\BaseClient;
use EasySwoole\WeChat\Kernel\ServiceProviders;
use EasySwoole\WeChat\Kernel\Exceptions\HttpException;

class BoardingPassClient extends BaseClient
{
    /**
     * 更新飞机票信息接口
     * doc link: https://developers.weixin.qq.com/doc/offiaccount/Cards_and_Offer/Special_ticket.html#4.2%20更新飞机票信息接口
     *
     * @param array $params
     * @return bool
     * @throws HttpException
     */
    public function checkin(array $params)
    {
        $response = $this->getClient()->setMethod("POST")
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/card/boardingpass/checkin',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        return $this->checkResponse($response);
    }
}