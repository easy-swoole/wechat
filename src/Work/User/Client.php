<?php

namespace EasySwoole\WeChat\Work\User;

use EasySwoole\WeChat\Kernel\Exceptions\InvalidArgumentException;
use EasySwoole\WeChat\Kernel\ServiceProviders;
use EasySwoole\WeChat\Work\BaseClient;

/**
 * Class Client
 * @package EasySwoole\WeChat\Work\User
 * @author: XueSi
 * @email: <1592328848@qq.com>
 */
class Client extends BaseClient
{
    /**
     * 创建成员
     * Create a user
     * doc link: https://open.work.weixin.qq.com/api/doc/90000/90135/90195
     *
     * @param array $data
     * @return bool
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function create(array $data)
    {
        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($data))
            ->send($this->buildUrl(
                '/cgi-bin/user/create',
                [
                    'access_token' => $this->app[ServiceProviders::AccessToken]->getToken()
                ]
            ));

        return $this->checkResponse($response);
    }

    /**
     * 更新成员
     * Update an exist user
     * doc link: https://open.work.weixin.qq.com/api/doc/90000/90135/90197
     *
     * @param string $id
     * @param array $data
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function update(string $id, array $data)
    {
        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream(array_merge(['userid' => $id], $data)))
            ->send($this->buildUrl(
                '/cgi-bin/user/update',
                [
                    'access_token' => $this->app[ServiceProviders::AccessToken]->getToken()
                ]
            ));

        return $this->checkResponse($response);
    }

    /**
     * 删除成员
     * Delete a user
     * doc link: https://open.work.weixin.qq.com/api/doc/90000/90135/90198
     *
     * @param $userId
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function delete($userId)
    {
        if (is_array($userId)) {
            return $this->batchDelete($userId);
        }

        $query = [
            'userid' => $userId,
            'access_token' => $this->app[ServiceProviders::AccessToken]->getToken()
        ];

        $response = $this->getClient()
            ->setMethod('GET')
            ->send($this->buildUrl(
                '/cgi-bin/user/delete',
                $query
            ));

        return $this->checkResponse($response);
    }

    /**
     * 批量删除成员
     * Batch delete users
     * doc link: https://open.work.weixin.qq.com/api/doc/90000/90135/90199
     *
     * @param array $userIds
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function batchDelete(array $userIds)
    {
        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream(['useridlist' => $userIds]))
            ->send($this->buildUrl(
                '/cgi-bin/user/batchdelete',
                [
                    'access_token' => $this->app[ServiceProviders::AccessToken]->getToken()
                ]
            ));

        return $this->checkResponse($response);
    }

    /**
     * 读取成员
     * Get user
     * doc link: https://open.work.weixin.qq.com/api/doc/90000/90135/90196
     *
     * @param string $userId
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function get(string $userId)
    {
        $query = [
            'userid' => $userId,
            'access_token' => $this->app[ServiceProviders::AccessToken]->getToken()
        ];

        $response = $this->getClient()
            ->setMethod('GET')
            ->send($this->buildUrl(
                '/cgi-bin/user/get',
                $query
            ));

        $this->checkResponse($response, $parseData);
        return $parseData;
    }

    /**
     * 获取部门成员
     * Get simple user list
     * doc link: https://open.work.weixin.qq.com/api/doc/90000/90135/90200
     *
     * @param int $departmentId
     * @param bool $fetchChild
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function getDepartmentUsers(int $departmentId, bool $fetchChild = false)
    {
        $query = [
            'department_id' => $departmentId,
            'fetch_child' => (int)$fetchChild,
            'access_token' => $this->app[ServiceProviders::AccessToken]->getToken()
        ];

        $response = $this->getClient()
            ->setMethod('GET')
            ->send($this->buildUrl(
                '/cgi-bin/user/simplelist',
                $query
            ));

        $this->checkResponse($response, $parseData);
        return $parseData;
    }

    /**
     * 获取部门成员详情
     * Get user list
     * doc link: https://open.work.weixin.qq.com/api/doc/90000/90135/90201
     *
     * @param int $departmentId
     * @param bool $fetchChild
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function getDetailedDepartmentUsers(int $departmentId, bool $fetchChild = false)
    {
        $query = [
            'department_id' => $departmentId,
            'fetch_child' => (int)$fetchChild,
            'access_token' => $this->app[ServiceProviders::AccessToken]->getToken()
        ];

        $response = $this->getClient()
            ->setMethod('GET')
            ->send($this->buildUrl(
                '/cgi-bin/user/list',
                $query
            ));

        $this->checkResponse($response, $parseData);
        return $parseData;
    }

    /**
     * userid转openid (userid与openid互换)
     * Convert openid to userId
     * doc link: https://open.work.weixin.qq.com/api/doc/90000/90135/90202#userid转openid
     *
     * @param string $userId
     * @param int|null $agentId
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function userIdToOpenid(string $userId, int $agentId = null)
    {
        $params = [
            'userid' => $userId,
            'agentid' => $agentId,
        ];

        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/cgi-bin/user/convert_to_openid',
                [
                    'access_token' => $this->app[ServiceProviders::AccessToken]->getToken()
                ]
            ));

        $this->checkResponse($response, $parseData);
        return $parseData;
    }

    /**
     * openid转userid (userid与openid互换)
     * Convert openid to userId
     * doc link: https://open.work.weixin.qq.com/api/doc/90000/90135/90202#openid转userid
     *
     * @param string $openid
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function openidToUserId(string $openid)
    {
        $params = [
            'openid' => $openid,
        ];

        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/cgi-bin/user/convert_to_userid',
                [
                    'access_token' => $this->app[ServiceProviders::AccessToken]->getToken()
                ]
            ));

        $this->checkResponse($response, $parseData);
        return $parseData;
    }

    /**
     * 手机号获取userid
     * Convert mobile to userId
     * doc link: https://open.work.weixin.qq.com/api/doc/90001/90143/91693
     *
     * @param string $mobile
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function mobileToUserId(string $mobile)
    {
        $params = [
            'mobile' => $mobile,
        ];

        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/cgi-bin/user/getuserid',
                [
                    'access_token' => $this->app[ServiceProviders::AccessToken]->getToken()
                ]
            ));

        $this->checkResponse($response, $parseData);
        return $parseData;
    }

    /**
     * 二次验证
     * doc link: https://open.work.weixin.qq.com/api/doc/90001/90143/90339
     *
     * @param string $userId
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function accept(string $userId)
    {
        $query = [
            'userid' => $userId,
            'access_token' => $this->app[ServiceProviders::AccessToken]->getToken()
        ];

        $response = $this->getClient()
            ->setMethod('GET')
            ->send($this->buildUrl(
                '/cgi-bin/user/authsucc',
                $query
            ));

        return $this->checkResponse($response);
    }

    /**
     * 邀请成员
     * Batch invite users
     * doc link: https://open.work.weixin.qq.com/api/doc/90001/90143/91127
     *
     *
     * @param array $params
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function invite(array $params)
    {
        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/cgi-bin/batch/invite',
                [
                    'access_token' => $this->app[ServiceProviders::AccessToken]->getToken()
                ]
            ));

        $this->checkResponse($response, $parseData);
        return $parseData;
    }

    /**
     * 获取加入企业二维码
     * Get invitation QR code
     * doc link: https://open.work.weixin.qq.com/api/doc/90000/90135/91714
     *
     * @param int $sizeType
     * @return mixed
     * @throws InvalidArgumentException
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function getInvitationQrCode(int $sizeType = 1)
    {
        if (!\in_array($sizeType, [1, 2, 3, 4], true)) {
            throw new InvalidArgumentException('The sizeType must be 1, 2, 3, 4.');
        }

        $query = [
            'size_type' => $sizeType,
            'access_token' => $this->app[ServiceProviders::AccessToken]->getToken()
        ];

        $response = $this->getClient()
            ->setMethod('GET')
            ->send($this->buildUrl(
                '/cgi-bin/corp/get_join_qrcode',
                $query
            ));

        $this->checkResponse($response, $parseData);
        return $parseData;
    }
}
