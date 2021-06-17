<?php

namespace EasySwoole\WeChat\MiniProgram\UrlLink;

use EasySwoole\WeChat\Kernel\ServiceProviders;
use EasySwoole\WeChat\MiniProgram\BaseClient;

/**
 * Class Client
 * @package EasySwoole\WeChat\MiniProgram\UrlLink
 */
class Client extends BaseClient
{
    /**
     * 获取小程序 URL Link
     * doc link: https://developers.weixin.qq.com/miniprogram/dev/api-backend/open-api/url-link/urllink.generate.html
     *
     * @param array $param
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function generate_urllink(array $param = [])
    {
        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($param))
            ->send($this->buildUrl(
                '/wxa/generate_urllink',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()])
            );

        $this->checkResponse($response, $parseData);

        return $parseData;
    }
}
