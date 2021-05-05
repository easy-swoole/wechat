<?php


namespace EasySwoole\WeChat\MiniProgram\Auth;


use EasySwoole\WeChat\Kernel\ServiceProviders;
use EasySwoole\WeChat\MiniProgram\BaseClient;

/**
 * Class Client
 * @package EasySwoole\WeChat\MiniProgram\Auth
 */
class Client extends BaseClient
{
    /**
     * 登录凭证校验
     * auth.code2Session
     * doc link: https://developers.weixin.qq.com/miniprogram/dev/api-backend/open-api/login/auth.code2Session.html
     *
     * @param string $code
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function session(string $code)
    {
        $params = [
            'appid' => $this->app[ServiceProviders::Config]->get('appId'),
            'secret' => $this->app[ServiceProviders::Config]->get('appSecret'),
            'js_code' => $code,
            'grant_type' => 'authorization_code',
        ];

        $response = $this->getClient()
            ->setMethod('GET')
            ->send($this->buildUrl('/sns/jscode2session', $params));

        $this->checkResponse($response, $pareseData);

        return $pareseData;
    }
}
