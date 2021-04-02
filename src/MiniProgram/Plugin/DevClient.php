<?php

namespace EasySwoole\WeChat\MiniProgram\Plugin;

use EasySwoole\WeChat\MiniProgram\BaseClient;
use EasySwoole\WeChat\Kernel\ServiceProviders;

/**
 * Class DevClient.
 * @authar master@kyour.cn
 * @package EasySwoole\WeChat\MiniProgram\Live
 */
class DevClient extends BaseClient
{
    /**
     * Get users.
     *
     * @param int $page
     * @param int $size
     *
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function getUsers(int $page = 1, int $size = 10)
    {
        return $this->queryPost('wxa/devplugin', [
            'action' => 'dev_apply_list',
            'page' => $page,
            'num' => $size,
        ]);
    }

    /**
     * Agree to use plugin.
     *
     * @param string $appId
     *
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function agree(string $appId)
    {
        return $this->queryPost('wxa/devplugin', [
            'action' => 'dev_agree',
            'appid' => $appId,
        ]);
    }

    /**
     * Refuse to use plugin.
     *
     * @param string $reason
     *
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function refuse(string $reason)
    {
        return $this->queryPost('wxa/devplugin', [
            'action' => 'dev_refuse',
            'reason' => $reason,
        ]);
    }

    /**
     * Delete rejected applications.
     *
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function delete()
    {
        return $this->queryPost('wxa/devplugin', [
            'action' => 'dev_delete',
        ]);
    }

    public function queryPost($api, $param)
    {
        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($param))
            ->send($this->buildUrl(
                '/'.$api,
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()])
            );

        $this->checkResponse($response, $parseData);

        return $parseData;
    }
}
