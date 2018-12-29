<?php
/**
 * Created by PhpStorm.
 * User: yf
 * Date: 2018/12/25
 * Time: 12:09 AM
 */

namespace EasySwoole\WeChat\OfficialAccount;


use EasySwoole\WeChat\Utility\HttpClient;
use EasySwoole\WeChat\Exception\OfficialAccountError;


class AccessToken extends ServiceBase
{
    /*
     * 默认刷新一次
     */
    function getToken($refreshTimes = 1):?string
    {
        if($refreshTimes < 0){
            return null;
        }
        $data = $this->getOfficialAccount()->getConfig()->getStorage()->get('access_token');
        if(!empty($data)){
            return $data;
        }else{
            $this->refresh();
            return $this->getToken($refreshTimes -1);
        }
    }

    function refresh():string
    {
        $config = $this->getOfficialAccount()->getConfig();
        $url = ApiUrl::generateURL(ApiUrl::ACCESS_TOKEN,[
            'APP_ID'=>$config->getAppId(),
            'APP_SECRET'=>$config->getAppSecret()
        ]);
        $json = HttpClient::getForJson($url);
        $ex = OfficialAccountError::hasException($json);
        if($ex){
            throw $ex;
        }
        $token = $json['access_token'];
        /*
         * 这里故意设置为7180
         */
        $config->getStorage()->set('access_token',$token,time()+7180);
        return $token;
    }
}