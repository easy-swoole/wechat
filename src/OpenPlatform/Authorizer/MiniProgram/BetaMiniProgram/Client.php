<?php
/**
 * User: XueSi
 * Date: 2021/9/14 16:44
 * Author: XueSi <1592328848@qq.com>
 */

namespace EasySwoole\WeChat\OpenPlatform\Authorizer\MiniProgram\BetaMiniProgram;

use EasySwoole\WeChat\Kernel\Exceptions\HttpException;
use EasySwoole\WeChat\Kernel\ServiceProviders;
use EasySwoole\WeChat\OpenPlatform\BaseClient;

class Client extends BaseClient
{
    /**
     * 试用小程序快速认证
     * 该接口用于通过企业法人人脸识别的方式快速将试用小程序进行认证
     * doc link: https://developers.weixin.qq.com/doc/oplatform/Third-party_Platforms/2.0/api/beta_Mini_Programs/fastverify.html
     * @param array $verifyInfo
     * @return mixed
     * @throws HttpException
     */
    public function verifyBetaWeapp(array $verifyInfo)
    {
        $response = $this->getClient()
            ->setMethod("POST")
            ->setBody($this->jsonDataToStream(['verify_info' => $verifyInfo]))
            ->send($this->buildUrl(
                "/wxa/verifybetaweapp",
                [
                    'access_token' => $this->app[ServiceProviders::AccessToken]->getToken()
                ]
            ));

        return $this->checkResponse($response);
    }

    /**
     * 修改试用小程序名称
     * 该接口用于修改试用小程序名称
     * doc link: https://developers.weixin.qq.com/doc/oplatform/Third-party_Platforms/2.0/api/beta_Mini_Programs/fastmodify.html
     * @param string $name
     * @return mixed
     * @throws HttpException
     */
    public function setBetaWeappNickname(string $name)
    {
        $response = $this->getClient()
            ->setMethod("POST")
            ->setBody($this->jsonDataToStream(['name' => $name]))
            ->send($this->buildUrl(
                "/wxa/setbetaweappnickname",
                [
                    'access_token' => $this->app[ServiceProviders::AccessToken]->getToken()
                ]
            ));

        return $this->checkResponse($response);
    }

    /**
     * 获取公众号管理员授权
     * doc link: https://developers.weixin.qq.com/doc/oplatform/Third-party_Platforms/2.0/api/verify_beta_Mini_Programs/getmpadminauth.html
     * @param string $mpAppId
     * @param int $sameAdmin
     * @return mixed
     * @throws HttpException
     */
    public function getMpAdminAuth(string $mpAppId, int $sameAdmin)
    {
        $response = $this->getClient()
            ->setMethod("POST")
            ->setBody($this->jsonDataToStream([
                'mp_appid' => $mpAppId,
                'same_admin' => $sameAdmin
            ]))
            ->send($this->buildUrl(
                "/wxa/getmpadminauth",
                [
                    'access_token' => $this->app[ServiceProviders::AccessToken]->getToken()
                ]
            ));

        $this->checkResponse($response, $parseData);
        return $parseData;
    }

    /**
     * 复用公众号主体认证小程序
     * doc link: https://developers.weixin.qq.com/doc/oplatform/Third-party_Platforms/2.0/api/verify_beta_Mini_Programs/mpverifybetaweapp.html
     * @param string $mpAppId
     * @param string $ticket
     * @return mixed
     * @throws HttpException
     */
    public function mpVerifyBetaWeapp(string $mpAppId, string $ticket)
    {
        $response = $this->getClient()
            ->setMethod("POST")
            ->setBody($this->jsonDataToStream([
                'mp_appid' => $mpAppId,
                'ticket' => $ticket
            ]))
            ->send($this->buildUrl(
                "/wxa/mpverifybetaweapp",
                [
                    'access_token' => $this->app[ServiceProviders::AccessToken]->getToken()
                ]
            ));

        $this->checkResponse($response, $parseData);
        return $parseData;
    }
}
