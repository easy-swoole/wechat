<?php
/**
 * Created by PhpStorm.
 * User: 67066
 * Date: 2020/11/29
 * Time: 18:00
 */

namespace EasySwoole\WeChat\OfficialAccount\DataCube;

use EasySwoole\WeChat\Kernel\BaseClient;
use EasySwoole\WeChat\Kernel\Exceptions\HttpException;
use EasySwoole\WeChat\Kernel\ServiceProviders;

class Client extends BaseClient
{
    /**
     * 获取用户增减数据.
     * doc link: https://developers.weixin.qq.com/doc/offiaccount/Analytics/User_Analysis_Data_Interface.html
     *
     * @param string $from 获取数据的起始日期
     * @param string $to 获取数据的结束日期
     * @return array
     * @throws HttpException
     */
    public function userSummary(string $from, string $to)
    {
        $data = [
            'begin_date' => $from,
            'end_date' => $to,
        ];
        return $this->post('/datacube/getusersummary', $data);
    }

    /**
     * 获取累计用户数据.
     * doc link: https://developers.weixin.qq.com/doc/offiaccount/Analytics/User_Analysis_Data_Interface.html
     *
     * @param string $from 获取数据的起始日期
     * @param string $to 获取数据的结束日期
     * @return array
     * @throws HttpException
     */
    public function userCumulate(string $from, string $to)
    {
        $data = [
            'begin_date' => $from,
            'end_date' => $to,
        ];
        return $this->post('/datacube/getusercumulate', $data);
    }

    /**
     * 获取图文群发每日数据.
     *
     * @param string $from 获取数据的起始日期
     * @param string $to 获取数据的结束日期
     * @return array
     * @throws HttpException
     */
    public function articleSummary(string $from, string $to)
    {
        $data = [
            'begin_date' => $from,
            'end_date' => $to,
        ];
        return $this->post('/datacube/getarticlesummary', $data);
    }

    /**
     * 获取图文群发总数据.
     *
     * @param string $from 获取数据的起始日期
     * @param string $to 获取数据的结束日期
     * @return array
     * @throws HttpException
     */
    public function articleTotal(string $from, string $to)
    {
        $data = [
            'begin_date' => $from,
            'end_date' => $to,
        ];
        return $this->post('/datacube/getarticletotal', $data);
    }

    /**
     * 获取图文统计数据.
     *
     * @param string $from 获取数据的起始日期
     * @param string $to 获取数据的结束日期
     * @return array
     * @throws HttpException
     */
    public function userReadSummary(string $from, string $to)
    {
        $data = [
            'begin_date' => $from,
            'end_date' => $to,
        ];
        return $this->post('/datacube/getuserread', $data);
    }

    /**
     * 获取图文统计分时数据.
     *
     * @param string $from 获取数据的起始日期
     * @param string $to 获取数据的结束日期
     * @return array
     * @throws HttpException
     */
    public function userReadHourly(string $from, string $to)
    {
        $data = [
            'begin_date' => $from,
            'end_date' => $to,
        ];
        return $this->post('/datacube/getuserreadhour', $data);
    }

    /**
     * 获取图文分享转发数据.
     *
     * @param string $from 获取数据的起始日期
     * @param string $to 获取数据的结束日期
     * @return array
     * @throws HttpException
     */
    public function userShareSummary(string $from, string $to)
    {
        $data = [
            'begin_date' => $from,
            'end_date' => $to,
        ];
        return $this->post('/datacube/getusershare', $data);
    }

    /**
     * 获取图文分享转发分时数据.
     *
     * @param string $from 获取数据的起始日期
     * @param string $to 获取数据的结束日期
     * @return array
     * @throws HttpException
     */
    public function userShareHourly(string $from, string $to)
    {
        $data = [
            'begin_date' => $from,
            'end_date' => $to,
        ];
        return $this->post('/datacube/getusersharehour', $data);
    }

    /**
     * 获取消息发送概况数据.
     *
     * @param string $from 获取数据的起始日期
     * @param string $to 获取数据的结束日期
     * @return array
     * @throws HttpException
     */
    public function upstreamMessageSummary(string $from, string $to)
    {
        $data = [
            'begin_date' => $from,
            'end_date' => $to,
        ];
        return $this->post('/datacube/getupstreammsg', $data);

    }


    /**
     * 获取消息分送分时数据.
     *
     * @param string $from 获取数据的起始日期
     * @param string $to 获取数据的结束日期
     * @return array
     * @throws HttpException
     */
    public function upstreamMessageHourly(string $from, string $to)
    {
        $data = [
            'begin_date' => $from,
            'end_date' => $to,
        ];
        return $this->post('/datacube/getupstreammsghour', $data);
    }

    /**
     * 获取消息发送周数据.
     *
     * @param string $from 获取数据的起始日期
     * @param string $to 获取数据的结束日期
     * @return array
     * @throws HttpException
     */
    public function upstreamMessageWeekly(string $from, string $to)
    {
        $data = [
            'begin_date' => $from,
            'end_date' => $to,
        ];
        return $this->post('/datacube/getupstreammsgweek', $data);
    }

