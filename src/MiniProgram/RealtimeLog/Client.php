<?php

namespace EasySwoole\WeChat\MiniProgram\RealtimeLog;

use EasySwoole\WeChat\Kernel\ServiceProviders;
use EasySwoole\WeChat\MiniProgram\BaseClient;

/**
 * Class Client
 * @package EasySwoole\WeChat\MiniProgram\RealtimeLog
 * @author: XueSi
 * @email: <1592328848@qq.com>
 * doc link: https://developers.weixin.qq.com/miniprogram/dev/api-backend/open-api/operation/operation.realtimelogSearch.html
 */
class Client extends BaseClient
{
    /**
     * Real time log query.
     * 实时日志查询
     *
     * @param string $date
     * @param int $beginTime
     * @param int $endTime
     * @param array $options
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function search(string $date, int $beginTime, int $endTime, array $options = [])
    {
        $query = [
            'access_token' => $this->app[ServiceProviders::AccessToken]->getToken(),
            'date' => $date,
            'begintime' => $beginTime,
            'endtime' => $endTime,
        ];

        $response = $this->getClient()
            ->setMethod('GET')
            ->send($this->buildUrl(
                '/wxaapi/userlog/userlog_search',
                $query + $options)
            );

        $this->checkResponse($response, $parseData);

        return $parseData;
    }
}