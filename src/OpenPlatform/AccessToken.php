<?php
/**
 * Created by PhpStorm.
 * User: wwl
 * Date: 2019/08/13
 * Time: 12:19 AM
 */

namespace EasySwoole\WeChat\OpenPlatform;

use EasySwoole\HttpClient\Exception\InvalidUrl;
use EasySwoole\WeChat\Exception\RequestError;
use EasySwoole\WeChat\Utility\NetWork;
use EasySwoole\WeChat\Exception\OpenPlatformError;

/**
 * 访问令牌管理
 * Class AccessToken
 * @package EasySwoole\WeChat\MiniProgram
 */
class AccessToken extends OpenPlatformBase
{

    /**
     * 获取访问令牌 默认刷新一次
     * @param int $refreshTimes 获取失败的重试次数
     * @return string|null
     * @throws OpenPlatformError
     * @throws RequestError
     * @throws InvalidUrl
     */
    public function getComponentAccessToken($refreshTimes = 1): ?string
    {
        if ($refreshTimes < 0) {
            return null;
        }
        $data = $this->getOpenPlatform()->getConfig()->getStorage()->get('component_access_token');
        if (!empty($data)) {
            return $data;
        } else {
            $this->refresh();
            return $this->getComponentAccessToken($refreshTimes - 1);
        }
    }

    /**
     * 刷新访问令牌
     * @return string
     * @throws OpenPlatformError
     * @throws RequestError
     * @throws InvalidUrl
     */
    public function refresh(): string
    {
        $verifyTicket = $this->getOpenPlatform()->verifyTicket()->getTicket();
        $config = $this->getOpenPlatform()->getConfig();
        $data = [
            'component_appid' => $config->getComponentAppId(),
            'component_appsecret' => $config->getComponentAppSecret(),
            'component_verify_ticket' => $verifyTicket
        ];
        $responseArray = NetWork::postForJson(ApiUrl::API_COMPONENT_TOKEN, $data);
        $ex = OpenPlatformError::hasException($responseArray);
        if ($ex) {
            throw $ex;
        }
        $token = $responseArray['component_access_token'];
        $config->getStorage()->set('component_access_token', $token, time() + 7180); 
        return $token;
    }
}