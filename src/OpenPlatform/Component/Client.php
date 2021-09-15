<?php

namespace EasySwoole\WeChat\OpenPlatform\Component;

use EasySwoole\WeChat\Kernel\Exceptions\HttpException;
use EasySwoole\WeChat\Kernel\ServiceProviders;
use EasySwoole\WeChat\OpenPlatform\BaseClient;

/**
 * Class Client
 * @package EasySwoole\WeChat\OpenPlatform\Component
 * @author: XueSi
 * @email: <1592328848@qq.com>
 */
class Client extends BaseClient
{
    /**
     * 通过法人微信快速创建小程序.
     * 代注册小程序 - 快速创建小程序
     * doc link: https://developers.weixin.qq.com/doc/oplatform/Third-party_Platforms/2.0/api/Register_Mini_Programs/Fast_Registration_Interface_document.html
     *
     * @param array $params
     * @return mixed
     * @throws HttpException
     */
    public function registerMiniProgram(array $params)
    {
        $response = $this->getClient()
            ->setMethod("POST")
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                "/cgi-bin/component/fastregisterweapp",
                [
                    'action' => 'create',
                    'component_access_token' => $this->app[ServiceProviders::AccessToken]->getToken()
                ]
            ));

        return $this->checkResponse($response);
    }

    /**
     * 查询创建任务状态.
     * 代注册小程序 - 快速创建小程序 - 查询创建任务状态
     * doc link: https://developers.weixin.qq.com/doc/oplatform/Third-party_Platforms/2.0/api/Register_Mini_Programs/Fast_Registration_Interface_document.html
     *
     * @param string $companyName
     * @param string $legalPersonaWechat
     * @param string $legalPersonaName
     * @return mixed
     * @throws HttpException
     */
    public function getRegistrationStatus(string $companyName, string $legalPersonaWechat, string $legalPersonaName)
    {
        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream([
                'name' => $companyName,
                'legal_persona_wechat' => $legalPersonaWechat,
                'legal_persona_name' => $legalPersonaName,
            ]))->send($this->buildUrl(
                "/cgi-bin/component/fastregisterweapp",
                [
                    'action' => 'search',
                    'component_access_token' => $this->app[ServiceProviders::AccessToken]->getToken()
                ]
            ));

        return $this->checkResponse($response);
    }

    /**
     * 快速创建个人小程序 - 创建个人主体小程序
     * doc link: https://developers.weixin.qq.com/doc/oplatform/Third-party_Platforms/2.0/api/Register_Mini_Programs/fastregisterpersonalweapp.html
     *
     * @param string $idName
     * @param string $wxUser
     * @param string|null $componentPhone
     * @return mixed
     * @throws HttpException
     */
    public function registerPersonalWeapp(string $idName, string $wxUser, string $componentPhone = null)
    {
        $param = [
            'idname' => $idName,
            'wxuser' => $wxUser,
        ];

        if (!is_null($componentPhone)) {
            $param['component_phone'] = $componentPhone;
        }

        $response = $this->getClient()
            ->setMethod("POST")
            ->setBody($this->jsonDataToStream($param))
            ->send($this->buildUrl(
                "/wxa/component/fastregisterpersonalweapp",
                [
                    'action' => 'create',
                    'component_access_token' => $this->app[ServiceProviders::AccessToken]->getToken()
                ]
            ));

        $this->checkResponse($response, $data);
        return $data;
    }

    /**
     * 快速创建个人小程序 - 查询创建任务状态
     * doc link: https://developers.weixin.qq.com/doc/oplatform/Third-party_Platforms/2.0/api/Register_Mini_Programs/fastregisterpersonalweapp.html
     *
     * @param string $taskId
     * @return mixed
     * @throws HttpException
     */
    public function getPersonalWeappStatus(string $taskId)
    {
        $response = $this->getClient()
            ->setMethod("POST")
            ->setBody($this->jsonDataToStream(['taskid' => $taskId]))
            ->send($this->buildUrl(
                "/wxa/component/fastregisterpersonalweapp",
                [
                    'action' => 'query',
                    'component_access_token' => $this->app[ServiceProviders::AccessToken]->getToken()
                ]
            ));

        $this->checkResponse($response, $data);
        return $data;
    }
}
