<?php


namespace EasySwoole\WeChat\Kernel\HttpClient;


use EasySwoole\Spl\SplStream;
use EasySwoole\WeChat\Kernel\Contracts\ClientInterface;
use EasySwoole\WeChat\Kernel\HttpClient\Exception\InvalidUrIException;
use EasySwoole\WeChat\Kernel\HttpClient\Exception\RequestException;
use EasySwoole\WeChat\Kernel\HttpClient\Exception\TimeOutException;
use EasySwoole\WeChat\Kernel\Psr\Response;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;
use Swoole\Coroutine\Http\Client;

class SwooleClientDriver implements ClientInterface
{
    /** @var Client|null */
    protected $client;

    /** @var string[] */
    protected $defaultOptions = [
        "timeout" => 5.0
    ];

    /** @var string[] */
    protected $defaultHeaders = [
        "user-agent" => 'EasySwoole-wechat/2.x',
        'accept'     => '*/*'
    ];

    /** @var float|null */
    protected $timeout;
    /** @var array */
    protected $headers = [];
    /** @var string|null */
    protected $method;
    /** @var StreamInterface|null */
    protected $body;

    protected $uploadFiles = [
        'file'   => [],
        'stream' => []
    ];

    public function setTimeout(float $timeout): ClientInterface
    {
        $this->timeout = $timeout;
        return $this;
    }

    public function setHeaders(array $headers): ClientInterface
    {
        $this->headers = $headers;
        return $this;
    }

    public function setMethod(string $method): ClientInterface
    {
        $this->method = $method;
        return $this;
    }

    public function setBody(StreamInterface $body): ClientInterface
    {
        $this->body = $body;
        return $this;
    }

    public function addFile(string $path, string $dataName): ClientInterface
    {
        $this->uploadFiles['file'][] = [$dataName => $path];
        return $this;
    }

    public function addStream(StreamInterface $stream, string $dataName): ClientInterface
    {
        $this->uploadFiles['stream'][] = [$dataName => $stream];
        return $this;
    }

    /**
     * @param string $url
     * @return ResponseInterface
     * @throws InvalidUrIException
     * @throws RequestException
     * @throws TimeOutException
     */
    public function send(string $url): ResponseInterface
    {
        $urlInfo = $this->initUrl($url);
        if (!$this->client instanceof Client) {
            $this->client = $this->createClient($urlInfo['scheme'], $urlInfo['host']);
        }

        $this->client->setMethod($this->method);
        $this->client->setHeaders(array_merge($this->defaultHeaders, $this->headers));

        if (!is_null($this->timeout)) {
            $this->client->set(['timeout' => $this->timeout]);
        }

        if ($this->client->execute($urlInfo['fullPath'])) {
            return $this->createResponse();
        }

        switch ($this->client->getStatusCode()) {
            case SWOOLE_HTTP_CLIENT_ESTATUS_REQUEST_TIMEOUT:
                throw new TimeOutException("request timeout.");
            case SWOOLE_HTTP_CLIENT_ESTATUS_SERVER_RESET:
                throw new RequestException("request server reset.");
            default:
                throw new RequestException(sprintf(
                    "request fail, errCode: %",
                    $this->client->errCode
                ));
        }
    }

    public function __destruct()
    {
        if ($this->client instanceof Client) {
            $this->client->close();
        }
    }

    /**
     * @param string $scheme
     * @param string $host
     * @return Client
     */
    protected function createClient(string $scheme, string $host): Client
    {
        $isSsl = strtolower($scheme) === 'https';

        $client = new Client($host, $isSsl ? 443 : 80, $isSsl);
        $client->set($this->defaultOptions);
        return $client;
    }

    /**
     * @param string $url
     * @return array
     * @throws InvalidUrIException
     */
    protected function initUrl(string $url): array
    {
        $info = parse_url($url);
        if (empty($info['scheme'])) {
            $info = parse_url('//' . $url);
        }

        if (false === $info) {
            throw new InvalidUrIException("invalid url: {$url}");
        }

        if (empty($info['host']) || !in_array($info['host'], ['http', 'https'])) {
            throw new InvalidUrIException("invalid host: {$url}");
        }

        $info['path'] = empty($info['path']) ? '/' : $info['path'];
        $info['query'] = empty($info['query']) ? '' : '?' . $info['query'];
        $info['fullPath'] = $info['path'] . $info['query'];

        return $info;
    }

    /**
     * @return ResponseInterface
     */
    protected function createResponse(): ResponseInterface
    {
        return new Response(
            $this->client->getStatusCode(),
            $this->client->getHeaders(),
            new SplStream($this->client->getBody())
        );
    }
}