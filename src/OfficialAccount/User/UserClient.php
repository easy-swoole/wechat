<?php


namespace EasySwoole\WeChat\OfficialAccount\User;


use EasySwoole\WeChat\Kernel\BaseClient;
use EasySwoole\WeChat\Kernel\Exceptions\HttpException;
use EasySwoole\WeChat\Kernel\ServiceProviders;

class UserClient extends BaseClient
{

    /**
     * @param string $openid
     * @param string $lang
     * @return mixed
     * @throws HttpException
     */
    public function get(string $openid, string $lang = 'zh_CN')
    {
        $params = [
            'openid' => $openid,
            'lang' => $lang,
        ];

        $response = $this->getClient()
            ->setMethod('GET')
            ->send($this->buildUrl(
                '/cgi-bin/user/info',
                array_merge(['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()], $params)
            ));
        $this->checkResponse($response, $parseData);

        return $parseData;
    }

    /**
     * @param array $openids
     * @param string $lang
     * @return mixed
     * @throws HttpException
     */
    public function select(array $openids, string $lang = 'zh_CN')
    {
        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream([
                'user_list' => array_map(function ($openid) use ($lang) {
                    return [
                        'openid' => $openid,
                        'lang' => $lang,
                    ];
                }, $openids),
            ]))
            ->send($this->buildUrl(
                '/cgi-bin/user/info/batchget',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));
        $this->checkResponse($response, $parseData);

        return $parseData;
    }


    /**
     * @param string|null $nextOpenId
     * @return mixed
     * @throws HttpException
     */
    public function list(string $nextOpenId = null)
    {
        $params = ['next_openid' => $nextOpenId];

        $response = $this->getClient()
            ->setMethod('GET')
            ->send($this->buildUrl(
                '/cgi-bin/user/get',
                array_merge(['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()], $params)
            ));
        $this->checkResponse($response, $parseData);

        return $parseData;
    }


    /**
     * @param string $openid
     * @param string $remark
     * @return bool
     * @throws HttpException
     */
    public function remark(string $openid, string $remark)
    {
        $params = [
            'openid' => $openid,
            'remark' => $remark,
        ];

        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/cgi-bin/user/info/updateremark',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        return $this->checkResponse($response);
    }

    /**
     * @param string|null $beginOpenid
     * @return mixed
     * @throws HttpException
     */
    public function blacklist(string $beginOpenid = null)
    {
        $params = ['begin_openid' => $beginOpenid];

        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/cgi-bin/tags/members/getblacklist',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));
        $this->checkResponse($response, $parseData);

        return $parseData;
    }

    /**
     * @param array $openidList
     * @return bool
     * @throws HttpException
     */
    public function block(array $openidList)
    {
        $params = ['openid_list' => $openidList];

        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/cgi-bin/tags/members/batchblacklist',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        return $this->checkResponse($response);
    }


    /**
     * @param array $openidList
     * @return bool
     * @throws HttpException
     */
    public function unblock(array $openidList)
    {
        $params = ['openid_list' => $openidList];

        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/cgi-bin/tags/members/batchunblacklist',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        return $this->checkResponse($response);
    }


    /**
     * @param string $oldAppId
     * @param array $openidList
     * @return mixed
     * @throws HttpException
     */
    public function changeOpenid(string $oldAppId, array $openidList)
    {
        $params = [
            'from_appid' => $oldAppId,
            'openid_list' => $openidList,
        ];

        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/cgi-bin/changeopenid',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));
        $this->checkResponse($response, $parseData);

        return $parseData;
    }
}