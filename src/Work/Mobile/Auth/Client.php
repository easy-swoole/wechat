<?php

namespace EasySwoole\WeChat\Work\Mobile\Auth;

use EasySwoole\WeChat\Kernel\ServiceProviders;
use EasySwoole\WeChat\Work\BaseClient;

/**
 * Class Client
 * @package EasySwoole\WeChat\Work\Mobile
 * @author: XueSi
 * @email: <1592328848@qq.com>
 */
class Client extends BaseClient
{
    /**
     * 获取访问用户身份
     * doc link: https://work.weixin.qq.com/api/doc/90000/90135/91707
     *
     * @param string $code
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function getUser(string $code)
    {
        $query = [
            'code' => $code,
            'access_token' => $this->app[ServiceProviders::AccessToken]->getToken()
        ];

        $response = $this->getClient()
            ->setMethod('GET')
            ->send($this->buildUrl(
                '/cgi-bin/user/getuserinfo',
                $query
            ));

        $this->checkResponse($response, $parseData);
        return $parseData;
    }
}