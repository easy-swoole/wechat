<?php


namespace EasySwoole\WeChat\OpenPlatform;


use EasySwoole\WeChat\AbstractInterface\AccessTokenInterface;
use EasySwoole\WeChat\Exception\OpenPlatformError;
use EasySwoole\WeChat\Utility\NetWork;

class OfficialAccessToken extends OpenPlatformBase implements AccessTokenInterface
{
    private $authorizerRefreshToken;
    private $appId;

    public function setAuthorizerRefreshToken(string $authorizerRefreshToken): OfficialAccessToken
    {
        $this->authorizerRefreshToken = $authorizerRefreshToken;
        return $this;
    }

    public function getAuthorizerRefreshToken(): ?string
    {
        return $this->authorizerRefreshToken;
    }

    public function setAppId(string $appId): OfficialAccessToken
    {
        $this->appId = $appId;
        return $this;
    }

    public function getAppId(): ?string
    {
        return $this->appId;
    }

    /**
     * getToken
     *
     * @param int $refreshTimes
     * @return string|null
     * @throws OpenPlatformError
     * @throws \EasySwoole\HttpClient\Exception\InvalidUrl
     * @throws \EasySwoole\WeChat\Exception\RequestError
     */
    public function getToken($refreshTimes = 1): ?string
    {
        if ($refreshTimes < 0) {
            return null;
        }
        $data = $this->getOpenPlatform()->getConfig()->getStorage()->get("authorizer_access_token_{$this->getAppId()}");
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
     * @throws \EasySwoole\HttpClient\Exception\InvalidUrl
     * @throws \EasySwoole\WeChat\Exception\RequestError
     */
    public function refresh(): string
    {
        $config = $this->getOpenPlatform()->getConfig();
        $url = ApiUrl::generateURL(ApiUrl::API_AUTHORIZER_TOKEN, [
            'COMPONENT_ACCESS_TOKEN' => $this->getOpenPlatform()->componentAccessToken()->getToken()
        ]);

        $response = NetWork::postJsonForJson($url, [
            'component_appid'          => $config->getComponentAppId(),
            'authorizer_appid'         => $this->getAppId(),
            'authorizer_refresh_token' => $this->getAuthorizerRefreshToken()
        ]);
        $ex = OpenPlatformError::hasException($response);
        if ($ex) {
            throw $ex;
        }
        $token = $response['authorizer_access_token'];
        // 这里减去60秒防止过期
        $expires = $response['expires_in'] - 60;
        $config->getStorage()->set("authorizer_access_token_{$this->getAppId()}", $token, time() + $expires);
        return $token;
    }

}