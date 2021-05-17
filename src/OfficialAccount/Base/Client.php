<?php

namespace EasySwoole\WeChat\OfficialAccount\Base;

use EasySwoole\WeChat\Kernel\BaseClient;
use EasySwoole\WeChat\Kernel\Exceptions\HttpException;
use EasySwoole\WeChat\Kernel\Exceptions\InvalidArgumentException;
use EasySwoole\WeChat\Kernel\ServiceProviders;

class Client extends BaseClient
{
    /**
     * 公众号调用或第三方平台帮公众号调用对公众号的所有api调用（包括第三方帮其调用）次数进行清零
     * doc link: https://developers.weixin.qq.com/doc/offiaccount/Message_Management/API_Call_Limits.html
     *
     * @return bool
     * @throws HttpException
     */
    public function clearQuota(): bool
    {
        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream(
                ['appid' => $this->app[ServiceProviders::Config]->get('appId')]
            ))->send($this->buildUrl(
                '/cgi-bin/clear_quota',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        return $this->checkResponse($response);
    }

    /**
     * 获取微信 callback IP 地址
     * doc link: https://developers.weixin.qq.com/doc/offiaccount/Basic_Information/Get_the_WeChat_server_IP_address.html
     *
     * @return array
     * @throws HttpException
     */
    public function getValidIps():array
    {
        $response = $this->getClient()
            ->setMethod('GET')
            ->send($this->buildUrl('/cgi-bin/getcallbackip',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        $this->checkResponse($response, $jsonData);
        return $jsonData;
    }

    /**
     * 网络检测
     * Check the callback address network.
     * doc link: https://developers.weixin.qq.com/doc/offiaccount/Basic_Information/Network_Detection.html
     *
     * @param string $action
     * @param string $operator
     * @return mixed
     * @throws HttpException
     * @throws InvalidArgumentException
     */
    public function checkCallbackUrl(string $action = 'all', string $operator = 'DEFAULT')
    {
        if (!in_array($action, ['dns', 'ping', 'all'], true)) {
            throw new InvalidArgumentException('The action must be dns, ping, all.');
        }

        $operator = strtoupper($operator);

        if (!in_array($operator, ['CHINANET', 'UNICOM', 'CAP', 'DEFAULT'], true)) {
            throw new InvalidArgumentException('The operator must be CHINANET, UNICOM, CAP, DEFAULT.');
        }

        $params = [
            'action' => $action,
            'check_operator' => $operator,
        ];

        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl('/cgi-bin/callback/check',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        $this->checkResponse($response, $jsonData);
        return $jsonData;
    }
}