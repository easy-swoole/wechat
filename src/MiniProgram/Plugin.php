<?php
/**
 *
 * User: zs
 * Date: 2019/7/8
 * Email: <1769360227@qq.com>
 */

namespace EasySwoole\WeChat\MiniProgram;


use EasySwoole\WeChat\Exception\MiniProgramError;
use EasySwoole\WeChat\Utility\NetWork;

/**
 * 插件管理
 * Class Plugin
 * @package EasySwoole\WeChat\MiniProgram
 */
class Plugin extends MinProgramBase
{
    /**
     *向插件开发者发起使用插件的申请
     * @param string $action
     * @param string $pluginAppid
     * @param string $reason
     * @return bool
     * @throws MiniProgramError
     * @throws \EasySwoole\WeChat\Exception\RequestError
     */
    function applyPlugin(string $action = 'apply' ,string $pluginAppid ,string $reason = '')
    {
        $token = $this->getMiniProgram()->accessToken()->getToken();
        $url = ApiUrl::generateURL(ApiUrl::APPLY_PLUGIN,[
            'TOKEN' => $token
        ]);
        $data = [
            'action'        => $action,
            'plugin_appid'  => $pluginAppid,
            'reason'        => $reason
        ];
        $response =  NetWork::postForJson($url,$data);

        $ex = MiniProgramError::hasException($response);
        if ($ex) {
            throw $ex;
        }

        return true;

    }

    /**
     * 获取当前所有插件使用方（供插件开发者调用）
     * @param string $action
     * @param int $page
     * @param int $num
     * @return array
     * @throws MiniProgramError
     * @throws \EasySwoole\WeChat\Exception\RequestError
     */
    function getPluginDevApplyList(string $action = 'dev_apply_list' ,int $page = 1 ,int $num = 10)
    {
        $token = $this->getMiniProgram()->accessToken()->getToken();
        $url = ApiUrl::generateURL(ApiUrl::GET_PLUGIN_DEV_APPLY_LIST,[
            'TOKEN' => $token
        ]);
        $data = [
            'action'    => $action,
            'page'      => $page,
            'num'       => $num
        ];

        $responseArray =  NetWork::postForJson($url,$data);
        $ex = MiniProgramError::hasException($responseArray);
        if ($ex) {
            throw $ex;
        }

        return $responseArray;

    }

    /**
     * 查询已添加的插件
     * @param string $action
     * @return array
     * @throws MiniProgramError
     * @throws \EasySwoole\WeChat\Exception\RequestError
     */
    function getPluginList(string $action = 'list')
    {
        $token = $this->getMiniProgram()->accessToken()->getToken();
        $url = ApiUrl::generateURL(ApiUrl::GET_PLUGIN_LiST,[
            'TOKEN' => $token
        ]);
        $data = [
            'action'    => $action
        ];
        $responseArray =  NetWork::postForJson($url,$data);
        $ex = MiniProgramError::hasException($responseArray);
        if ($ex) {
            throw $ex;
        }

        return $responseArray;

    }

    /**
     * 修改插件使用申请的状态（供插件开发者调用）
     * @param string $action
     * @param string $appid
     * @param string $reason
     * @return bool
     * @throws MiniProgramError
     * @throws \EasySwoole\WeChat\Exception\RequestError
     */
    function setDevPluginApplyStatus(string $action ,string $appid = '' ,string $reason = '')
    {
        $token = $this->getMiniProgram()->accessToken()->getToken();
        $url = ApiUrl::generateURL(ApiUrl::SET_DEV_PLUGIN_APPLY_STATUS,[
            'TOKEN' => $token
        ]);
        $data = [
            'action'    => $action,
            'appid'     => $appid,
            'reason'    => $reason
        ];
        $response = NetWork::postForJson($url,$data);
        $ex = MiniProgramError::hasException($response);
        if ($ex) {
            throw $ex;
        }

        return true;
    }

    /**
     * 删除已添加的插件
     * @param string $action
     * @param string $pluginAppid
     * @return bool
     * @throws MiniProgramError
     * @throws \EasySwoole\WeChat\Exception\RequestError
     */
    function unbindPlugin(string $action = 'unbind' ,string $pluginAppid)
    {
        $token = $this->getMiniProgram()->accessToken()->getToken();
        $url = ApiUrl::generateURL(ApiUrl::UNBIND_PLUGIN,[
            'TOKEN' => $token
        ]);
        $data = [
            'action'        => $action,
            'plugin_appid'  => $pluginAppid
        ];
        $response = NetWork::postForJson($url,$data);
        $ex = MiniProgramError::hasException($response);
        if ($ex) {
            throw $ex;
        }

        return true;

    }
}