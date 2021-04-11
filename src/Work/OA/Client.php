<?php

namespace EasySwoole\WeChat\Work\OA;

use EasySwoole\WeChat\Kernel\ServiceProviders;
use EasySwoole\WeChat\Work\BaseClient;

/**
 * Class Client
 * @package EasySwoole\WeChat\Work\OA
 * @author: XueSi
 * @email: <1592328848@qq.com>
 */
class Client extends BaseClient
{
    /**
     * 获取打卡记录数据
     * Get the checkin data
     * doc link: https://work.weixin.qq.com/api/doc/90000/90135/90262
     *
     * @param int $startTime
     * @param int $endTime
     * @param array $userList
     * @param int $type
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function checkinRecords(int $startTime, int $endTime, array $userList, int $type = 3)
    {
        $params = [
            'opencheckindatatype' => $type,
            'starttime' => $startTime,
            'endtime' => $endTime,
            'useridlist' => $userList,
        ];

        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/cgi-bin/checkin/getcheckindata',
                [
                    'access_token' => $this->app[ServiceProviders::AccessToken]->getToken()
                ]
            ));

        $this->checkResponse($response, $parseData);
        return $parseData;
    }

    /**
     * 获取员工打卡规则
     * Get the checkin rules
     * doc link: https://work.weixin.qq.com/api/doc/90000/90135/90263
     *
     * @param int $datetime
     * @param array $userList
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function checkinRules(int $datetime, array $userList)
    {
        $params = [
            'datetime' => $datetime,
            'useridlist' => $userList,
        ];

        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/cgi-bin/checkin/getcheckinoption',
                [
                    'access_token' => $this->app[ServiceProviders::AccessToken]->getToken()
                ]
            ));

        $this->checkResponse($response, $parseData);
        return $parseData;
    }

    /**
     * 获取审批模板详情
     * Get approval template details
     * doc link: https://work.weixin.qq.com/api/doc/90000/90135/91982
     *
     * @param string $templateId
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function approvalTemplate(string $templateId)
    {
        $params = [
            'template_id' => $templateId,
        ];

        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/cgi-bin/oa/gettemplatedetail',
                [
                    'access_token' => $this->app[ServiceProviders::AccessToken]->getToken()
                ]
            ));

        $this->checkResponse($response, $parseData);
        return $parseData;
    }

    /**
     * 提交审批申请
     * Submit an application for approval
     * doc link: https://work.weixin.qq.com/api/doc/90000/90135/91853
     *
     * @param array $data
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function createApproval(array $data)
    {
        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($data))
            ->send($this->buildUrl(
                '/cgi-bin/oa/applyevent',
                [
                    'access_token' => $this->app[ServiceProviders::AccessToken]->getToken()
                ]
            ));

        $this->checkResponse($response, $parseData);
        return $parseData;
    }

    /**
     * 批量获取审批单号
     * Get Approval number
     * doc link: https://work.weixin.qq.com/api/doc/90000/90135/91816
     *
     * @param int $startTime
     * @param int $endTime
     * @param int $nextCursor
     * @param int $size
     * @param array $filters
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function approvalNumbers(int $startTime, int $endTime, int $nextCursor = 0, int $size = 100, array $filters = [])
    {
        $params = [
            'starttime' => $startTime,
            'endtime' => $endTime,
            'cursor' => $nextCursor,
            'size' => $size > 100 ? 100 : $size,
            'filters' => $filters,
        ];

        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/cgi-bin/oa/getapprovalinfo',
                [
                    'access_token' => $this->app[ServiceProviders::AccessToken]->getToken()
                ]
            ));

        $this->checkResponse($response, $parseData);
        return $parseData;
    }

    /**
     * 获取审批申请详情
     * Get approval detail
     * doc link: https://work.weixin.qq.com/api/doc/90000/90135/91983
     *
     * @param int $number
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function approvalDetail(int $number)
    {
        $params = [
            'sp_no' => $number,
        ];

        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/cgi-bin/oa/getapprovaldetail',
                [
                    'access_token' => $this->app[ServiceProviders::AccessToken]->getToken()
                ]
            ));

        $this->checkResponse($response, $parseData);
        return $parseData;
    }

    /**
     * 获取审批数据（旧）
     * 【提示：推荐使用新接口“批量获取审批单号”及“获取审批申请详情”，此接口后续将不再维护、逐步下线。】
     * Get Approval Data
     * doc link: https://work.weixin.qq.com/api/doc/90000/90135/91530
     *
     * @param int $startTime
     * @param int $endTime
     * @param int|null $nextNumber
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function approvalRecords(int $startTime, int $endTime, int $nextNumber = null)
    {
        $params = [
            'starttime' => $startTime,
            'endtime' => $endTime,
            'next_spnum' => $nextNumber,
        ];

        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/cgi-bin/corp/getapprovaldata',
                [
                    'access_token' => $this->app[ServiceProviders::AccessToken]->getToken()
                ]
            ));

        $this->checkResponse($response, $parseData);
        return $parseData;
    }

    /**
     * 获取公费电话拨打记录
     * doc link: https://work.weixin.qq.com/api/doc/90000/90135/93662
     *
     * @param int $startTime
     * @param int $endTime
     * @param int $offset
     * @param int $limit
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function dialRecords(int $startTime, int $endTime, int $offset = 0, $limit = 100)
    {
        $params = [
            'start_time' => $startTime,
            'end_time' => $endTime,
            'offset' => $offset,
            'limit' => $limit
        ];

        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/cgi-bin/dial/get_dial_record',
                [
                    'access_token' => $this->app[ServiceProviders::AccessToken]->getToken()
                ]
            ));

        $this->checkResponse($response, $parseData);
        return $parseData;
    }
}