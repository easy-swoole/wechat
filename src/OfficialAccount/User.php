<?php
/**
 * Created by PhpStorm.
 * User: yf
 * Date: 2018/12/25
 * Time: 12:19 AM
 */

namespace EasySwoole\WeChat\OfficialAccount;


use EasySwoole\WeChat\Utility\NetWork;

class User extends OfficialAccountBase
{

    /**
     * @param string $openid
     * @param string $lang
     * @return array
     * @throws \EasySwoole\WeChat\Exception\OfficialAccountError
     * @throws \EasySwoole\WeChat\Exception\RequestError
     */
    public function get(string $openid, string $lang = 'zh_CN')
    {
        $url = ApiUrl::generateURL(ApiUrl::USER_INFO, [
            'ACCESS_TOKEN'=> $this->getOfficialAccount()->accessToken()->getToken(),
            'OPENID' => $openid,
            'LANG' => $lang
        ]);

        $response = NetWork::getForJson($url);
        return $this->hasException($response);
    }

    /**
     * @param array  $openids
     * @param string $lang
     * @return array
     * @throws \EasySwoole\WeChat\Exception\OfficialAccountError
     * @throws \EasySwoole\WeChat\Exception\RequestError
     */
    public function select(array $openids, string $lang = 'zh_CN')
    {
        $url = ApiUrl::generateURL(ApiUrl::USER_INFO_BATCHGET, [
            'ACCESS_TOKEN'=> $this->getOfficialAccount()->accessToken()->getToken()
        ]);

        $postData = [
            'user_list' => array_map(function ($openid) use ($lang){
                return [
                    'openid' => $openid,
                    'lang' => $lang,
                ];
            }, $openids),
        ];

        $response = NetWork::postJsonForJson($url, $postData);
        return $this->hasException($response);
    }

    /**
     * @param null $nextOpenid
     * @return mixed
     * @throws \EasySwoole\WeChat\Exception\OfficialAccountError
     * @throws \EasySwoole\WeChat\Exception\RequestError
     */
    public function list($nextOpenid = null)
    {
        $url = ApiUrl::generateURL(ApiUrl::USER_GET, [
            'ACCESS_TOKEN'=> $this->getOfficialAccount()->accessToken()->getToken(),
            'NEXT_OPENID' => $nextOpenid
        ]);

        $response = NetWork::getForJson($url);
        return $this->hasException($response);
    }

    /**
     * @param string $openid
     * @param string $remark
     * @return mixed
     * @throws \EasySwoole\WeChat\Exception\OfficialAccountError
     * @throws \EasySwoole\WeChat\Exception\RequestError
     */
    public function remark(string $openid, string $remark)
    {
        $url = ApiUrl::generateURL(ApiUrl::USER_UPDATEREMARK, [
            'ACCESS_TOKEN'=> $this->getOfficialAccount()->accessToken()->getToken()
        ]);

        $postData = [
            'openid' => $openid,
            'remark' => $remark
        ];
        $response = NetWork::postJsonForJson($url, $postData);
        return $this->hasException($response);
    }

    /**
     * @param string $beginOpenid
     * @return mixed
     * @throws \EasySwoole\WeChat\Exception\OfficialAccountError
     * @throws \EasySwoole\WeChat\Exception\RequestError
     */
    public function blacklist(string $beginOpenid = null)
    {
        $url = ApiUrl::generateURL(ApiUrl::GET_BLACKLIST, [
            'ACCESS_TOKEN'=> $this->getOfficialAccount()->accessToken()->getToken()
        ]);

        $response = NetWork::postJsonForJson($url, ['begin_openid' => $beginOpenid]);
        return $this->hasException($response);
    }

    /**
     * @param $openidList
     * @return mixed
     * @throws \EasySwoole\WeChat\Exception\OfficialAccountError
     * @throws \EasySwoole\WeChat\Exception\RequestError
     */
    public function black($openidList)
    {
        $url = ApiUrl::generateURL(ApiUrl::BATCH_BLACKLIST, [
            'ACCESS_TOKEN'=> $this->getOfficialAccount()->accessToken()->getToken()
        ]);

        $response = NetWork::postJsonForJson($url, ['openid_list' => (array) $openidList]);
        return $this->hasException($response);
    }

