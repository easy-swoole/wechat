<?php


namespace EasySwoole\WeChat\Tests;


use EasySwoole\WeChat\Kernel\Contracts\AccessTokenInterface;
use EasySwoole\WeChat\Kernel\ServiceContainer;
use EasySwoole\WeChat\Kernel\ServiceProviders;
use EasySwoole\WeChat\Tests\Mock\Message\Response;
use EasySwoole\WeChat\Tests\Mock\Message\ServerRequest;
use EasySwoole\WeChat\Tests\Mock\Message\Stream;
use EasySwoole\WeChat\Tests\Mock\Message\Uri;
use EasySwoole\WeChat\Tests\Mock\MockHttpClient;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\ServerRequestInterface;

class TestCase extends \PHPUnit\Framework\TestCase
{
    protected function mockAccessToken(ServiceContainer $app, AccessTokenInterface $accessToken = null): ServiceContainer
    {
        if (is_null($accessToken)) {
            $accessToken = new class implements AccessTokenInterface {
                public function getToken(bool $autoRefresh = true): ?string
                {
                    return "mock_access_token";
                }

                public function refresh(): AccessTokenInterface
                {
                    return $this;
                }
            };
        }

        $app[ServiceProviders::AccessToken] = function () use ($accessToken) {
            return $accessToken;
        };
        return $app;
    }

    /**
     * @param callable $onRequest
     * @param ResponseInterface $response
     * @param ServiceContainer $app
     * @return ServiceContainer
     */
    protected function mockHttpClient(callable $onRequest, ResponseInterface $response, ServiceContainer $app): ServiceContainer
    {
        $app[ServiceProviders::HttpClientManager] = function () use ($onRequest, $response) {
            return new MockHttpClient($onRequest, $response);
        };
        return $app;
    }

    /**
     * @param int $statusCode
     * @param array|null $body
     * @param array $headers
     * @return ResponseInterface
     */
    protected function buildJsonResponse(int $statusCode, array $body = null, array $headers = []): ResponseInterface
    {
        $body = is_null($body) ? "" : json_encode($body, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        return $this->buildResponse($statusCode, $body, $headers);
    }

    /**
     * @param int $statusCode
     * @param string $body
     * @param array $headers
     * @return ResponseInterface
     */
    protected function buildResponse(int $statusCode, string $body = "", array $headers = []): ResponseInterface
    {
        return (new Response($headers, new Stream($body)))->withStatus($statusCode);
    }

    /**
     * @param string $method
     * @param string $uri
     * @param array $headers
     * @param string $body
     * @param string $protocolVersion
     * @param array $serverParams
     * @return ServerRequestInterface
     */
    protected function buildRequest(
        $method = 'GET',
        string $uri = "",
        array $headers = [],
        string $body = "",
        $protocolVersion = '1.1',
        $serverParams = []): ServerRequestInterface
    {
        return new ServerRequest($method, new Uri($uri), $headers, new Stream($body), $protocolVersion, $serverParams);
    }
}