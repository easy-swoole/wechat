<?php

namespace EasySwoole\WeChat\OpenPlatform\Authorizer\OfficialAccount\MiniProgram;

use EasySwoole\WeChat\Kernel\Exceptions\HttpException;
use EasySwoole\WeChat\Kernel\ServiceProviders;
use EasySwoole\WeChat\OpenPlatform\BaseClient;

class Client extends BaseClient
{
    /**
     * 代公众号实现业务 - 小程序管理权限集 - 获取公众号关联的小程序
     * doc link: https://developers.weixin.qq.com/doc/oplatform/Third-party_Platforms/Official_Accounts/Mini_Program_Management_Permission.html
     *
     * @return mixed
     * @throws HttpException
     */
    public function list()
    {
        $response = $this->getClient()
            ->setMethod("POST")
            ->send($this->buildUrl(
                "/cgi-bin/wxopen/wxamplinkget",
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        $this->checkResponse($response, $data);

        return $data;
    }

    /**
     * 代公众号实现业务 - 小程序管理权限集 - 关联小程序 关联流程
     * doc link: https://developers.weixin.qq.com/doc/oplatform/Third-party_Platforms/Official_Accounts/Mini_Program_Management_Permission.html
     *
     * @param string $appId
     * @param bool $notifyUsers
     * @param bool $showProfile
     * @return mixed
     * @throws HttpException
     */
    public function link(string $appId, bool $notifyUsers = true, bool $showProfile = false)
    {
        $response = $this->getClient()
            ->setMethod("POST")
            ->setBody($this->jsonDataToStream([
                'appid' => $appId,
                'notify_users' => (string)$notifyUsers,
                'show_profile' => (string)$showProfile,
            ]))->send($this->buildUrl(
                "/cgi-bin/wxopen/wxamplink",
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        return $this->checkResponse($response);
    }

    /**
     * 代公众号实现业务 - 小程序管理权限集 - 解除已关联的小程序
     * doc link: https://developers.weixin.qq.com/doc/oplatform/Third-party_Platforms/Official_Accounts/Mini_Program_Management_Permission.html
     *
     * @param string $appId
     * @return mixed
     * @throws HttpException
     */
    public function unlink(string $appId)
    {
        $response = $this->getClient()
            ->setMethod("POST")
            ->setBody($this->jsonDataToStream([
                'appid' => $appId,
            ]))->send($this->buildUrl(
                "/cgi-bin/wxopen/wxampunlink",
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        return $this->checkResponse($response);
    }
}
