<?php

namespace EasySwoole\WeChat\Work\CorpGroup;

use EasySwoole\WeChat\Kernel\ServiceProviders;
use EasySwoole\WeChat\Work\BaseClient;

/**
 * Class Client
 * @package EasySwoole\WeChat\Work\CorpGroup
 * @author: XueSi
 * @email: <1592328848@qq.com>
 */
class Client extends BaseClient
{
    /**
     * 获取应用共享信息
     * doc link: https://work.weixin.qq.com/api/doc/90000/90135/93403
     *
     * @param int $agentId
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function getAppShareInfo(int $agentId)
    {
        $params = [
            'agentid' => $agentId
        ];

        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/cgi-bin/corpgroup/corp/list_app_share_info',
                [
                    'access_token' => $this->app[ServiceProviders::AccessToken]->getToken()
                ]
            ));

        $this->checkResponse($response, $jsonData);
        return $jsonData;
    }


    /**
     * 获取下级企业的access_token
     * doc link: https://work.weixin.qq.com/api/doc/90000/90135/93359
     *
     * @param string $corpId
     * @param int $agentId
     * @return bool
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function getToken(string $corpId, int $agentId)
    {
        $params = [
            'corpid' => $corpId,
            'agentid' => $agentId
        ];

        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/cgi-bin/corpgroup/corp/gettoken',
                [
                    'access_token' => $this->app[ServiceProviders::AccessToken]->getToken()
                ]
            ));

        $this->checkResponse($response, $jsonData);
        return $jsonData;
    }

    /**
     * 获取下级企业的小程序session
     * doc link: https://work.weixin.qq.com/api/doc/90000/90135/93355
     *
     * @param string $userId
     * @param string $sessionKey
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function getMiniProgramTransferSession(string $userId, string $sessionKey)
    {
        $params = [
            'userid' => $userId,
            'session_key' => $sessionKey
        ];

        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/cgi-bin/miniprogram/transfer_session',
                [
                    'access_token' => $this->app[ServiceProviders::AccessToken]->getToken()
                ]
            ));

        $this->checkResponse($response, $jsonData);
        return $jsonData;
    }
}