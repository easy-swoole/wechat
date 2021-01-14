<?php


namespace EasySwoole\WeChat\Kernel\HttpClient;


use EasySwoole\WeChat\Kernel\Contracts\ClientInterface;
use EasySwoole\WeChat\Kernel\HttpClient\Exception\InvalidUrIException;
use EasySwoole\WeChat\Kernel\HttpClient\Exception\RequestException;
use EasySwoole\WeChat\Kernel\HttpClient\Exception\TimeOutException;
use EasySwoole\WeChat\Kernel\Psr\Response;
use EasySwoole\WeChat\Kernel\Psr\Stream;
use Psr\Http\Message\ResponseInterface;
use Psr\Http\Message\StreamInterface;
use Swoole\Coroutine\Http\Client;

class SwooleClientDriver implements ClientInterface
{
    /** @var string[] */
    protected $defaultOptions = [
        "timeout" => 5.0
    ];

    /** @var string[] */
    protected $defaultHeaders = [
        "user-agent" => 'EasySwoole-wechat/2.x',
        'accept' => '*/*'
    ];

    /** @var float|null */
    protected $timeout;
    /** @var array */
    protected $headers = [];
    /** @var string|null */
    protected $method;
    /** @var StreamInterface|null */
    protected $body;

    /** @var array[] */
    protected $formData = [

    ];

    /** @var array[] */
    protected $uploadFiles = [
        'files' => [],
        'streams' => []
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
        $this->uploadFiles['files'][$dataName] = $path;
        return $this;
    }

    public function addData(string $data, string $dataName): ClientInterface
    {
        $this->formData[$dataName] = $data;
        return $this;
    }

    public function addStream(StreamInterface $stream, string $dataName): ClientInterface
    {
        $this->uploadFiles['streams'][$dataName] = $stream;
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
        $client = $this->createClient($urlInfo['scheme'], $urlInfo['host'], $urlInfo['port'] ?? null);

        $client->setMethod($this->method);
        $client->setHeaders(array_merge($this->defaultHeaders, $this->headers));

        if (!is_null($this->timeout)) {
            $client->set(['timeout' => $this->timeout]);
        }

        if (!is_null($this->body)) {
            $client->setData($this->body->__toString());
        }

        if (!empty($this->formData)) {
            $client->setData($this->formData);
        }

        foreach ($this->uploadFiles as $type => $files) {
            foreach ($files as $name => $file) {
                if ($type === 'files') {
                    $client->addFile($file, $name);
                } else {
                    $client->addData($file->__toString(), $name);
                }
            }
        }

        $flag = $client->execute($urlInfo['fullPath']);
        $client->close();
        $this->reset();

        if ($flag) {
            return $this->createResponse($client);
        }

        switch ($client->getStatusCode()) {
            case SWOOLE_HTTP_CLIENT_ESTATUS_REQUEST_TIMEOUT:
                throw new TimeOutException("request timeout.");
            case SWOOLE_HTTP_CLIENT_ESTATUS_SERVER_RESET:
                throw new RequestException("request server reset.");
            default:
                throw new RequestException('request fail, errCode: ' . $client->errCode);
        }
    }

    /**
     * @param string $scheme
     * @param string $host
     * @param int|null $port
     * @return Client
     */
    protected function createClient(string $scheme, string $host, ?int $port = null): Client
    {
        $isSsl = strtolower($scheme) === 'https';
        $port = $port ?? ($isSsl ? 443 : 80);

        $client = new Client($host, $port, $isSsl);
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
            $info = parse_url('http://' . $url);
        }

        if (false === $info) {
            throw new InvalidUrIException("invalid url: {$url}");
        }

        if (empty($info['scheme']) || !in_array($info['scheme'], ['http', 'https'])) {
            throw new InvalidUrIException("invalid scheme: {$url}");
        }

        $info['path'] = empty($info['path']) ? '/' : $info['path'];
        $info['query'] = empty($info['query']) ? '' : '?' . $info['query'];
        $info['fullPath'] = $info['path'] . $info['query'];

        return $info;
    }

    /**
     * @param Client $client
     * @return ResponseInterface
     */
    protected function createResponse(Client $client): ResponseInterface
    {
        return new Response(
            $client->getStatusCode(),
            $client->getHeaders(),
            new Stream($client->getBody())
        );
    }

    protected function reset()
    {
        $this->headers = [];
        $this->timeout = null;
        $this->method = null;
        $this->body = null;
        $this->uploadFiles = [
            'file' => [],
            'stream' => []
        ];
    }
}