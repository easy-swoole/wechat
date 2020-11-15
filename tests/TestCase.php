<?php


namespace EasySwoole\WeChat\Tests;


use EasySwoole\WeChat\Kernel\Contracts\AccessTokenInterface;
use EasySwoole\WeChat\Kernel\Psr\Response;
use EasySwoole\WeChat\Kernel\Psr\Stream;
use EasySwoole\WeChat\Kernel\ServiceContainer;
use EasySwoole\WeChat\Kernel\ServiceProviders;
use EasySwoole\WeChat\Tests\Mock\MockHttpClient;
use Psr\Http\Message\ResponseInterface;

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
     * @param callable          $onRequest
     * @param ResponseInterface $response
     * @param ServiceContainer  $app
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
     * @param int        $statusCode
     * @param array|null $body
     * @param array      $headers
     * @return ResponseInterface
     */
    protected function buildJsonResponse(int $statusCode, array $body = null, array $headers = []): ResponseInterface
    {
        $body = is_null($body) ? "" : json_encode($body, JSON_UNESCAPED_SLASHES | JSON_UNESCAPED_UNICODE);
        return $this->buildResponse($statusCode, $body, $headers);
    }

    /**
     * @param int    $statusCode
     * @param string $body
     * @param array  $headers
     * @return ResponseInterface
     */
    protected function buildResponse(int $statusCode, string $body = "", array $headers = []): ResponseInterface
    {
        return new Response($statusCode, $headers, new Stream($body));
    }
}