    /**
     * @param $openidList
     * @return mixed
     * @throws \EasySwoole\WeChat\Exception\OfficialAccountError
     * @throws \EasySwoole\WeChat\Exception\RequestError
     */
    public function unblack($openidList)
    {
        $url = ApiUrl::generateURL(ApiUrl::BATCH_UNBLACKLIST, [
            'ACCESS_TOKEN'=> $this->getOfficialAccount()->accessToken()->getToken()
        ]);

        $response = NetWork::postJsonForJson($url, ['openid_list' => (array) $openidList]);
        return $this->hasException($response);
    }

    /**
     * @param string $oldAppId
     * @param array  $openidList
     * @return mixed
     * @throws \EasySwoole\WeChat\Exception\OfficialAccountError
     * @throws \EasySwoole\WeChat\Exception\RequestError
     */
    public function changeOpenid(string $oldAppId, array $openidList)
    {
        $url = ApiUrl::generateURL(ApiUrl::CHANGE_OPENID, [
            'ACCESS_TOKEN'=> $this->getOfficialAccount()->accessToken()->getToken()
        ]);

        $postData = [
            'from_appid' => $oldAppId,
            'openid_list' => $openidList
        ];

        $response = NetWork::postJsonForJson($url, $postData);
        return $this->hasException($response);
    }

    /**
     * @return mixed
     * @throws \EasySwoole\WeChat\Exception\OfficialAccountError
     * @throws \EasySwoole\WeChat\Exception\RequestError
     */
    public function tagList()
    {
        $url = ApiUrl::generateURL(ApiUrl::TAG_LIST, [
            'ACCESS_TOKEN'=> $this->getOfficialAccount()->accessToken()->getToken()
        ]);

        $response = NetWork::getForJson($url);
        return $this->hasException($response);
    }

    /**
     * @param string $name
     * @return mixed
     * @throws \EasySwoole\WeChat\Exception\OfficialAccountError
     * @throws \EasySwoole\WeChat\Exception\RequestError
     */
    public function tagCreate(string $name)
    {
        $url = ApiUrl::generateURL(ApiUrl::TAG_CREATE, [
            'ACCESS_TOKEN'=> $this->getOfficialAccount()->accessToken()->getToken()
        ]);

        $postData = [
            'tag' => ['name' => $name]
        ];

        $response = NetWork::postJsonForJson($url, $postData);
        return $this->hasException($response);
    }

    /**
     * @param int    $tagId
     * @param string $name
     * @return mixed
     * @throws \EasySwoole\WeChat\Exception\OfficialAccountError
     * @throws \EasySwoole\WeChat\Exception\RequestError
     */
    public function tagUpdate(int $tagId, string $name)
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

        $response = NetWork::postJsonForJson($url, $postData);
        return $this->hasException($response);
    }

    /**
     * @param int $tagId
     * @return mixed
     * @throws \EasySwoole\WeChat\Exception\OfficialAccountError
     * @throws \EasySwoole\WeChat\Exception\RequestError
     */
    public function tagDelete(int $tagId)
    {
        $url = ApiUrl::generateURL(ApiUrl::TAG_DELETE, [
            'ACCESS_TOKEN'=> $this->getOfficialAccount()->accessToken()->getToken()
        ]);

        $postData = [
            'tag' => ['id' => $tagId]
        ];

        $response = NetWork::postJsonForJson($url, $postData);
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

        $response = NetWork::postJsonForJson($url, ['openid' => $openid]);
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

        $response = NetWork::postJsonForJson($url, $postData);
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

        $response = NetWork::postJsonForJson($url, $postData);
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

        $response = NetWork::postJsonForJson($url, $postData);
        return $this->hasException($response);
    }
}