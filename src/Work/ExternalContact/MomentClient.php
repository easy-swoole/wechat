<?php

namespace EasySwoole\WeChat\Work\ExternalContact;

use EasySwoole\WeChat\Kernel\ServiceProviders;
use EasySwoole\WeChat\Work\BaseClient;

/**
 * Class MomentClient
 * @package EasySwoole\WeChat\Work\ExternalContact
 * @author: XueSi
 * @email: <1592328848@qq.com>
 */
class MomentClient extends BaseClient
{
    /**
     * 获取企业全部的发表列表
     * doc link: https://open.work.weixin.qq.com/api/doc/90000/90135/93333#获取企业全部的发表列表
     *
     * @param array $params
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function list(array $params)
    {
        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/cgi-bin/externalcontact/get_moment_list',
                [
                    'access_token' => $this->app[ServiceProviders::AccessToken]->getToken()
                ]
            ));

        $this->checkResponse($response, $jsonData);
        return $jsonData;
    }

    /**
     * 获取客户朋友圈企业发表的列表
     * doc link: https://open.work.weixin.qq.com/api/doc/90000/90135/93333#获取客户朋友圈企业发表的列表
     *
     * @param string $momentId
     * @param string $cursor
     * @param int $limit
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function getTasks(string $momentId, string $cursor, int $limit)
    {
        $params = [
            'moment_id' => $momentId,
            'cursor' => $cursor,
            'limit' => $limit
        ];

        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/cgi-bin/externalcontact/get_moment_task',
                [
                    'access_token' => $this->app[ServiceProviders::AccessToken]->getToken()
                ]
            ));

        $this->checkResponse($response, $jsonData);
        return $jsonData;
    }

    /**
     * 获取客户朋友圈发表时选择的可见范围
     * doc link: https://open.work.weixin.qq.com/api/doc/90000/90135/93333#获取客户朋友圈发表时选择的可见范围
     *
     * @param string $momentId
     * @param string $userId
     * @param string $cursor
     * @param int $limit
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function getCustomers(string $momentId, string $userId, string $cursor, int $limit)
    {
        $params = [
            'moment_id' => $momentId,
            'userid' => $userId,
            'cursor' => $cursor,
            'limit' => $limit
        ];

        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/cgi-bin/externalcontact/get_moment_customer_list',
                [
                    'access_token' => $this->app[ServiceProviders::AccessToken]->getToken()
                ]
            ));

        $this->checkResponse($response, $jsonData);
        return $jsonData;
    }

    /**
     * 获取客户朋友圈发表后的可见客户列表
     * doc link: https://open.work.weixin.qq.com/api/doc/90000/90135/93333#获取客户朋友圈发表后的可见客户列表
     *
     * @param string $momentId
     * @param string $userId
     * @param string $cursor
     * @param int $limit
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function getSendResult(string $momentId, string $userId, string $cursor, int $limit)
    {
        $params = [
            'moment_id' => $momentId,
            'userid' => $userId,
            'cursor' => $cursor,
            'limit' => $limit
        ];

        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/cgi-bin/externalcontact/get_moment_send_result',
                [
                    'access_token' => $this->app[ServiceProviders::AccessToken]->getToken()
                ]
            ));

        $this->checkResponse($response, $jsonData);
        return $jsonData;
    }

    /**
     * 获取客户朋友圈的互动数据
     * doc link: https://open.work.weixin.qq.com/api/doc/90000/90135/93333#获取客户朋友圈的互动数据
     *
     * @param string $momentId
     * @param string $userId
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function getComments(string $momentId, string $userId)
    {
        $params = [
            'moment_id' => $momentId,
            'userid' => $userId
        ];

        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/cgi-bin/externalcontact/get_moment_comments',
                [
                    'access_token' => $this->app[ServiceProviders::AccessToken]->getToken()
                ]
            ));

        $this->checkResponse($response, $jsonData);
        return $jsonData;
    }
}
