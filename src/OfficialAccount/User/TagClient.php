<?php


namespace EasySwoole\WeChat\OfficialAccount\User;


use EasySwoole\WeChat\Kernel\BaseClient;
use EasySwoole\WeChat\Kernel\Exceptions\HttpException;
use EasySwoole\WeChat\Kernel\ServiceProviders;

class TagClient extends BaseClient
{

    /**
     * @param string $name
     * @return mixed
     * @throws HttpException
     */
    public function create(string $name)
    {
        $params = [
            'tag' => ['name' => $name],
        ];

        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/cgi-bin/tags/create',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));
        $this->checkResponse($response, $parseData);

        return $parseData;
    }

    /**
     * @return mixed
     * @throws HttpException
     */
    public function list()
    {
        $response = $this->getClient()
            ->setMethod('GET')
            ->send($this->buildUrl(
                '/cgi-bin/tags/get',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));
        $this->checkResponse($response, $parseData);

        return $parseData;
    }


    /**
     * @param int $tagId
     * @param string $name
     * @return bool
     * @throws HttpException
     */
    public function update(int $tagId, string $name)
    {
        $params = [
            'tag' => [
                'id' => $tagId,
                'name' => $name,
            ],
        ];

        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/cgi-bin/tags/update',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        return $this->checkResponse($response);
    }


    /**
     * @param int $tagId
     * @return bool
     * @throws HttpException
     */
    public function delete(int $tagId)
    {
        $params = [
            'tag' => ['id' => $tagId],
        ];

        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/cgi-bin/tags/delete',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        return $this->checkResponse($response);
    }


    /**
     * @param string $openid
     * @return mixed
     * @throws HttpException
     */
    public function userTags(string $openid)
    {
        $params = ['openid' => $openid];

        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/cgi-bin/tags/getidlist',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));
        $this->checkResponse($response, $parseData);

        return $parseData;
    }


    /**
     * @param int $tagId
     * @param string $nextOpenId
     * @return mixed
     * @throws HttpException
     */
    public function usersOfTag(int $tagId, string $nextOpenId = '')
    {
        $params = [
            'tagid' => $tagId,
            'next_openid' => $nextOpenId,
        ];

        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/cgi-bin/user/tag/get',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));
        $this->checkResponse($response, $parseData);

        return $parseData;
    }

    /**
     * @param array $openids
     * @param int $tagId
     * @return bool
     * @throws HttpException
     */
    public function tagUsers(array $openids, int $tagId)
    {
        $params = [
            'openid_list' => $openids,
            'tagid' => $tagId,
        ];

        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/cgi-bin/tags/members/batchtagging',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        return $this->checkResponse($response);
    }


    /**
     * @param array $openids
     * @param int $tagId
     * @return bool
     * @throws HttpException
     */
    public function untagUsers(array $openids, int $tagId)
    {
        $params = [
            'openid_list' => $openids,
            'tagid' => $tagId,
        ];

        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/cgi-bin/tags/members/batchuntagging',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        return $this->checkResponse($response);
    }
}