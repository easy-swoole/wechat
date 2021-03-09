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
