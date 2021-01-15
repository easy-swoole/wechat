<?php


namespace EasySwoole\WeChat\OfficialAccount\JsSdk;


use EasySwoole\WeChat\Kernel\Contracts\AccessTokenInterface;
use EasySwoole\WeChat\Kernel\Contracts\ClientInterface;
use EasySwoole\WeChat\Kernel\Contracts\JsSdkTicketInterface;
use EasySwoole\WeChat\Kernel\Exceptions\HttpException;
use EasySwoole\WeChat\Kernel\ServiceContainer;
use EasySwoole\WeChat\Kernel\ServiceProviders;
use Psr\Http\Message\ResponseInterface;
use Psr\SimpleCache\CacheInterface;
use Psr\SimpleCache\InvalidArgumentException;

class Ticket implements JsSdkTicketInterface
{
    /** @var ServiceContainer  */
    protected $app;

    /** @var string  */
    protected $cachePrefix = 'easyswoole_wechat_jsTick_';

    /** @var string  */
    protected $responseTokenKey = 'ticket';

    public function __construct(ServiceContainer $app)
    {
        $this->app = $app;
    }

    /**
     * @param bool $autoRefresh
     * @return string|null
     * @throws HttpException
     * @throws InvalidArgumentException
     */
    public function getToken(bool $autoRefresh = true):? string
    {
        $token = $this->getCache()->get($this->getCacheKey(), null);
        if (!empty($token) || false === $autoRefresh) {
            return $token;
        }
        $this->refresh();
        return $this->getCache()->get($this->getCacheKey(), null);
    }

    /**
     * @return $this|JsSdkTicketInterface
     * @throws HttpException
     * @throws InvalidArgumentException
     */
    public function refresh(): JsSdkTicketInterface
    {
        $response = $this->sendRefreshRequest();
        $this->checkResponse($response, $jsonData);

        $this->getCache()->set(
            $this->getCacheKey(),
            $jsonData[$this->responseTokenKey],
            $jsonData['expires_in'] ?? (7200 - 30)
        );

        return $this;
    }

    /**
     * @return string
     */
    protected function getCacheKey():string
    {
        return $this->cachePrefix. md5($this->app[ServiceProviders::Config]->get('appId'));
    }

    /**
     * @return ResponseInterface
     */
    protected function sendRefreshRequest(): ResponseInterface
    {
        $url = "https://api.weixin.qq.com/cgi-bin/ticket/getticket?access_token={$this->getAccessToken()->getToken()}&type=jsapi";
        return $this->getClient()->setMethod("GET")->send($url);
    }

    /**
     * @param ResponseInterface $response
     * @param $parseData
     * @return bool
     * @throws HttpException
     */
    protected function checkResponse(ResponseInterface $response, &$parseData)
    {
        if (200 !== $response->getStatusCode()) {
            throw new HttpException(
                $response->getBody()->__toString(),
                $response
            );
        }

        $data = $this->parseData($response);
        $parseData = $data;

        if (isset($data['errcode']) && (int)$data['errcode'] !== 0) {
            throw new HttpException(
                "refresh access_token fail, message: ({$data['errcode']}) {$data['errmsg']}",
                $response,
                $data['errcode']
            );
        }

        return true;
    }

    /**
     * @param ResponseInterface $response
     * @return array
     * @throws HttpException
     */
    protected function parseData(ResponseInterface $response):array
    {
        $data = json_decode($response->getBody()->__toString(), true);
        if (is_null($data) || (JSON_ERROR_NONE !== json_last_error())) {
            throw new HttpException("parse response body fail.", $response);
        }
        return $data;
    }

    /**
     * @return CacheInterface
     */
    protected function getCache():CacheInterface
    {
        return $this->app[ServiceProviders::Cache];
    }

    /**
     * @return ClientInterface
     */
    protected function getClient():ClientInterface
    {
        return $this->app[ServiceProviders::HttpClientManager]->getClient();
    }

    protected function getAccessToken():AccessTokenInterface
    {
        return $this->app[ServiceProviders::AccessToken];
    }

}