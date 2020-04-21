<?php
/**
 * Created by PhpStorm.
 * User: yf
 * Date: 2018/12/25
 * Time: 12:37 AM
 */

namespace EasySwoole\WeChat\OfficialAccount;


use EasySwoole\WeChat\Exception\OfficialAccountError;
use EasySwoole\WeChat\Utility\NetWork;

class Menu extends OfficialAccountBase
{
    /**
     * @param array      $buttons       自定义菜单Array
     * @param array|null $matchRule     个性化菜单Array 默认无效
     * @return bool|int  是否创建成功 个性化菜单则返回 menuid
     * @throws OfficialAccountError
     * @throws \EasySwoole\WeChat\Exception\RequestError
     */
    public function create(array $buttons, array $matchRule = null)
    {
        $postData = Array('button' => $buttons);
        if (!is_null($matchRule)) {
            $postData['matchrule'] = $matchRule;
            $url = ApiUrl::generateURL(ApiUrl::MENU_ADD_CONDITIONAL, [
                'ACCESS_TOKEN'=> $this->getOfficialAccount()->accessToken()->getToken()
            ]);
        }else{
            $url = ApiUrl::generateURL(ApiUrl::MENU_CREATE, [
                'ACCESS_TOKEN'=> $this->getOfficialAccount()->accessToken()->getToken()
            ]);
        }

        $json = NetWork::postJsonForJson($url, $postData);
        $ex = OfficialAccountError::hasException($json);
        if($ex){
            throw $ex;
        }

        return $json['menuid'] ?? true;
    }

    /**
     * match
     *
     * @param string $userId    openid OR 微信账号
     * @return array    该用户的菜单配置
     * @throws OfficialAccountError
     * @throws \EasySwoole\WeChat\Exception\RequestError
     */
    public function match(string $userId)
    {
        $url = ApiUrl::generateURL(ApiUrl::MENU_MATCH_CONDITIONAL, [
            'ACCESS_TOKEN'=> $this->getOfficialAccount()->accessToken()->getToken()
        ]);

        $json = NetWork::postJsonForJson($url, Array('user_id' => $userId));
        $ex = OfficialAccountError::hasException($json);
        if($ex){
            throw $ex;
        }
        return $json;
    }

    /**
     * @return array    菜单配置
     * @throws OfficialAccountError
     * @throws \EasySwoole\WeChat\Exception\RequestError
     */
    public function query()
    {
        $url = ApiUrl::generateURL(ApiUrl::MENU_GET, [
            'ACCESS_TOKEN'=> $this->getOfficialAccount()->accessToken()->getToken()
        ]);

        $json = NetWork::getForJson($url);
        $ex = OfficialAccountError::hasException($json);
        if($ex){
            throw $ex;
        }
        return $json;
    }

    /**
     * @return array    菜单配置
     * @throws OfficialAccountError
     * @throws \EasySwoole\WeChat\Exception\RequestError
     */
    public function queryConfig()
    {
        $url = ApiUrl::generateURL(ApiUrl::GET_CURRENT_SELFMENU_INFO, [
            'ACCESS_TOKEN'=> $this->getOfficialAccount()->accessToken()->getToken()
        ]);

        $json = NetWork::getForJson($url);
        $ex = OfficialAccountError::hasException($json);
        if($ex){
            throw $ex;
        }
        return $json;
    }


    /**
     * delete
     *
     * @param int|null $menuId      个性化菜单ID (可以通过查询接口获取)　NULL时为删除全部
     * @return bool    是否成功删除
     * @throws OfficialAccountError
     * @throws \EasySwoole\WeChat\Exception\RequestError
     */
    public function delete(int $menuId = null)
    {
        if (is_null($menuId)) {
            $url = ApiUrl::generateURL(ApiUrl::MENU_DELETE, [
                'ACCESS_TOKEN'=> $this->getOfficialAccount()->accessToken()->getToken()
            ]);
            $json = NetWork::getForJson($url);
        }else{
            $url = ApiUrl::generateURL(ApiUrl::MENU_DELETE_CONDITIONAL, [
                'ACCESS_TOKEN'=> $this->getOfficialAccount()->accessToken()->getToken()
            ]);
            $json = NetWork::postJsonForJson($url, Array('menuid' => $menuId));
        }

        $ex = OfficialAccountError::hasException($json);
        if($ex){
            throw $ex;
        }

        return true;
    }
}