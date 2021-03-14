<?php



namespace EasySwoole\WeChat\OpenPlatform\Authorizer\MiniProgram\Domain;



use EasySwoole\WeChat\Kernel\Exceptions\HttpException;
use EasySwoole\WeChat\Kernel\ServiceProviders;
use EasySwoole\WeChat\OpenPlatform\BaseClient;

class Client extends BaseClient
{
    /**
     * @param array $params
     * @return mixed
     * @throws HttpException
     */
    public function modify(array $params)
    {
        $response = $this->getClient()
            ->setMethod("POST")
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                "/wxa/modify_domain",
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        $this->checkResponse($response, $data);

        return $data;
    }

    /**
     * 设置小程序业务域名
     * @param array $domains
     * @param string $action
     * @return mixed
     * @throws HttpException
     */
    public function setWebviewDomain(array $domains, $action = 'add')
    {
        $response = $this->getClient()
            ->setMethod("POST")
            ->setBody($this->jsonDataToStream([
                'action' => $action,
                'webviewdomain' => $domains,
            ]))->send($this->buildUrl(
                "/wxa/setwebviewdomain",
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()]
            ));

        $this->checkResponse($response, $data);

        return $data;
    }
}
