<?php
/**
 * Created by PhpStorm.
 * User: yf
 * Date: 2018/12/25
 * Time: 12:09 AM
 */

namespace EasySwoole\WeChat\OpenPlatform;

use EasySwoole\WeChat\Exception\OpenPlatformError;
use EasySwoole\WeChat\Exception\RequestError;
use EasySwoole\WeChat\Utility\NetWork;


class ComponentAccessToken extends OpenPlatformBase
{
    /**
     * 默认刷新一次
     *
     * @param int $refreshTimes
     * @return string|null
     * @throws OpenPlatformError
     * @throws RequestError
     * @throws \EasySwoole\HttpClient\Exception\InvalidUrl
     */
    function getToken($refreshTimes = 1): ?string
    {
        if ($refreshTimes < 0) {
            return null;
        }
        $data = $this->getOpenPlatform()->getConfig()->getStorage()->get('component_access_token');
        if (!empty($data)) {
            return $data;
        } else {
            $this->refresh();
            return $this->getToken($refreshTimes - 1);
        }
    }

    /**
     * refresh
     *
     * @return string
     * @throws OpenPlatformError
     * @throws RequestError
     * @throws \EasySwoole\HttpClient\Exception\InvalidUrl
     */
    public function refresh(): string
    {
        $config = $this->getOpenPlatform()->getConfig();
        $url = ApiUrl::COMPONENT_API_COMPONENT_TOKEN;

        $data = [
            'component_appid'         => $config->getComponentAppId(),
            'component_appsecret'     => $config->getComponentAppSecret(),
            'component_verify_ticket' => $this->getOpenPlatform()->verifyTicket()->getTicket()
        ];

        $response = NetWork::postJsonForJson($url, $data);
        $ex = OpenPlatformError::hasException($response);
        if ($ex) {
            throw $ex;
        }
        $token = $response['component_access_token'];
        // 这里减去60秒防止过期
        $expires = $response['expires_in'] - 60;
        $config->getStorage()->set('component_access_token', $token, time() + $expires);
        return $token;
    }
}