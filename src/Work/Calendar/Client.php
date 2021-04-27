<?php

namespace EasySwoole\WeChat\Work\Calendar;

use EasySwoole\WeChat\Kernel\ServiceProviders;
use EasySwoole\WeChat\Work\BaseClient;

/**
 * Class Client
 * @package EasySwoole\WeChat\Work\Calendar
 * @author: XueSi
 * @email: <1592328848@qq.com>
 */
class Client extends BaseClient
{
    /**
     * Add a calendar.
     * 创建日历
     * doc link: https://work.weixin.qq.com/api/doc/90000/90135/93647#创建日历
     *
     * @param array $calendar
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function add(array $calendar)
    {
        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream(compact('calendar')))
            ->send($this->buildUrl(
                '/cgi-bin/oa/calendar/add',
                [
                    'access_token' => $this->app[ServiceProviders::AccessToken]->getToken()
                ]
            ));

        $this->checkResponse($response, $jsonData);
        return $jsonData;
    }


    /**
     * Update the calendar.
     * 更新日历
     * doc link: https://work.weixin.qq.com/api/doc/90000/90135/93647#更新日历
     *
     * @param string $id
     * @param array $calendar
     * @return bool
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function update(string $id, array $calendar)
    {
        $calendar += ['cal_id' => $id];

        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream(compact('calendar')))
            ->send($this->buildUrl(
                '/cgi-bin/oa/calendar/update',
                [
                    'access_token' => $this->app[ServiceProviders::AccessToken]->getToken()
                ]
            ));

        return $this->checkResponse($response);
    }


    /**
     * Get one or more calendars.
     * 获取日历详情
     * doc link: https://work.weixin.qq.com/api/doc/90000/90135/93647#获取日历详情
     *
     * @param $ids
     * @return bool
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function get($ids)
    {
        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream(['cal_id_list' => (array)$ids]))
            ->send($this->buildUrl(
                '/cgi-bin/oa/calendar/get',
                [
                    'access_token' => $this->app[ServiceProviders::AccessToken]->getToken()
                ]
            ));

        $this->checkResponse($response, $jsonData);
        return $jsonData;
    }


    /**
     * Delete a calendar.
     * 删除日历
     * doc link: https://work.weixin.qq.com/api/doc/90000/90135/93647#删除日历
     *
     * @param string $id
     * @return bool
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function delete(string $id)
    {
        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream(['cal_id' => $id]))
            ->send($this->buildUrl(
                '/cgi-bin/oa/calendar/del',
                [
                    'access_token' => $this->app[ServiceProviders::AccessToken]->getToken()
                ]
            ));

        return $this->checkResponse($response);
    }
}