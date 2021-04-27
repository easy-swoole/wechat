<?php

namespace EasySwoole\WeChat\Work\ExternalContact;

use EasySwoole\WeChat\Kernel\ServiceProviders;
use EasySwoole\WeChat\Work\BaseClient;

/**
 * Class StatisticsClient
 * @package EasySwoole\WeChat\Work\ExternalContact
 * @author: XueSi
 * @email: <1592328848@qq.com>
 */
class StatisticsClient extends BaseClient
{
    /**
     * 获取「联系客户统计」数据
     * doc link: https://work.weixin.qq.com/api/doc/90000/90135/92132
     *
     * @param array $userIds
     * @param string $from
     * @param string $to
     * @param array $partyIds
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function userBehavior(array $userIds, string $from, string $to, array $partyIds = [])
    {
        $params = [
            'userid' => $userIds,
            'partyid' => $partyIds,
            'start_time' => $from,
            'end_time' => $to,
        ];

        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/cgi-bin/externalcontact/get_user_behavior_data',
                [
                    'access_token' => $this->app[ServiceProviders::AccessToken]->getToken()
                ]
            ));

        $this->checkResponse($response, $jsonData);
        return $jsonData;
    }

    /**
     * 获取「群聊数据统计」数据. (按群主聚合的方式)
     * doc link: https://work.weixin.qq.com/api/doc/90000/90135/92133#按群主聚合的方式
     *
     * @param array $params
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function groupChatStatistic(array $params)
    {
        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/cgi-bin/externalcontact/groupchat/statistic',
                [
                    'access_token' => $this->app[ServiceProviders::AccessToken]->getToken()
                ]
            ));

        $this->checkResponse($response, $jsonData);
        return $jsonData;
    }

    /**
     * 获取「群聊数据统计」数据. (按自然日聚合的方式)
     * doc link: https://work.weixin.qq.com/api/doc/90000/90135/92133#按自然日聚合的方式
     *
     * @param int $dayBeginTime
     * @param int $dayEndTime
     * @param array $userIds
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function groupChatStatisticGroupByDay(int $dayBeginTime, int $dayEndTime, array $userIds = [])
    {
        $params = [
            'day_begin_time' => $dayBeginTime,
            'day_end_time' => $dayEndTime,
            'owner_filter' => [
                'userid_list' => $userIds
            ]
        ];

        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/cgi-bin/externalcontact/groupchat/statistic_group_by_day',
                [
                    'access_token' => $this->app[ServiceProviders::AccessToken]->getToken()
                ]
            ));

        $this->checkResponse($response, $jsonData);
        return $jsonData;
    }

}
