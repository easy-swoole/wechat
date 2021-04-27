<?php

namespace EasySwoole\WeChat\Work\MiniProgram\Auth;

use EasySwoole\WeChat\Kernel\ServiceProviders;
use EasySwoole\WeChat\Work\BaseClient;

/**
 * Class Client
 * @package EasySwoole\WeChat\Work\MiniProgram\Auth
 * @author: XueSi
 * @email: <1592328848@qq.com>
 */
class Client extends BaseClient
{
    /**
     * code2Session
     * Get session info by code
     * doc link: https://work.weixin.qq.com/api/doc/90000/90136/91507
     *
     * @param string $code
     * @return bool
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function session(string $code)
    {
        $query = [
            'js_code' => $code,
            'grant_type' => 'authorization_code',
            'access_token' => $this->app[ServiceProviders::AccessToken]->getToken()
        ];

        $response = $this->getClient()
            ->setMethod('GET')
            ->send($this->buildUrl(
                '/cgi-bin/miniprogram/jscode2session',
                $query
            ));

        $this->checkResponse($response, $parseData);
        return $parseData;
    }
}