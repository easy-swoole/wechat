<?php

namespace EasySwoole\WeChat\Work\Menu;

use EasySwoole\WeChat\Kernel\ServiceProviders;
use EasySwoole\WeChat\Work\BaseClient;

/**
 * Class Client
 * @package EasySwoole\WeChat\Work\Menu
 * @author: XueSi
 * @email: <1592328848@qq.com>
 */
class Client extends BaseClient
{
    /**
     * 获取菜单
     * Get menu
     * doc link: https://work.weixin.qq.com/api/doc/90000/90135/90232
     *
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function get()
    {
        $query = [
            'agentid' => $this->app[ServiceProviders::Config]->get('agentId'),
            'access_token' => $this->app[ServiceProviders::AccessToken]->getToken()
        ];

        $response = $this->getClient()
            ->setMethod('GET')
            ->send($this->buildUrl(
                '/cgi-bin/menu/get',
                $query
            ));

        $this->checkResponse($response, $parseData);
        return $parseData;
    }

    /**
     * 创建菜单
     * Create menu for the given agent
     * doc link: https://work.weixin.qq.com/api/doc/90000/90135/90231
     *
     * @param array $data
     * @return bool
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function create(array $data)
    {
        $query = [
            'agentid' => $this->app[ServiceProviders::Config]->get('agentId'),
            'access_token' => $this->app[ServiceProviders::AccessToken]->getToken()
        ];

        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($data))
            ->send($this->buildUrl(
                '/cgi-bin/menu/create',
                $query
            ));

        return $this->checkResponse($response);
    }

    /**
     * 删除菜单
     * Delete menu
     * doc link: https://work.weixin.qq.com/api/doc/90000/90135/90233
     *
     * @return bool
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function delete()
    {
        $query = [
            'agentid' => $this->app[ServiceProviders::Config]->get('agentId'),
            'access_token' => $this->app[ServiceProviders::AccessToken]->getToken()
        ];

        $response = $this->getClient()
            ->setMethod('GET')
            ->send($this->buildUrl(
                '/cgi-bin/menu/delete',
                $query
            ));

        return $this->checkResponse($response);
    }
}