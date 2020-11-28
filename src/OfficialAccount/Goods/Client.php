<?php

namespace EasySwoole\WeChat\OfficialAccount\Goods;


use EasySwoole\WeChat\Kernel\BaseClient;
use EasySwoole\WeChat\Kernel\ServiceProviders;

/**
 * Class Client
 * @package EasySwoole\WeChat\OfficialAccount\Goods
 * @link https://mp.weixin.qq.com/cgi-bin/announce?action=getannouncement&key=11533749572M9ODP&version=1&lang=zh_CN&platform=2
 * @author gaobinzhan <gaobinzhan@gmail.com>
 * 再也不想翻微信开放文档，太难找。。。。。
 */
class Client extends BaseClient
{
    public function add(array $data)
    {
        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream(['product' => $data]))
            ->send($this->buildUrl(
                '/scan/product/v2/add',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()])
            );

        $this->checkResponse($response, $parseData);

        return $parseData;
    }

    public function update(array $data)
    {
        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream(['product' => $data]))
            ->send($this->buildUrl(
                '/scan/product/v2/add',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()])
            );

        $this->checkResponse($response, $parseData);

        return $parseData;
    }


    public function status(string $ticket)
    {

        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream(['status_ticket' => $ticket]))
            ->send($this->buildUrl(
                '/scan/product/v2/status',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()])
            );

        $this->checkResponse($response, $parseData);

        return $parseData;
    }

    public function get(string $pid)
    {

        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream([
                'product' => [
                    'pid' => $pid,
                ],
            ]))
            ->send($this->buildUrl(
                '/scan/product/v2/getinfo',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()])
            );

        $this->checkResponse($response, $parseData);

        return $parseData;
    }

    public function list(string $context = '', int $page = 1, int $size = 10)
    {

        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream([
                'page_context' => $context,
                'page_num' => $page,
                'page_size' => $size,
            ]))
            ->send($this->buildUrl(
                '/scan/product/v2/getinfobypage',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()])
            );

        $this->checkResponse($response, $parseData);

        return $parseData;
    }
}