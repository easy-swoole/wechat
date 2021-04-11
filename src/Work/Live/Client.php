<?php

namespace EasySwoole\WeChat\Work\Live;

use EasySwoole\WeChat\Kernel\ServiceProviders;
use EasySwoole\WeChat\Work\BaseClient;

/**
 * Class Client
 * @package EasySwoole\WeChat\Work\Live
 * @author: XueSi
 * @email: <1592328848@qq.com>
 */
class Client extends BaseClient
{
    /**
     * 获取成员直播ID列表
     * doc link: https://work.weixin.qq.com/api/doc/90000/90135/92735
     *
     * @param string $userId
     * @param int $beginTime
     * @param int $endTime
     * @param string $nextKey
     * @param int $limit
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function getUserLivingId(string $userId, int $beginTime, int $endTime, string $nextKey = '0', int $limit = 100)
    {
        $params = [
            'userid' => $userId,
            'begin_time' => $beginTime,
            'end_time' => $endTime,
            'next_key' => $nextKey,
            'limit' => $limit
        ];

        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/cgi-bin/living/get_user_livingid',
                [
                    'access_token' => $this->app[ServiceProviders::AccessToken]->getToken()
                ]
            ));

        $this->checkResponse($response, $jsonData);
        return $jsonData;
    }

    /**
     * 获取直播详情
     * doc link: https://work.weixin.qq.com/api/doc/90000/90135/92734
     *
     * @param string $livingId
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function getLiving(string $livingId)
    {
        $query = [
            'livingid' => $livingId,
            'access_token' => $this->app[ServiceProviders::AccessToken]->getToken()
        ];

        $response = $this->getClient()
            ->setMethod('GET')
            ->send($this->buildUrl(
                '/cgi-bin/living/get_living_info',
                $query
            ));

        $this->checkResponse($response, $jsonData);
        return $jsonData;
    }

    /**
     * 获取直播观看明细
     * doc link: https://work.weixin.qq.com/api/doc/90000/90135/92736
     *
     * @param string $livingId
     * @param string $nextKey
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function getWatchStat(string $livingId, string $nextKey = '0')
    {
        $params = [
            'livingid' => $livingId,
            'next_key' => $nextKey,
        ];

        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/cgi-bin/living/get_watch_stat',
                [
                    'access_token' => $this->app[ServiceProviders::AccessToken]->getToken()
                ]
            ));

        $this->checkResponse($response, $jsonData);
        return $jsonData;
    }
}