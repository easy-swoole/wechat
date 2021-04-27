<?php

namespace EasySwoole\WeChat\Work\ExternalContact;

use EasySwoole\WeChat\Kernel\ServiceProviders;
use EasySwoole\WeChat\Work\BaseClient;

/**
 * Class Client
 * @package EasySwoole\WeChat\Work\ExternalContact
 * @author: XueSi
 * @email: <1592328848@qq.com>
 */
class Client extends BaseClient
{
    /**
     * 获取配置了客户联系功能的成员列表
     * doc link: https://work.weixin.qq.com/api/doc/90000/90135/92571
     *
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function getFollowUsers()
    {
        $response = $this->getClient()
            ->setMethod('GET')
            ->send($this->buildUrl(
                '/cgi-bin/externalcontact/get_follow_user_list',
                [
                    'access_token' => $this->app[ServiceProviders::AccessToken]->getToken()
                ]
            ));

        $this->checkResponse($response, $jsonData);
        return $jsonData;
    }

    /**
     * 获取客户列表
     * doc link: https://work.weixin.qq.com/api/doc/90000/90135/92113
     *
     * @param string $userId
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function list(string $userId)
    {
        $query = [
            'userid' => $userId,
            'access_token' => $this->app[ServiceProviders::AccessToken]->getToken()
        ];

        $response = $this->getClient()
            ->setMethod('GET')
            ->send($this->buildUrl(
                '/cgi-bin/externalcontact/list',
                $query
            ));

        $this->checkResponse($response, $jsonData);
        return $jsonData;
    }

    /**
     * 批量获取客户详情
     * doc link: https://work.weixin.qq.com/api/doc/90000/90135/92994
     *
     * @param string $userId
     * @param string $cursor
     * @param int $limit
     * @return bool
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function batchGet(string $userId, string $cursor = '', int $limit = 100)
    {
        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream([
                'userid' => $userId,
                'cursor' => $cursor,
                'limit' => $limit,
            ]))
            ->send($this->buildUrl(
                '/cgi-bin/externalcontact/batch/get_by_user',
                [
                    'access_token' => $this->app[ServiceProviders::AccessToken]->getToken()
                ]
            ));

        $this->checkResponse($response, $jsonData);
        return $jsonData;
    }

    /**
     * 获取客户详情
     * doc link: https://work.weixin.qq.com/api/doc/90000/90135/92114
     *
     * @param string $externalUserId
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function get(string $externalUserId)
    {
        $query = [
            'external_userid' => $externalUserId,
            'access_token' => $this->app[ServiceProviders::AccessToken]->getToken()
        ];

        $response = $this->getClient()
            ->setMethod('GET')
            ->send($this->buildUrl(
                '/cgi-bin/externalcontact/get',
                $query
            ));

        $this->checkResponse($response, $jsonData);
        return $jsonData;
    }

    /**
     * 批量获取客户详情
     * doc link: https://work.weixin.qq.com/api/doc/90000/90135/92994
     *
     * @param string $userId
     * @param string $cursor
     * @param int $limit
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function batchGetByUser(string $userId, string $cursor, int $limit)
    {
        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream([
                'userid' => $userId,
                'cursor' => $cursor,
                'limit' => $limit
            ]))
            ->send($this->buildUrl(
                '/cgi-bin/externalcontact/batch/get_by_user',
                [
                    'access_token' => $this->app[ServiceProviders::AccessToken]->getToken()
                ]
            ));

        $this->checkResponse($response, $jsonData);
        return $jsonData;
    }

    /**
     * 修改客户备注信息
     * doc link: https://work.weixin.qq.com/api/doc/90000/90135/92115
     *
     * @param array $data
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function remark(array $data)
    {
        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($data))
            ->send($this->buildUrl(
                '/cgi-bin/externalcontact/remark',
                [
                    'access_token' => $this->app[ServiceProviders::AccessToken]->getToken()
                ]
            ));

        return $this->checkResponse($response);
    }

    /**
     * 获取待分配的离职成员列表
     * doc link: https://work.weixin.qq.com/api/doc/90000/90135/92124
     *
     * @param int $pageId
     * @param int $pageSize
     * @return bool
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function getUnassigned(int $pageId = 0, int $pageSize = 1000)
    {
        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream([
                'page_id' => $pageId,
                'page_size' => $pageSize,
            ]))
            ->send($this->buildUrl(
                '/cgi-bin/externalcontact/get_unassigned_list',
                [
                    'access_token' => $this->app[ServiceProviders::AccessToken]->getToken()
                ]
            ));

        $this->checkResponse($response, $jsonData);
        return $jsonData;
    }

    /**
     * 离职成员的外部联系人再分配
     * doc link: https://open.work.weixin.qq.com/api/doc/14020
     *
     * @param string $externalUserId
     * @param string $handoverUserId
     * @param string $takeoverUserId
     * @param string $transferSuccessMessage
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function transfer(string $externalUserId, string $handoverUserId, string $takeoverUserId, string $transferSuccessMessage)
    {
        $params = [
            'external_userid' => $externalUserId,
            'handover_userid' => $handoverUserId,
            'takeover_userid' => $takeoverUserId,
            'transfer_success_msg' => $transferSuccessMessage
        ];

        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/cgi-bin/externalcontact/transfer',
                [
                    'access_token' => $this->app[ServiceProviders::AccessToken]->getToken()
                ]
            ));

        return $this->checkResponse($response);
    }

    /**
     * 分配离职成员的客户群
     * doc link: https://work.weixin.qq.com/api/doc/90000/90135/92127
     *
     * @param array $chatIds
     * @param string $newOwner
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function transferGroupChat(array $chatIds, string $newOwner)
    {
        $params = [
            'chat_id_list' => $chatIds,
            'new_owner' => $newOwner
        ];

        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/cgi-bin/externalcontact/groupchat/transfer',
                [
                    'access_token' => $this->app[ServiceProviders::AccessToken]->getToken()
                ]
            ));

        $this->checkResponse($response, $jsonData);
        return $jsonData;
    }

    /**
     * 查询客户接替结果
     * 找不到具体的接口文档
     * doc link: https://work.weixin.qq.com/api/doc/90001/90143/93009
     *
     * @param string $externalUserId
     * @param string $handoverUserId
     * @param string $takeoverUserId
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function getTransferResult(string $externalUserId, string $handoverUserId, string $takeoverUserId)
    {
        $params = [
            'external_userid' => $externalUserId,
            'handover_userid' => $handoverUserId,
            'takeover_userid' => $takeoverUserId,
        ];

        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/cgi-bin/externalcontact/get_transfer_result',
                [
                    'access_token' => $this->app[ServiceProviders::AccessToken]->getToken()
                ]
            ));

        $this->checkResponse($response, $jsonData);
        return $jsonData;
    }

    /**
     * 获取客户群列表
     * doc link: https://work.weixin.qq.com/api/doc/90000/90135/92120
     *
     * @param array $params
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function getGroupChats(array $params)
    {
        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/cgi-bin/externalcontact/groupchat/list',
                [
                    'access_token' => $this->app[ServiceProviders::AccessToken]->getToken()
                ]
            ));

        $this->checkResponse($response, $jsonData);
        return $jsonData;
    }

    /**
     * 获取客户群详情
     * doc link: https://work.weixin.qq.com/api/doc/90000/90135/92122
     *
     * @param string $chatId
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function getGroupChat(string $chatId)
    {
        $params = [
            'chat_id' => $chatId
        ];

        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/cgi-bin/externalcontact/groupchat/get',
                [
                    'access_token' => $this->app[ServiceProviders::AccessToken]->getToken()
                ]
            ));

        $this->checkResponse($response, $jsonData);
        return $jsonData;
    }

    /**
     * 获取企业标签库
     * doc link: https://work.weixin.qq.com/api/doc/90000/90135/92117#获取企业标签库
     *
     * @param array $tagIds
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function getCorpTags(array $tagIds = [])
    {
        $params = [
            'tag_id' => $tagIds
        ];

        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/cgi-bin/externalcontact/get_corp_tag_list',
                [
                    'access_token' => $this->app[ServiceProviders::AccessToken]->getToken()
                ]
            ));

        $this->checkResponse($response, $jsonData);
        return $jsonData;
    }

    /**
     * 添加企业客户标签
     * doc link: https://work.weixin.qq.com/api/doc/90000/90135/92117#添加企业客户标签
     *
     * @param array $params
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function addCorpTag(array $params)
    {
        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/cgi-bin/externalcontact/add_corp_tag',
                [
                    'access_token' => $this->app[ServiceProviders::AccessToken]->getToken()
                ]
            ));

        $this->checkResponse($response, $jsonData);
        return $jsonData;
    }

    /**
     * 编辑企业客户标签
     * doc link: https://work.weixin.qq.com/api/doc/90000/90135/92117#编辑企业客户标签
     *
     * @param string $id
     * @param string $name
     * @param int $order
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function updateCorpTag(string $id, string $name, int $order = 1)
    {
        $params = [
            "id" => $id,
            "name" => $name,
            "order" => $order,
        ];

        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/cgi-bin/externalcontact/edit_corp_tag',
                [
                    'access_token' => $this->app[ServiceProviders::AccessToken]->getToken()
                ]
            ));

        return $this->checkResponse($response);
    }

    /**
     * 删除企业客户标签
     * doc link: https://work.weixin.qq.com/api/doc/90000/90135/92117#删除企业客户标签
     *
     * @param array $tagId
     * @param array $groupId
     * @return bool
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function deleteCorpTag(array $tagId, array $groupId)
    {
        $params = [
            "tag_id" => $tagId,
            "group_id" => $groupId,
        ];

        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/cgi-bin/externalcontact/del_corp_tag',
                [
                    'access_token' => $this->app[ServiceProviders::AccessToken]->getToken()
                ]
            ));

        return $this->checkResponse($response);
    }

    /**
     * 编辑客户企业标签
     * doc link: https://work.weixin.qq.com/api/doc/90000/90135/92118
     *
     * @param array $params
     * @return bool
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function markTags(array $params)
    {
        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/cgi-bin/externalcontact/mark_tag',
                [
                    'access_token' => $this->app[ServiceProviders::AccessToken]->getToken()
                ]
            ));

        return $this->checkResponse($response);
    }
}