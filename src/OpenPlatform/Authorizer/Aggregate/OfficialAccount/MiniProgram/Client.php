<?php


namespace EasySwoole\WeChat\OpenPlatform\Authorizer\Aggregate\OfficialAccount\MiniProgram;


use EasySwoole\WeChat\Kernel\Exceptions\HttpException;
use EasySwoole\WeChat\Kernel\ServiceProviders;
use EasySwoole\WeChat\OpenPlatform\BaseClient;

class Client extends BaseClient
{
    /**
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

        $this->checkResponse($response, $data);
        return $data;
    }

    /**
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

        $this->checkResponse($response, $data);
        return $data;
    }
}
