<?php
namespace EasySwoole\WeChat\Work\Agent;


use EasySwoole\WeChat\Kernel\ServiceProviders;
use EasySwoole\WeChat\Work\BaseClient;

/**
 * This is WeWork Agent WorkbenchClient.
 * Class WorkBenchClient
 * @package EasySwoole\WeChat\Work\Agent
 * @author: XueSi
 * @email: <1592328848@qq.com>
 */
class WorkbenchClient extends BaseClient
{
    /**
     * 设置应用在工作台展示的模版
     * doc link: https://work.weixin.qq.com/api/doc/90000/90135/92535#设置应用在工作台展示的模版
     *
     * @param array $params
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function setWorkbenchTemplate(array $params)
    {
        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl('/cgi-bin/agent/set_workbench_template',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        return $this->checkResponse($response);
    }

    /**
     * 获取应用在工作台展示的模版
     * doc link: https://work.weixin.qq.com/api/doc/90000/90135/92535#获取应用在工作台展示的模版
     *
     * @param int $agentId
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function getWorkbenchTemplate(int $agentId)
    {
        $params = [
            'agentid' => $agentId
        ];

        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl('/cgi-bin/agent/get_workbench_template',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        $this->checkResponse($response, $jsonData);
        return $jsonData;
    }

    /**
     * 设置应用在用户工作台展示的数据
     * doc link: https://work.weixin.qq.com/api/doc/90000/90135/92535#设置应用在用户工作台展示的数据
     *
     * @param array $params
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function setWorkbenchData(array $params)
    {
        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl('/cgi-bin/agent/set_workbench_data',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        return $this->checkResponse($response);
    }
}