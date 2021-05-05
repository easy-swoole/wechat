<?php

namespace EasySwoole\WeChat\MiniProgram\Base;


use EasySwoole\WeChat\Kernel\ServiceProviders;
use EasySwoole\WeChat\MiniProgram\BaseClient;

class Client extends BaseClient
{
    /**
     * Get paid unionid.
     * 用户支付完成后，获取该用户的 UnionId
     * doc link: https://developers.weixin.qq.com/miniprogram/dev/api-backend/open-api/user-info/auth.getPaidUnionId.html
     *
     * @param $openid
     * @param array $options
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function getPaidUnionid($openid, $options = [])
    {
        $query = \compact('openid') + $options;
        $query['access_token'] = $this->app[ServiceProviders::AccessToken]->getToken();

        $response = $this->getClient()
            ->setMethod('GET')
            ->send($this->buildUrl(
                '/wxa/getpaidunionid',
                $query)
            );

        $this->checkResponse($response, $parseData);

        return $parseData;
    }
}