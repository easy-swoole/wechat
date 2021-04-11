<?php

namespace EasySwoole\WeChat\Work\User;

use EasySwoole\WeChat\Kernel\ServiceProviders;
use EasySwoole\WeChat\Work\BaseClient;

class BatchJobsClient extends BaseClient
{
    /**
     * 增量更新成员
     * doc link: https://open.work.weixin.qq.com/api/doc/90000/90135/90980
     *
     * @param array $params
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function batchUpdateUsers(array $params)
    {
        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/cgi-bin/batch/syncuser',
                [
                    'access_token' => $this->app[ServiceProviders::AccessToken]->getToken()
                ]
            ));

        $this->checkResponse($response, $parseData);
        return $parseData;
    }

    /**
     * .
     *
     * @see https://open.work.weixin.qq.com/api/doc/90000/90135/90981
     *
     * @param array $params
     *
     * @return \Psr\Http\Message\ResponseInterface|\EasyWeChat\Kernel\Support\Collection|array|object|string
     *
     * @throws \EasyWeChat\Kernel\Exceptions\InvalidConfigException
     * @throws \GuzzleHttp\Exception\GuzzleException
     */
    /**
     * 全量覆盖成员
     * doc link: https://open.work.weixin.qq.com/api/doc/90000/90135/90981
     *
     * @param array $params
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function batchReplaceUsers(array $params)
    {
        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/cgi-bin/batch/replaceuser',
                [
                    'access_token' => $this->app[ServiceProviders::AccessToken]->getToken()
                ]
            ));

        $this->checkResponse($response, $parseData);
        return $parseData;
    }

    /**
     * 全量覆盖部门
     * doc link: https://open.work.weixin.qq.com/api/doc/90000/90135/90982
     *
     * @param array $params
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function batchReplaceDepartments(array $params)
    {
        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/cgi-bin/batch/replaceparty',
                [
                    'access_token' => $this->app[ServiceProviders::AccessToken]->getToken()
                ]
            ));

        $this->checkResponse($response, $parseData);
        return $parseData;
    }

    /**
     * 获取异步任务结果
     * doc link: https://open.work.weixin.qq.com/api/doc/90000/90135/90983
     *
     * @param string $jobId
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function getJobStatus(string $jobId)
    {
        $query = [
            'jobid' => $jobId,
            'access_token' => $this->app[ServiceProviders::AccessToken]->getToken()
        ];

        $response = $this->getClient()
            ->setMethod('GET')
            ->send($this->buildUrl(
                '/cgi-bin/batch/getresult',
                $query
            ));

        $this->checkResponse($response, $parseData);
        return $parseData;
    }
}