<?php

namespace EasySwoole\WeChat\MiniProgram\Search;

use EasySwoole\WeChat\MiniProgram\BaseClient;
use EasySwoole\WeChat\Kernel\ServiceProviders;

/**
 * Class Client
 * @author master@kyour.cn
 * @package EasySwoole\WeChat\MiniProgram\Search
 * doc link: https://developers.weixin.qq.com/miniprogram/dev/api-backend/open-api/search/search.submitPages.html#HTTPS%20%E8%B0%83%E7%94%A8
 */
class Client extends BaseClient
{
    /**
     * Submit applet page URL and parameter information.
     *
     * @param array $pages
     *
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function submitPage(array $pages)
    {
        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream(compact('pages')))
            ->send($this->buildUrl(
                '/wxa/search/wxaapi_submitpages',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()])
            );
        return $this->checkResponse($response);
    }
}
