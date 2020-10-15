<?php


namespace EasySwoole\WeChat\Kernel;


use EasySwoole\WeChat\Kernel\Contracts\ClientInterface;
use EasySwoole\WeChat\Kernel\Exceptions\HttpException;
use EasySwoole\WeChat\Kernel\Psr\Stream;
use Psr\Http\Message\ResponseInterface;

class BaseClient
{
    protected $baseUrl = 'https://api.weixin.qq.com';
    protected $app;

    public function __construct(ServiceContainer $app)
    {
        $this->app = $app;
    }

    /**
     * @param string $path
     * @param array $params
     * @return string
     */
    protected function buildUrl(string $path, array $params = []): string
    {
        if (!empty($params)) {
            $path .= '?'. http_build_query($params);
        }
        return $this->baseUrl. $path;
    }

    /**
     * @return ClientInterface
     */
    protected function getClient():ClientInterface
    {
        return $this->app[ServiceProviders::HttpClientManager]->getClient();
    }

    /**
     * @param ResponseInterface $response
     * @param null $parseData
     * @return bool
     * @throws HttpException
     */
    protected function checkResponse(ResponseInterface $response, &$parseData = null): bool
    {
        if (!in_array($response->getStatusCode(), [200])) {
            throw new HttpException(
                $response->getBody()->__toString(),
                $response
            );
        }

        $data = $this->parseData($response);
        $parseData = $data;

        if (isset($data['errcode']) && (int)$data['errcode'] !== 0) {
            throw new HttpException(
                "request wechat error, message: ({$data['errcode']}) {$data['errmsg']}",
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
     * @param array $json
     * @return Stream
     */
    protected function jsonDataToStream(array $json):Stream
    {
        return new Stream(json_encode($json, JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE));
    }
}