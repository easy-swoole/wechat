<?php

namespace EasySwoole\WeChat\Work\User;

use EasySwoole\WeChat\Kernel\ServiceProviders;
use EasySwoole\WeChat\Work\BaseClient;

/**
 * Class TagClient
 * @package EasySwoole\WeChat\Work\User
 * @author: XueSi
 * @email: <1592328848@qq.com>
 */
class TagClient extends BaseClient
{
    /**
     * 创建标签
     * Create tag
     * doc link: https://open.work.weixin.qq.com/api/doc/90000/90135/90210
     *
     * @param string $tagName
     * @param int|null $tagId
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function create(string $tagName, int $tagId = null)
    {
        $params = [
            'tagname' => $tagName,
            'tagid' => $tagId,
        ];

        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/cgi-bin/tag/create',
                [
                    'access_token' => $this->app[ServiceProviders::AccessToken]->getToken()
                ]
            ));

        $this->checkResponse($response, $parseData);
        return $parseData;
    }

    /**
     * 更新标签名字
     * Update tag
     * doc link: https://open.work.weixin.qq.com/api/doc/90000/90135/90211
     *
     * @param int $tagId
     * @param string $tagName
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function update(int $tagId, string $tagName)
    {
        $params = [
            'tagid' => $tagId,
            'tagname' => $tagName,
        ];

        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/cgi-bin/tag/update',
                [
                    'access_token' => $this->app[ServiceProviders::AccessToken]->getToken()
                ]
            ));

        return $this->checkResponse($response);
    }

    /**
     * 删除标签
     * Delete tag
     * doc link: https://open.work.weixin.qq.com/api/doc/90000/90135/90212
     *
     * @param int $tagId
     * @return bool
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function delete(int $tagId)
    {
        $query = [
            'tagid' => $tagId,
            'access_token' => $this->app[ServiceProviders::AccessToken]->getToken()
        ];

        $response = $this->getClient()
            ->setMethod('GET')
            ->send($this->buildUrl(
                '/cgi-bin/tag/delete',
                $query
            ));

        return $this->checkResponse($response);
    }

    /**
     * 获取标签成员
     * doc link: https://open.work.weixin.qq.com/api/doc/90000/90135/90213
     *
     * @param int $tagId
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function get(int $tagId)
    {
        $query = [
            'tagid' => $tagId,
            'access_token' => $this->app[ServiceProviders::AccessToken]->getToken()
        ];

        $response = $this->getClient()
            ->setMethod('GET')
            ->send($this->buildUrl(
                '/cgi-bin/tag/get',
                $query
            ));

        $this->checkResponse($response, $parseData);
        return $parseData;
    }

    /**
     * 增加标签成员
     * doc link: https://open.work.weixin.qq.com/api/doc/90000/90135/90214
     *
     * @param int $tagId
     * @param array $userList
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function tagUsers(int $tagId, array $userList = [])
    {
        return $this->tagOrUntagUsers('cgi-bin/tag/addtagusers', $tagId, $userList);
    }

    /**
     * 增加标签成员 (部门)
     * doc link: https://open.work.weixin.qq.com/api/doc/90000/90135/90214
     *
     * @param int $tagId
     * @param array $partyList
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function tagDepartments(int $tagId, array $partyList = [])
    {
        return $this->tagOrUntagUsers('cgi-bin/tag/addtagusers', $tagId, [], $partyList);
    }

    /**
     * 删除标签成员
     * doc link: https://open.work.weixin.qq.com/api/doc/90000/90135/90215
     *
     * @param int $tagId
     * @param array $userList
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function untagUsers(int $tagId, array $userList = [])
    {
        return $this->tagOrUntagUsers('cgi-bin/tag/deltagusers', $tagId, $userList);
    }

    /**
     * 删除标签成员 (部门)
     * doc link: https://open.work.weixin.qq.com/api/doc/90000/90135/90215
     *
     * @param int $tagId
     * @param array $partyList
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function untagDepartments(int $tagId, array $partyList = [])
    {
        return $this->tagOrUntagUsers('cgi-bin/tag/deltagusers', $tagId, [], $partyList);
    }

    /**
     * 获取标签列表
     * doc link: https://open.work.weixin.qq.com/api/doc/90000/90135/90216
     *
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function list()
    {
        $response = $this->getClient()
            ->setMethod('GET')
            ->send($this->buildUrl(
                '/cgi-bin/tag/list',
                [
                    'access_token' => $this->app[ServiceProviders::AccessToken]->getToken()
                ]
            ));

        $this->checkResponse($response, $parseData);
        return $parseData;
    }

    /**
     * @param string $endpoint
     * @param int $tagId
     * @param array $userList
     * @param array $partyList
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    protected function tagOrUntagUsers(string $endpoint, int $tagId, array $userList = [], array $partyList = [])
    {
        $data = [
            'tagid' => $tagId,
            'userlist' => $userList,
            'partylist' => $partyList,
        ];

        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($data))
            ->send($this->buildUrl(
                '/' . $endpoint,
                [
                    'access_token' => $this->app[ServiceProviders::AccessToken]->getToken()
                ]
            ));

        $this->checkResponse($response, $parseData);
        return $parseData;
    }
}
