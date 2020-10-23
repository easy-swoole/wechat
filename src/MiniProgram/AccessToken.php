<?php
/**
 * Created by PhpStorm.
 * User: yf
 * Date: 2018/12/25
 * Time: 12:09 AM
 */

namespace EasySwoole\WeChat\MiniProgram;

use EasySwoole\HttpClient\Exception\InvalidUrl;
use EasySwoole\WeChat\AbstractInterface\AccessTokenInterface;
use EasySwoole\WeChat\Exception\RequestError;
use EasySwoole\WeChat\Utility\NetWork;
use EasySwoole\WeChat\Exception\MiniProgramError;

/**
 * 访问令牌管理
 * Class AccessToken
 * @package EasySwoole\WeChat\MiniProgram
 */
class AccessToken extends MinProgramBase implements AccessTokenInterface
{

    /**
     * 获取访问令牌
     * 自带版本不刷新
     * @param int $refreshTimes
     * @return string|null
     * @throws \Throwable
     */
    public function getToken($refreshTimes = 1): ?string
    {
        return $this->getMiniProgram()->getConfig()->getStorage()->get('access_token');
    }

    /**
     * 刷新访问令牌
     * @return string
     * @throws MiniProgramError
     * @throws RequestError
     * @throws InvalidUrl
     */
    public function refresh(): ?string
    {
        $config = $this->getMiniProgram()->getConfig();
        $url = ApiUrl::generateURL(ApiUrl::AUTH_GET_ACCESS_TOKEN, [
            'APPID'     => $config->getAppId(),
            'APPSECRET' => $config->getAppSecret()
        ]);
        $responseArray = NetWork::getForJson($url);
        $ex = MiniProgramError::hasException($responseArray);
        if ($ex) {
            throw $ex;
        }
        $token = $responseArray['access_token'];
        $config->getStorage()->set('access_token', $token, time() + 7180); // 这里故意设置为7180 提前刷新
        return $token;
    }
}