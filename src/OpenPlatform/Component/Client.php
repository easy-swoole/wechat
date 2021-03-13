<?php


namespace EasySwoole\WeChat\OpenPlatform\Component;


use EasySwoole\WeChat\Kernel\Exceptions\HttpException;
use EasySwoole\WeChat\Kernel\ServiceProviders;
use EasySwoole\WeChat\OpenPlatform\BaseClient;

class Client extends BaseClient
{
    /**
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
                    'access_token' => $this->app[ServiceProviders::AccessToken]->getToken()
                ]
            ));

        $this->checkResponse($response, $data);
        return $data;
    }

    /**
     * @param string $companyName
     * @param string $legalPersonaWechat
     * @param string $legalPersonaName
     * @return mixed
     * @throws HttpException
     */
    public function getRegistrationStatus(string $companyName, string $legalPersonaWechat, string $legalPersonaName)
    {
        $response = $this->getClient()
            ->setBody($this->jsonDataToStream([
                'name' => $companyName,
                'legal_persona_wechat' => $legalPersonaWechat,
                'legal_persona_name' => $legalPersonaName,
            ]))->send($this->buildUrl(
                "/cgi-bin/component/fastregisterweapp",
                [
                    'action' => 'search',
                    'access_token' => $this->app[ServiceProviders::AccessToken]->getToken()
                ]
            ));

        $this->checkResponse($response, $data);
        return $data;
    }
}