    /**
     * 获取消息发送月数据.
     *
     * @param string $from 获取数据的起始日期
     * @param string $to 获取数据的结束日期
     * @return array
     * @throws HttpException
     */
    public function upstreamMessageMonthly(string $from, string $to)
    {
        $data = [
            'begin_date' => $from,
            'end_date' => $to,
        ];
        return $this->post('/datacube/getupstreammsgmonth', $data);
    }

    /**
     * 获取消息发送分布数据.
     *
     * @param string $from 获取数据的起始日期
     * @param string $to 获取数据的结束日期
     * @return array
     * @throws HttpException
     */
    public function upstreamMessageDistSummary(string $from, string $to)
    {
        $data = [
            'begin_date' => $from,
            'end_date' => $to,
        ];
        return $this->post('/datacube/getupstreammsgdist', $data);
    }

    /**
     * 获取消息发送分布周数据.
     *
     * @param string $from 获取数据的起始日期
     * @param string $to 获取数据的结束日期
     * @return array
     * @throws HttpException
     */
    public function upstreamMessageDistWeekly(string $from, string $to)
    {
        $data = [
            'begin_date' => $from,
            'end_date' => $to,
        ];
        return $this->post('/datacube/getupstreammsgdistweek', $data);
    }

    /**
     * 获取消息发送分布月数据.
     *
     * @param string $from 获取数据的起始日期
     * @param string $to 获取数据的结束日期
     * @return array
     * @throws HttpException
     */
    public function upstreamMessageDistMonthly(string $from, string $to)
    {
        $data = [
            'begin_date' => $from,
            'end_date' => $to,
        ];
        return $this->post('/datacube/getupstreammsgdistmonth', $data);
    }

    /**
     * 获取接口分析数据.
     *
     * @param string $from 获取数据的起始日期
     * @param string $to 获取数据的结束日期
     * @return array
     * @throws HttpException
     */
    public function interfaceSummary(string $from, string $to)
    {
        $data = [
            'begin_date' => $from,
            'end_date' => $to,
        ];
        return $this->post('/datacube/getinterfacesummary', $data);
    }

    /**
     * 获取接口分析分时数据.
     *
     * @param string $from 获取数据的起始日期
     * @param string $to 获取数据的结束日期
     * @return array
     * @throws HttpException
     */
    public function interfaceSummaryHourly(string $from, string $to)
    {
        $data = [
            'begin_date' => $from,
            'end_date' => $to,
        ];
        return $this->post('/datacube/getinterfacesummaryhour', $data);
    }

    /**
     * 拉取卡券概况数据接口.
     *
     * @param string $from 查询数据的起始时间
     * @param string $to 查询数据的截至时间
     * @param int $condSource 卡券来源，0为公众平台创建的卡券数据 、1是API创建的卡券数据
     * @return array
     * @throws HttpException
     */
    public function cardSummary(string $from, string $to, int $condSource = 0)
    {
        $data = [
            'begin_date' => $from,
            'end_date' => $to,
            'cond_source' => $condSource
        ];
        return $this->post('/datacube/getcardbizuininfo', $data);
    }

    /**
     * 获取免费券数据接口.
     *
     * @param string $from 查询数据的起始时间
     * @param string $to 查询数据的截至时间
     * @param int $condSource 卡券来源，0为公众平台创建的卡券数据 、1是API创建的卡券数据
     * @param string $cardId 卡券ID。填写后，指定拉出该卡券的相关数据。
     * @return array
     * @throws HttpException
     *
     */
    public function freeCardSummary(string $from, string $to, int $condSource = 0, string $cardId = '')
    {
        $data = [
            'begin_date' => $from,
            'end_date' => $to,
            'cond_source' => $condSource
        ];
        if ($cardId) {
            $data['card_id'] = $cardId;
        }
        return $this->post('/datacube/getcardcardinfo', $data);
    }

    /**
     * 拉取会员卡数据接口.
     *
     * @param string $from 查询数据的起始时间
     * @param string $to 查询数据的截至时间
     * @param int $condSource 卡券来源，0为公众平台创建的卡券数据 、1是API创建的卡券数据
     * @return array
     * @throws HttpException
     */
    public function memberCardSummary(string $from, string $to, int $condSource = 0)
    {
        $data = [
            'begin_date' => $from,
            'end_date' => $to,
            'cond_source' => $condSource
        ];
        return $this->post('/datacube/getcardmembercardinfo', $data);
    }

    /**
     * 拉取单张会员卡数据接口.
     *
     * @param string $from 查询数据的起始时间
     * @param string $to 查询数据的截至时间
     * @param string $cardId 卡券id
     * @return array
     * @throws HttpException
     */
    public function memberCardSummaryById(string $from, string $to, string $cardId)
    {
        $data = [
            'begin_date' => $from,
            'end_date' => $to,
            'card_id' => $cardId
        ];
        return $this->post('/datacube/getcardmembercarddetail', $data);
    }

    /**
     * 请求封装
     *
     * @param string $path 请求的路径
     * @param array $data 发送的查询数据
     * @return array
     * @throws HttpException
     */
    protected function post($path, $data)
    {
        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody(
                $this->jsonDataToStream($data)
            )
            ->send($this->buildUrl(
                $path,
                [
                    'access_token' => $this->getAccessToken()
                ]
            ));
        $this->checkResponse($response, $jsonData);

        return $jsonData;
    }

    protected function getAccessToken()
    {
        return $this->app[ServiceProviders::AccessToken]->getToken();
    }
}