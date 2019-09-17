<?php
/**
 * Created by PhpStorm.
 * User: eValor
 * Date: 2019-03-18
 * Time: 10:18
 */

namespace EasySwoole\WeChat\OpenPlatform;

use EasySwoole\WeChat\Bean\OpenPlatform\AuthorizerInfo;
use EasySwoole\WeChat\Exception\OpenPlatformError;
use EasySwoole\WeChat\MiniProgram\MiniProgram;
use EasySwoole\WeChat\MiniProgram\MiniProgramConfig;
use EasySwoole\WeChat\OfficialAccount\OfficialAccount;
use EasySwoole\WeChat\OfficialAccount\OfficialAccountConfig;
use EasySwoole\WeChat\Utility\NetWork;

class OpenPlatform
{
    private $config;
    private $verifyTicket;
    private $server;
    private $auth;
    private $officialAccounts = [];
    private $miniPrograms = [];

    public function __construct(OpenPlatformConfig $config = null)
    {
        if (is_null($config)) {
            $config = new OpenPlatformConfig;
        }
        $this->config = $config;
    }

    /**
     * authorization
     *
     * @return Auth
     */
    public function auth(): Auth
    {
        if (!isset($this->auth)) {
            $this->auth = new Auth($this);
        }
        return $this->auth;
    }

    public function server(): Server
    {
        if (!isset($this->server)) {
            $this->server = new Server($this);
        }
        return $this->server;
    }

    public function officialAccount(string $appId, string $authorizerRefreshToken = null): OfficialAccount
    {
        if (!isset($this->officialAccounts[$appId])) {
            $config = new OfficialAccountConfig();
            $config->setAppId($appId);
            $config->setToken($this->getConfig()->getToken());
            $accessToken = (new OfficialAccessToken($this))->setAppId($appId);
            $officialAccount = new OfficialAccount($config, $accessToken);
            $officialAccount->server()->onEvent()->onEncryptorDecrypt(function (string $raw) {
                return Encryptor::decrypt($this->getConfig()->getComponentAppId(), $raw, $this->getConfig()->getAesKey());
            });
            $officialAccount->server()->onEvent()->onEncryptorEncrypt(function (string $raw) {
                return Encryptor::encrypt($this->getConfig()->getComponentAppId(), $raw, $this->getConfig()->getAesKey());
            });
            $this->officialAccounts[$appId] = $officialAccount;
        }

        if (!is_null($authorizerRefreshToken)) {
            $this->officialAccounts[$appId]->accessToken()->setAuthorizerRefreshToken($authorizerRefreshToken);
        }
        return $this->officialAccounts[$appId];
    }

    public function miniProgram(string $appId): MiniProgram
    {
        if (!isset($this->miniPrograms[$appId])) {
            $config = new MiniProgramConfig();
            $config->setAppId($appId);
            $this->miniPrograms[$appId] = new MiniProgram($config);
        }
        return $this->miniPrograms[$appId];
    }

    /**
     * ConfigGetter
     *
     * @return OpenPlatformConfig
     */
    public function getConfig(): OpenPlatformConfig
    {
        return $this->config;
    }

    /**
     * accessToken
     *
     * @return ComponentAccessToken
     */
    public function componentAccessToken(): ComponentAccessToken
    {
        if (!isset($this->accessToken)) {
            $this->accessToken = new ComponentAccessToken($this);
        }

        return $this->accessToken;
    }

    /**
     * VerifyTicket
     *
     * @return VerifyTicket
     */
    public function verifyTicket(): VerifyTicket
    {
        if (!isset($this->verifyTicket)) {
            $this->verifyTicket = new VerifyTicket($this);
        }

        return $this->verifyTicket;
    }

    /**
     * getPreAuthorizationUrl
     * 授权注册页面扫码授权
     *
     * @param string      $redirectUrl
     * @param int         $authType
     * @param string|null $bizAppid
     * @return string
     * @throws OpenPlatformError
     * @throws \EasySwoole\HttpClient\Exception\InvalidUrl
     * @throws \EasySwoole\WeChat\Exception\RequestError
     */
    public function getPreAuthorizationUrl(string $redirectUrl, int $authType = 3, string $bizAppid = null): string
    {
        $url = ApiUrl::generateURL(ApiUrl::COMPONENT_LOGIN_PAGE, [
            'COMPONENT_APPID' => $this->getConfig()->getComponentAppId(),
            'PRE_AUTH_CODE'   => $this->componentAccessToken()->getPreauthcode(),
            'REDIRECT_URI'    => $redirectUrl,
            'AUTH_TYPE'       => $authType,
            'BIZ_APPID'       => $bizAppid
        ]);

        return $url;
    }

    /**
     * handleAuthorize
     * 使用授权码获取授权信息
     *
     * @param string $authCode
     * @param int    $expires
     * @return AuthorizerInfo
     * @throws OpenPlatformError
     * @throws \EasySwoole\HttpClient\Exception\InvalidUrl
     * @throws \EasySwoole\WeChat\Exception\RequestError
     */
    public function handleAuthorize(string $authCode, int $expires = (3600 - 60)): AuthorizerInfo
    {
        $this->getConfig()->getStorage()->set('auth_code', $authCode, time() + $expires);
        $url = ApiUrl::generateURL(ApiUrl::API_QUERY_AUTH, [
            'COMPONENT_ACCESS_TOKEN' => $this->componentAccessToken()->getToken()
        ]);

        $response = NetWork::postJsonForJson($url, [
            'component_appid'    => $this->getConfig()->getComponentAppId(),
            'authorization_code' => $this->getConfig()->getStorage()->get('auth_code')
        ]);

        $ex = OpenPlatformError::hasException($response);
        if ($ex) {
            throw $ex;
        }
        return new AuthorizerInfo($response['authorization_info']);
    }
}