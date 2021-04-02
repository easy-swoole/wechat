<?php

namespace EasySwoole\WeChat\MiniProgram\Search;

use EasySwoole\WeChat\MiniProgram\BaseClient;
use EasySwoole\WeChat\Kernel\ServiceProviders;

/**
 * Class Client
 * @author master@kyour.cn
 * @package EasySwoole\WeChat\MiniProgram\Live
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

        $this->checkResponse($response, $parseData);

        return $parseData;
    }
}
