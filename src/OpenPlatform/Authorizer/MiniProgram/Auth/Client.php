<?php


namespace EasySwoole\WeChat\OpenPlatform\Authorizer\MiniProgram\Auth;


use EasySwoole\WeChat\Kernel\Exceptions\HttpException;
use EasySwoole\WeChat\Kernel\ServiceContainer;
use EasySwoole\WeChat\Kernel\ServiceProviders;
use EasySwoole\WeChat\OpenPlatform\Application;
use EasySwoole\WeChat\OpenPlatform\BaseClient;

class Client extends BaseClient
{
    /**
     * @var Application
     */
    protected $component;

    /**
     * Client constructor.
     * @param ServiceContainer $app
     * @param Application $component
     */
    public function __construct(ServiceContainer $app, Application $component)
    {
        parent::__construct($app);

        $this->component = $component;
    }

    /**
     * @param string $code
     * @return mixed
     * @throws HttpException
     */
    public function session(string $code)
    {
        $response = $this->getClient()
            ->setMethod("GET")
            ->send($this->buildUrl(
                "/sns/component/jscode2session",
                [
                    'appid' => $this->app[ServiceProviders::Config]->get('appId'),
                    'js_code' => $code,
                    'grant_type' => 'authorization_code',
                    'component_appid' => $this->component[ServiceProviders::Config]->get('appId'),
                    'component_access_token' => $this->component[ServiceProviders::AccessToken]->getToken(),
                ]
            ));

        $this->checkResponse($response, $data);
        return $data;
    }
}
