<?php

namespace EasySwoole\WeChat\MiniProgram\Plugin;

use EasySwoole\WeChat\MiniProgram\BaseClient;
use EasySwoole\WeChat\Kernel\ServiceProviders;

/**
 * Class DevClient.
 * @author master@kyour.cn
 * @package EasySwoole\WeChat\MiniProgram\Plugin
 * doc link: https://developers.weixin.qq.com/miniprogram/dev/api-backend/open-api/plugin-management/pluginManager.getPluginDevApplyList.html
 */
class DevClient extends BaseClient
{
    /**
     * Get users.
     * pluginManager.getPluginDevApplyList
     * 获取当前所有插件使用方（供插件开发者调用）
     * doc link: https://developers.weixin.qq.com/miniprogram/dev/api-backend/open-api/plugin-management/pluginManager.getPluginDevApplyList.html
     *
     * @param int $page
     * @param int $size
     *
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function getUsers(int $page = 1, int $size = 10)
    {
        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream([
                'action' => 'dev_apply_list',
                'page' => $page,
                'num' => $size,
            ]))
            ->send($this->buildUrl(
                '/wxa/devplugin',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()])
            );

        $this->checkResponse($response, $parseData);

        return $parseData;
    }

    /**
     * Agree to use plugin.
     * (同意申请) 修改插件使用申请的状态（供插件开发者调用）
     * doc link: https://developers.weixin.qq.com/miniprogram/dev/api-backend/open-api/plugin-management/pluginManager.setDevPluginApplyStatus.html
     *
     * @param string $appId
     *
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function agree(string $appId)
    {
        return $this->queryPost('/wxa/devplugin', [
            'action' => 'dev_agree',
            'appid' => $appId,
        ]);
    }

    /**
     * Refuse to use plugin.
     * (拒绝申请) 修改插件使用申请的状态（供插件开发者调用）
     * doc link: https://developers.weixin.qq.com/miniprogram/dev/api-backend/open-api/plugin-management/pluginManager.setDevPluginApplyStatus.html
     *
     * @param string $reason
     *
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function refuse(string $reason)
    {
        return $this->queryPost('/wxa/devplugin', [
            'action' => 'dev_refuse',
            'reason' => $reason,
        ]);
    }

    /**
     * Delete rejected applications.
     * (删除已拒绝的申请者) 修改插件使用申请的状态（供插件开发者调用）
     * doc link: https://developers.weixin.qq.com/miniprogram/dev/api-backend/open-api/plugin-management/pluginManager.setDevPluginApplyStatus.html
     *
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function delete()
    {
        return $this->queryPost('/wxa/devplugin', [
            'action' => 'dev_delete',
        ]);
    }

    private function queryPost(string $api, array $param)
    {
        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($param))
            ->send($this->buildUrl(
                $api,
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()])
            );

        return $this->checkResponse($response);
    }
}
