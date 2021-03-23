<?php


namespace EasySwoole\WeChat\BasicService\Jssdk;


use EasySwoole\WeChat\BasicService\Application;
use EasySwoole\WeChat\Kernel\BaseClient;
use EasySwoole\WeChat\Kernel\ServiceProviders;
use EasySwoole\WeChat\Kernel\Utility\Random;

class Client extends BaseClient
{
    /**
     * @param string $url
     * @param array $apis
     * @param bool $debug
     * @param bool $beta
     * @param array $openTagList
     * @return string
     */
    public function buildConfig(string $url, array $apis, bool $debug = false, bool $beta = false, array $openTagList = []): string
    {
        return json_encode($this->getConfigArray($url, $apis, $debug, $beta, $openTagList));
    }

    /**
     * @param string $url
     * @param array $apis
     * @param bool $debug
     * @param bool $beta
     * @param array $openTagList
     * @return array
     */
    public function getConfigArray(string $url, array $apis, bool $debug = false, bool $beta = false, array $openTagList = []): array
    {
        return array_merge(
            [
                'debug' => $debug,
                'beta' => $beta,
                'jsApiList' => $apis,
                'openTagList' => $openTagList
            ],
            $this->configSignature($url)
        );
    }

    /**
     * @param $ticket
     * @param $nonce
     * @param $timestamp
     * @param $url
     * @return string
     */
    public function getTicketSignature($ticket, $nonce, $timestamp, $url): string
    {
        return sha1("jsapi_ticket={$ticket}&noncestr={$nonce}&timestamp={$timestamp}&url={$url}");
    }

    /**
     * @param bool $autoRefresh
     * @return string
     */
    public function getTicket(bool $autoRefresh = true): string
    {
        return $this->app[Application::Ticket]->getToken($autoRefresh);
    }

    /**
     * @param mixed ...$params
     * @return string
     */
    public function dictionaryOrderSignature(...$params)
    {
        sort($params, SORT_STRING);

        return sha1(implode('', $params));
    }

    /**
     * @param string|null $url
     * @param string|null $nonce
     * @param null $timestamp
     * @return array
     */
    public function configSignature(string $url = null, string $nonce = null, $timestamp = null): array
    {
        $nonce = $nonce ?? Random::character(16);
        $timestamp = $timestamp ?? time();
        return [
            'appId' => $this->app[ServiceProviders::Config]->get('appId'),
            'nonceStr' => $nonce,
            'timestamp' => $timestamp,
            'url' => $url,
            'signature' => $this->getTicketSignature($this->getTicket(), $nonce, $timestamp, $url),
        ];
    }
}
