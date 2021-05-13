<?php

namespace EasySwoole\WeChat\OpenPlatform\Authorizer\MiniProgram\Tester;

use EasySwoole\WeChat\Kernel\Exceptions\HttpException;
use EasySwoole\WeChat\Kernel\ServiceProviders;
use EasySwoole\WeChat\OpenPlatform\BaseClient;

class Client extends BaseClient
{
    /**
     * 代小程序实现业务 - 成员管理 - 绑定微信用户为体验者
     * doc link: https://developers.weixin.qq.com/doc/oplatform/Third-party_Platforms/Mini_Programs/Admin.html
     *
     * 绑定小程序体验者
     * @param string $wechatId
     * @return mixed
     * @throws HttpException
     */
    public function bind(string $wechatId)
    {
        $response = $this->getClient()
            ->setMethod("POST")
            ->setBody($this->jsonDataToStream(['wechatid' => $wechatId]))
            ->send($this->buildUrl(
                "/wxa/bind_tester",
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        $this->checkResponse($response, $data);

        return $data;
    }

    /**
     * 代小程序实现业务 - 成员管理 - 获取体验者列表
     * doc link: https://developers.weixin.qq.com/doc/oplatform/Third-party_Platforms/Mini_Programs/Admin.html
     *
     * 获取体验者列表
     * @return mixed
     * @throws HttpException
     */
    public function list()
    {
        $response = $this->getClient()
            ->setMethod("POST")
            ->setBody($this->jsonDataToStream(['action' => 'get_experiencer']))
            ->send($this->buildUrl(
                "/wxa/memberauth",
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        $this->checkResponse($response, $data);

        return $data;
    }

    /**
     * 代小程序实现业务 - 成员管理 - 解除绑定体验者
     * doc link: https://developers.weixin.qq.com/doc/oplatform/Third-party_Platforms/Mini_Programs/unbind_tester.html
     *
     * 解绑小程序体验者
     * @param string|null $wechatId
     * @param string|null $userStr
     * @return mixed
     * @throws HttpException
     */
    public function unbind(?string $wechatId = null, ?string $userStr = null)
    {
        if ($userStr) {
            $params = ['userstr' => $userStr];
        } else {
            $params = ['wechatid' => $wechatId];
        }
        $response = $this->getClient()
            ->setMethod("POST")
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                "/wxa/unbind_tester",
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        return $this->checkResponse($response);
    }

    /**
     * 代小程序实现业务 - 成员管理 - 解除绑定体验者
     * doc link: https://developers.weixin.qq.com/doc/oplatform/Third-party_Platforms/Mini_Programs/unbind_tester.html
     *
     * 解绑小程序体验者
     * @param string $userStr
     * @return mixed
     * @throws HttpException
     */
    public function unbindWithUserStr(string $userStr)
    {
        return $this->unbind(null, $userStr);
    }
}
