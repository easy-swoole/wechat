<?php

namespace EasySwoole\WeChat\MiniProgram\Plugin;

use EasySwoole\WeChat\MiniProgram\BaseClient;
use EasySwoole\WeChat\Kernel\ServiceProviders;

/**
 * Class Client.
 * @author master@kyour.cn
 * @package EasySwoole\WeChat\MiniProgram\Live
 * doc link: https://developers.weixin.qq.com/miniprogram/dev/api-backend/open-api/plugin-management/pluginManager.applyPlugin.html
 */
class Client extends BaseClient
{
    /**
     * pluginManager.applyPlugin
     * 向插件开发者发起使用插件的申请
     *
     * @param string $appId
     *
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function apply($appId)
    {
        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream([
                'action' => 'apply',
                'plugin_appid' => $appId,
            ]))
            ->send($this->buildUrl(
                '/wxa/plugin',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()])
            );

        return $this->checkResponse($response, $parseData);
    }

    /**
     * pluginManager.getPluginList
     * 查询已添加的插件
     *
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function list()
    {
        return $this->queryPost('/wxa/plugin', [
            'action' => 'list',
        ]);
    }

    /**
     * pluginManager.unbindPlugin
     * 删除已添加的插件
     *
     * @param string $appId
     *
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function unbind($appId)
    {
        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream([
                'action' => 'unbind',
                'plugin_appid' => $appId,
            ]))
            ->send($this->buildUrl(
                '/wxa/plugin',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()])
            );

        return $this->checkResponse($response, $parseData);
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

        $this->checkResponse($response, $parseData);

        return $parseData;
    }
}
