<?php
/**
 * User: XueSi
 * Date: 2021/9/14 15:57
 * Author: XueSi <1592328848@qq.com>
 */

namespace EasySwoole\WeChat\OpenPlatform\BetaMiniProgram;

use EasySwoole\WeChat\Kernel\ServiceProviders;
use EasySwoole\WeChat\OpenPlatform\BaseClient;
use EasySwoole\WeChat\Kernel\Exceptions\HttpException;

class Client extends BaseClient
{
    /**
     * 创建试用小程序
     * doc link: https://developers.weixin.qq.com/doc/oplatform/Third-party_Platforms/2.0/api/beta_Mini_Programs/fastregister.html
     * @param string $name
     * @param string $openId
     * @return mixed
     * @throws HttpException
     */
    public function fastRegisterBetaWeapp(string $name, string $openId)
    {
        $response = $this->getClient()
            ->setMethod("POST")
            ->setBody($this->jsonDataToStream([
                'name' => $name,
                'openid' => $openId
            ]))
            ->send($this->buildUrl(
                "/wxa/component/fastregisterbetaweapp",
                [
                    'access_token' => $this->app[ServiceProviders::AccessToken]->getToken()
                ]
            ));

        $this->checkResponse($response, $parseData);
        return $parseData;
    }
}
