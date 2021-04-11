<?php

namespace EasySwoole\WeChat\Work\User;

use EasySwoole\WeChat\Kernel\ServiceProviders;
use EasySwoole\WeChat\Work\BaseClient;

/**
 * Class LinkedCorpClient
 * @package EasySwoole\WeChat\Work\User
 * @author: XueSi
 * @email: <1592328848@qq.com>
 */
class LinkedCorpClient extends BaseClient
{
    /**
     * 获取应用的可见范围
     * doc link: https://open.work.weixin.qq.com/api/doc/90000/90135/93172
     *
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function getAgentPermissions()
    {
        $response = $this->getClient()
            ->setMethod('POST')
            ->send($this->buildUrl(
                '/cgi-bin/linkedcorp/agent/get_perm_list',
                [
                    'access_token' => $this->app[ServiceProviders::AccessToken]->getToken()
                ]
            ));

        $this->checkResponse($response, $parseData);
        return $parseData;
    }

    /**
     * 获取互联企业成员详细信息
     * doc link: https://open.work.weixin.qq.com/api/doc/90000/90135/93171
     *
     * @param string $userId
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function getUser(string $userId)
    {
        $params = [
            'userid' => $userId
        ];

        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/cgi-bin/linkedcorp/user/get',
                [
                    'access_token' => $this->app[ServiceProviders::AccessToken]->getToken()
                ]
            ));

        $this->checkResponse($response, $parseData);
        return $parseData;
    }

    /**
     * .
     *
     * @see
     *
     * @param string $departmentId
     * @param bool $fetchChild
     *
     * @return \Psr\Http\Message\ResponseInterface|\EasyWeChat\Kernel\Support\Collection|array|object|string
     *
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    /**
     * 获取互联企业部门成员
     * doc link: https://open.work.weixin.qq.com/api/doc/90000/90135/93168
     *
     * @param string $departmentId
     * @param bool $fetchChild
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function getUsers(string $departmentId, bool $fetchChild = true)
    {
        $params = [
            'department_id' => $departmentId,
            'fetch_child' => $fetchChild
        ];

        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/cgi-bin/linkedcorp/user/simplelist',
                [
                    'access_token' => $this->app[ServiceProviders::AccessToken]->getToken()
                ]
            ));

        $this->checkResponse($response, $parseData);
        return $parseData;
    }

    /**
     * 获取互联企业部门成员详情
     * doc link: https://open.work.weixin.qq.com/api/doc/90000/90135/93169
     *
     * @param string $departmentId
     * @param bool $fetchChild
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function getDetailedUsers(string $departmentId, bool $fetchChild = true)
    {
        $params = [
            'department_id' => $departmentId,
            'fetch_child' => $fetchChild
        ];

        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/cgi-bin/linkedcorp/user/list',
                [
                    'access_token' => $this->app[ServiceProviders::AccessToken]->getToken()
                ]
            ));

        $this->checkResponse($response, $parseData);
        return $parseData;
    }

    /**
     * 获取互联企业部门列表
     * doc link: https://open.work.weixin.qq.com/api/doc/90000/90135/93170
     *
     * @param string $departmentId
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function getDepartments(string $departmentId)
    {
        $params = [
            'department_id' => $departmentId,
        ];

        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/cgi-bin/linkedcorp/department/list',
                [
                    'access_token' => $this->app[ServiceProviders::AccessToken]->getToken()
                ]
            ));

        $this->checkResponse($response, $parseData);
        return $parseData;
    }
}