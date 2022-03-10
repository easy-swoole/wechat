<?php

namespace EasySwoole\WeChat\MiniProgram\PhoneNumber;

use EasySwoole\WeChat\Kernel\ServiceProviders;
use EasySwoole\WeChat\MiniProgram\BaseClient;

/**
 * Class Client
 * @package EasySwoole\WeChat\MiniProgram\PhoneNumber
 * @author: XueSi
 * @email: <1592328848@qq.com>
 * doc link: https://developers.weixin.qq.com/miniprogram/dev/api-backend/open-api/phonenumber/phonenumber.getPhoneNumber.html
 * desc: 获取用户手机号
 */
class Client extends BaseClient
{
    /**
     * 使用code换取手机号
     * code换取用户手机号。 每个code只能使用一次，code的有效期为5min
     *
     * @param string $code
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function getUserPhoneNumber(string $code)
    {
        $params = ['code' => $code];

        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/wxa/business/getuserphonenumber',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()])
            );

        $this->checkResponse($response, $parseData);

        return $parseData;
    }
}