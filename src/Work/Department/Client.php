<?php

namespace EasySwoole\WeChat\Work\Department;

use EasySwoole\WeChat\Kernel\ServiceProviders;
use EasySwoole\WeChat\Work\BaseClient;

/**
 * Class Client
 * @package EasySwoole\WeChat\Work\Department
 * @author: XueSi
 * @email: <1592328848@qq.com>
 */
class Client extends BaseClient
{
    /**
     * Create a department.
     * 创建部门
     * doc link: https://work.weixin.qq.com/api/doc/90001/90143/90341
     *
     * @param array $data
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function create(array $data)
    {
        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($data))
            ->send($this->buildUrl(
                '/cgi-bin/department/create',
                [
                    'access_token' => $this->app[ServiceProviders::AccessToken]->getToken()
                ]
            ));

        $this->checkResponse($response, $jsonData);
        return $jsonData;
    }

    /**
     * Update a department.
     * 更新部门
     * doc link: https://work.weixin.qq.com/api/doc/90001/90143/90342
     *
     * @param int $id
     * @param array $data
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function update(int $id, array $data)
    {
        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream(array_merge(compact('id'), $data)))
            ->send($this->buildUrl(
                '/cgi-bin/department/update',
                [
                    'access_token' => $this->app[ServiceProviders::AccessToken]->getToken()
                ]
            ));

        return $this->checkResponse($response);
    }

    /**
     * Delete a department.
     * 删除部门
     * doc link: https://work.weixin.qq.com/api/doc/90001/90143/90343
     *
     * @param $id
     * @return bool
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function delete($id)
    {
        $query = [
            'id' => $id,
            'access_token' => $this->app[ServiceProviders::AccessToken]->getToken()
        ];

        $response = $this->getClient()
            ->setMethod('GET')
            ->send($this->buildUrl(
                '/cgi-bin/department/delete',
                $query
            ));

        return $this->checkResponse($response);
    }

    /**
     * Get department lists.
     * 获取部门列表
     * doc link: https://work.weixin.qq.com/api/doc/90001/90143/90344
     *
     * @param null $id
     * @return bool
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function list($id = null)
    {
        $query = [
            'id' => $id,
            'access_token' => $this->app[ServiceProviders::AccessToken]->getToken()
        ];

        $response = $this->getClient()
            ->setMethod('GET')
            ->send($this->buildUrl(
                '/cgi-bin/department/list',
                $query
            ));

        $this->checkResponse($response, $jsonData);
        return $jsonData;
    }
}