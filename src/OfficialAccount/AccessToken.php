<?php
/**
 * Created by PhpStorm.
 * User: yf
 * Date: 2018/12/25
 * Time: 12:09 AM
 */

namespace EasySwoole\WeChat\OfficialAccount;

use EasySwoole\WeChat\AbstractInterface\AccessTokenInterface;
use EasySwoole\WeChat\Exception\RequestError;
use EasySwoole\WeChat\Utility\NetWork;
use EasySwoole\WeChat\Exception\OfficialAccountError;


class AccessToken extends OfficialAccountBase implements AccessTokenInterface
{
    /**
     * getToken
     *
     * @param int $refreshTimes
     * @return string|null
     * @throws \Throwable
     */
    function getToken($refreshTimes = 1):?string
    {
        try{
            $data = $this->getOfficialAccount()->getConfig()->getStorage()->get('access_token');
            if(!empty($data)){
                return $data;
            }
            return null;
        }catch (\Throwable $throwable){
            throw $throwable;
        }
    }

    /**
     * refresh
     *
     * @return string
     * @throws OfficialAccountError
     * @throws RequestError
     * @throws \EasySwoole\HttpClient\Exception\InvalidUrl
     */
    public function refresh():?string
    {
        $config = $this->getOfficialAccount()->getConfig();
        $url = ApiUrl::generateURL(ApiUrl::ACCESS_TOKEN,[
            'APPID'=>$config->getAppId(),
            'APP_SECRET'=>$config->getAppSecret()
        ]);
        $json = NetWork::getForJson($url);
        $ex = OfficialAccountError::hasException($json);
        if($ex){
            throw $ex;
        }
        $token = $json['access_token'];
        /*
         * 这里故意设置为7180
         */
        $config->getStorage()->set('access_token',$token);
        return $token;
    }
}