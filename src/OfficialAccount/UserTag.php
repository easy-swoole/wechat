<?php
/**
 * Created by PhpStorm.
 * User: runs
 * Date: 19-1-13
 * Time: 下午5:08
 */

namespace EasySwoole\WeChat\OfficialAccount;


use EasySwoole\WeChat\Utility\HttpClient;

class UserTag extends OfficialAccountBase
{
    /**
     * @return mixed
     * @throws \EasySwoole\WeChat\Exception\OfficialAccountError
     * @throws \EasySwoole\WeChat\Exception\RequestError
     */
    public function list()
    {
        $url = ApiUrl::generateURL(ApiUrl::TAG_LIST, [
            'ACCESS_TOKEN'=> $this->getOfficialAccount()->accessToken()->getToken()
        ]);

        $response = HttpClient::getForJson($url);
        return $this->hasException($response);
    }

    /**
     * @param string $name
     * @return mixed
     * @throws \EasySwoole\WeChat\Exception\OfficialAccountError
     * @throws \EasySwoole\WeChat\Exception\RequestError
     */
    public function create(string $name)
    {
        $url = ApiUrl::generateURL(ApiUrl::TAG_CREATE, [
            'ACCESS_TOKEN'=> $this->getOfficialAccount()->accessToken()->getToken()
        ]);

        $postData = [
            'tag' => ['name' => $name]
        ];

        $response = HttpClient::postJsonForJson($url, $postData);
        return $this->hasException($response);
    }

    /**
     * @param int    $tagId
     * @param string $name
     * @return mixed
     * @throws \EasySwoole\WeChat\Exception\OfficialAccountError
     * @throws \EasySwoole\WeChat\Exception\RequestError
     */
    public function update(int $tagId, string $name)
    {
        $url = ApiUrl::generateURL(ApiUrl::TAG_UPDATE, [
            'ACCESS_TOKEN'=> $this->getOfficialAccount()->accessToken()->getToken()
        ]);

        $postData = [
            'tag' => [
                'name' => $name,
                'id' => $tagId
            ]
        ];

        $response = HttpClient::postJsonForJson($url, $postData);
        return $this->hasException($response);
    }

    /**
     * @param int $tagId
     * @return mixed
     * @throws \EasySwoole\WeChat\Exception\OfficialAccountError
     * @throws \EasySwoole\WeChat\Exception\RequestError
     */
    public function delete(int $tagId)
    {
        $url = ApiUrl::generateURL(ApiUrl::TAG_DELETE, [
            'ACCESS_TOKEN'=> $this->getOfficialAccount()->accessToken()->getToken()
        ]);

        $postData = [
            'tag' => ['id' => $tagId]
        ];

        $response = HttpClient::postJsonForJson($url, $postData);
        return $this->hasException($response);
    }

    /**
     * @param string $openid
     * @return mixed
     * @throws \EasySwoole\WeChat\Exception\OfficialAccountError
     * @throws \EasySwoole\WeChat\Exception\RequestError
     */
    public function userTags(string $openid)
    {
        $url = ApiUrl::generateURL(ApiUrl::GET_USER_TAG_LIST, [
            'ACCESS_TOKEN'=> $this->getOfficialAccount()->accessToken()->getToken()
        ]);

        $response = HttpClient::postJsonForJson($url, ['openid' => $openid]);
        return $this->hasException($response);
    }

    /**
     * @param int         $tagId
     * @param string|null $nextOpenId
     * @return mixed
     * @throws \EasySwoole\WeChat\Exception\OfficialAccountError
     * @throws \EasySwoole\WeChat\Exception\RequestError
     */
    public function usersOfTag(int $tagId, string $nextOpenId = null)
    {
        $url = ApiUrl::generateURL(ApiUrl::GET_USER_LIST_OF_TAG, [
            'ACCESS_TOKEN'=> $this->getOfficialAccount()->accessToken()->getToken()
        ]);

        $postData = [
            'tagid' => $tagId,
            'next_openid' => $nextOpenId
        ];

        $response = HttpClient::postJsonForJson($url, $postData);
        return $this->hasException($response);
    }

    /**
     * @param array $openids
     * @param int   $tagId
     * @return mixed
     * @throws \EasySwoole\WeChat\Exception\OfficialAccountError
     * @throws \EasySwoole\WeChat\Exception\RequestError
     *
     */
    public function tagUsers(array $openids, int $tagId)
    {
        $url = ApiUrl::generateURL(ApiUrl::BATCH_TAGGING, [
            'ACCESS_TOKEN'=> $this->getOfficialAccount()->accessToken()->getToken()
        ]);

        $postData = [
            'openid_list' => $openids,
            'tagid' => $tagId
        ];

        $response = HttpClient::postJsonForJson($url, $postData);
        return $this->hasException($response);
    }

    /**
     * @param array $openids
     * @param int   $tagId
     * @return mixed
     * @throws \EasySwoole\WeChat\Exception\OfficialAccountError
     * @throws \EasySwoole\WeChat\Exception\RequestError
     */
    public function untagUsers(array $openids, int $tagId)
    {
        $url = ApiUrl::generateURL(ApiUrl::BATCH_UNTAGGING, [
            'ACCESS_TOKEN'=> $this->getOfficialAccount()->accessToken()->getToken()
        ]);

        $postData = [
            'openid_list' => $openids,
            'tagid' => $tagId
        ];

        $response = HttpClient::postJsonForJson($url, $postData);
        return $this->hasException($response);
    }
}