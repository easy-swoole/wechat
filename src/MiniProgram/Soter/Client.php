<?php

namespace EasySwoole\WeChat\MiniProgram\Soter;

use EasySwoole\WeChat\MiniProgram\BaseClient;
use EasySwoole\WeChat\Kernel\ServiceProviders;

/**
 * Class Client
 * @author master@kyour.cn
 * @package EasySwoole\WeChat\MiniProgram\Soter
 * doc link: https://developers.weixin.qq.com/miniprogram/dev/api-backend/open-api/soter/soter.verifySignature.html
 */
class Client extends BaseClient
{
    /**
     * @param string $openid
     * @param string $json
     * @param string $signature
     *
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function verifySignature(string $openid, string $json, string $signature)
    {
        $params = [
            'openid' => $openid,
            'json_string' => $json,
            'json_signature' => $signature,
        ];

        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/cgi-bin/soter/verify_signature',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()])
            );

        $this->checkResponse($response, $parseData);

        return $parseData;
    }
}
