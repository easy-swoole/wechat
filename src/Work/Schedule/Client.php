<?php

namespace EasySwoole\WeChat\Work\Schedule;

use EasySwoole\WeChat\Kernel\ServiceProviders;
use EasySwoole\WeChat\Work\BaseClient;

/**
 * Class Client
 * @package EasySwoole\WeChat\Work\Schedule
 * @author: XueSi
 * @email: <1592328848@qq.com>
 */
class Client extends BaseClient
{
    /**
     * 创建日程
     * Add a schedule
     * doc link: https://work.weixin.qq.com/api/doc/90000/90135/93648#创建日程
     *
     * @param array $schedule
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function add(array $schedule)
    {
        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream(compact('schedule')))
            ->send($this->buildUrl(
                '/cgi-bin/oa/schedule/add',
                [
                    'access_token' => $this->app[ServiceProviders::AccessToken]->getToken()
                ]
            ));

        $this->checkResponse($response, $parseData);
        return $parseData;
    }

    /**
     * 更新日程
     * Update the schedule
     * doc link: https://work.weixin.qq.com/api/doc/90000/90135/93648#更新日程
     *
     * @param string $id
     * @param array $schedule
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function update(string $id, array $schedule)
    {
        $schedule += ['schedule_id' => $id];

        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream(compact('schedule')))
            ->send($this->buildUrl(
                '/cgi-bin/oa/schedule/update',
                [
                    'access_token' => $this->app[ServiceProviders::AccessToken]->getToken()
                ]
            ));

        return $this->checkResponse($response);
    }

    /**
     * 获取日程详情
     * Get one or more schedules
     * doc link: https://work.weixin.qq.com/api/doc/90000/90135/93648#获取日程详情
     *
     * @param $ids
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function get($ids)
    {
        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream(['schedule_id_list' => (array)$ids]))
            ->send($this->buildUrl(
                '/cgi-bin/oa/schedule/get',
                [
                    'access_token' => $this->app[ServiceProviders::AccessToken]->getToken()
                ]
            ));

        $this->checkResponse($response, $parseData);
        return $parseData;
    }

    /**
     * 获取日历下的日程列表
     * Get the list of schedules under a calendar
     * doc link: https://work.weixin.qq.com/api/doc/90000/90135/93648#获取日历下的日程列表
     *
     * @param string $calendarId
     * @param int $offset
     * @param int $limit
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function getByCalendar(string $calendarId, int $offset = 0, int $limit = 500)
    {
        $data = compact('offset', 'limit') + ['cal_id' => $calendarId];

        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($data))
            ->send($this->buildUrl(
                '/cgi-bin/oa/schedule/get_by_calendar',
                [
                    'access_token' => $this->app[ServiceProviders::AccessToken]->getToken()
                ]
            ));

        $this->checkResponse($response, $parseData);
        return $parseData;
    }

    /**
     * 取消日程
     * Delete a schedule
     * doc link: https://work.weixin.qq.com/api/doc/90000/90135/93648#取消日程
     *
     * @param string $id
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function delete(string $id)
    {
        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream(['schedule_id' => $id]))
            ->send($this->buildUrl(
                '/cgi-bin/oa/schedule/del',
                [
                    'access_token' => $this->app[ServiceProviders::AccessToken]->getToken()
                ]
            ));

        return $this->checkResponse($response, $parseData);
    }
}