<?php
declare(strict_types=1);

/**
 ***********作者信息**********
 * Author: ysongyang
 * Email: 49271743@qq.com
 * Desc: 文件描述
 * Date: 2021/9/13 13:22
 *****************************
 */

namespace EasySwoole\WeChat\OpenPlatform\Component\BetaProgram;


use EasySwoole\WeChat\Kernel\Exceptions\HttpException;
use EasySwoole\WeChat\Kernel\ServiceProviders;
use EasySwoole\WeChat\OpenPlatform\BaseClient;

class Client extends BaseClient
{

    /**
     * 创建试用小程序
     * doc link: https://developers.weixin.qq.com/doc/oplatform/Third-party_Platforms/2.0/api/beta_Mini_Programs/fastregister.html
     * @param array $params
     * @return mixed
     * @throws HttpException
     */
    public function fastregisterbetaweapp(array $params)
    {
        $response = $this->getClient()
            ->setMethod("POST")
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                "/wxa/component/fastregisterbetaweapp",
                [
                    'component_access_token' => $this->app[ServiceProviders::AccessToken]->getToken()
                ]
            ));

        $this->checkResponse($response, $parseData);
        return $parseData;
    }


    /**
     * 试用小程序快速认证
     * 该接口用于通过企业法人人脸识别的方式快速将试用小程序进行认证
     * doc link: https://developers.weixin.qq.com/doc/oplatform/Third-party_Platforms/2.0/api/beta_Mini_Programs/fastverify.html
     * @param array $params
     * @return mixed
     * @throws HttpException
     */
    public function verifybetaweapp(array $params)
    {
        $response = $this->getClient()
            ->setMethod("POST")
            ->setBody($this->jsonDataToStream($params))
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
     * @param array $params
     * @return mixed
     * @throws HttpException
     */
    public function setbetaweappnickname(array $params)
    {
        $response = $this->getClient()
            ->setMethod("POST")
            ->setBody($this->jsonDataToStream($params))
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
     * @param array $params
     * @return mixed
     * @throws HttpException
     */
    public function getmpadminauth(array $params)
    {
        $response = $this->getClient()
            ->setMethod("POST")
            ->setBody($this->jsonDataToStream($params))
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
     * @param array $params
     * @return mixed
     * @throws HttpException
     */
    public function mpverifybetaweapp(array $params)
    {
        $response = $this->getClient()
            ->setMethod("POST")
            ->setBody($this->jsonDataToStream($params))
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