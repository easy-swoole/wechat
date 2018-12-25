<?php
/**
 * Created by PhpStorm.
 * User: yf
 * Date: 2018/12/24
 * Time: 9:29 PM
 */

namespace EasySwoole\WeChat\Utility;


use Swoole\Coroutine\Http\Client;

class HttpClient
{

    const HEADER = [
        "User-Agent" => 'EasySwooleHttpClient/0.1',
        'Accept' => 'text/html,application/xhtml+xml,application/xml',
        'Accept-Encoding' => 'gzip',
        'Pragma' => 'no-cache',
        'Cache-Control' => 'no-cache'
    ];

    public function get($url, $timeout = 0.1): string
    {
        $req = $this->createGoRequest($url, $timeout);
        $req['cli']->get($this->getUri($req['urlInfo']['path'], $req['urlInfo']['query']));
        $body = $req['cli']->body;
        $req['cli']->close();
        return $body;
    }

    public function post($url, $data, $timeout = 0.1, array $header = []): string
    {
        $req = $this->createGoRequest($url, $timeout, $header);
        $req['cli']->post($this->getUri($req['urlInfo']['path'], $req['urlInfo']['query']), $data);
        $body = $req['cli']->body;
        $req['cli']->close();
        return $body;
    }

    public function postXML($url, string $xml, $timeout = 0.1)
    {
        return $this->post($url, $xml, $timeout, [
            'Content-Type' => 'text/xml',
        ]);
    }

    public function postJSON($url, string $json, $timeout = 0.1)
    {
        return $this->post($url, $json, $timeout, [
            'Content-Type' => 'text/json'
        ]);
    }

    private function createGoRequest(string $url, int $timeout, array $header = []): array
    {
        $urlInfo = $this->getUrlInfo($url);
        $cli = new Client($urlInfo['host'], $urlInfo['port'], $urlInfo['scheme'] == 'http' ? false : true);
        $cli->set(['timeout' => $timeout]);
        $cli->setHeaders(array_merge($header, self::HEADER));
        return [
            'cli' => $cli,
            'urlInfo' => $urlInfo
        ];
    }

    private function getUri(string $path, string $query): string
    {
        return !empty($query) ? $path . '?' . $query : $path;
    }

    /**
     * 获取url信息
     * @param string $url
     * @return array
     * @throws \Exception
     */
    private function getUrlInfo(string $url): array
    {
        $urlInfo = parse_url($url);
        if ($urlInfo === false) {
            throw new \Exception('Invalid url');
        } else {
            return [
                'host' => $urlInfo['host'],
                'port' => $urlInfo['port'] ?? $urlInfo['scheme'] == 'http' ? 80 : 443,
                'scheme' => $urlInfo['scheme'],
                'path' => $urlInfo['path'] ?? '/',
                'query' => $urlInfo['query'] ?? '',
                'fragment' => $urlInfo['fragment'] ?? ''
            ];
        }
    }

}