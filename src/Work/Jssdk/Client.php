<?php

namespace EasySwoole\WeChat\Work\Jssdk;

use EasySwoole\WeChat\Kernel\Cache\FileCacheDriver;
use EasySwoole\WeChat\Kernel\Exceptions\RuntimeException;
use EasySwoole\WeChat\Kernel\ServiceProviders;
use EasySwoole\WeChat\Kernel\Utility\Random;
use EasySwoole\WeChat\BasicService\Jssdk\Client as Jssdk;
/**
 * Class Client
 * @package EasySwoole\WeChat\Work\Jssdk
 * @author: XueSi
 * @email: <1592328848@qq.com>
 */
class Client extends Jssdk
{
    /** @var string */
    protected $cachePrefix = 'easyswoole_wechat_js_ticket_';

    /**
     * @return string
     */
    protected function getEndpoint(string $path, array $query): string
    {
        return 'https://qyapi.weixin.qq.com' . $path . '?' . http_build_query($query);
    }

    /**
     * @return string
     */
    protected function getAppId()
    {
        return $this->app[ServiceProviders::Config]->get('corpId');
    }

    /**
     * @param $agentId
     * @param string|null $url
     * @param string|null $nonce
     * @param null $timestamp
     * @return array
     */
    protected function agentConfigSignature($agentId, string $url = null, string $nonce = null, $timestamp = null): array
    {
        $nonce = $nonce ?: Random::character(10);
        $timestamp = $timestamp ?: time();

        return [
            'corpid' => $this->getAppId(),
            'agentid' => $agentId,
            'nonceStr' => $nonce,
            'timestamp' => $timestamp,
            'url' => $url,
            'signature' => $this->getTicketSignature($this->getAgentTicket($agentId)['ticket'], $nonce, $timestamp, $url),
        ];
    }

    /**
     * 获取企业的jsapi_ticket
     * doc link: https://work.weixin.qq.com/api/doc/90000/90136/90506#获取企业的jsapi_ticket
     *
     * @param bool $refresh
     * @param string $type
     * @return array
     * @throws RuntimeException
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function getTicket(bool $refresh = false, string $type = 'config'): array
    {
        $cacheKey = sprintf($this->cachePrefix . '%s_%s', $type, $this->getAppId());

        /** @var FileCacheDriver $cache */
        $cache = $this->app[ServiceProviders::Cache];

        if (!$refresh && $cache->has($cacheKey)) {
            return $cache->get($cacheKey);
        }

        $response = $this->getClient()
            ->setMethod('GET')
            ->send($this->getEndpoint('/cgi-bin/get_jsapi_ticket', [
                'access_token' => $this->app[ServiceProviders::AccessToken]->getToken()
            ]));

        $this->checkResponse($response, $result);

        $cache->set($cacheKey, $result, $result['expires_in'] - 500);

        if (!$cache->has($cacheKey)) {
            throw new RuntimeException('Failed to cache jssdk ticket.');
        }

        return $result;
    }

    /**
     * 获取应用的jsapi_ticket
     * doc link: https://work.weixin.qq.com/api/doc/90000/90136/90506#获取应用的jsapi_ticket
     *
     * @param $agentId
     * @param bool $refresh
     * @param string $type
     * @return mixed|null
     * @throws RuntimeException
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function getAgentTicket($agentId, bool $refresh = false, string $type = 'agent_config')
    {
        $cacheKey = sprintf($this->cachePrefix . '%s_%s_%s', $agentId, $type, $this->getAppId());

        /** @var FileCacheDriver $cache */
        $cache = $this->app[ServiceProviders::Cache];

        if (!$refresh && $cache->has($cacheKey)) {
            return $cache->get($cacheKey);
        }

        $response = $this->getClient()
            ->setMethod('GET')
            ->send($this->getEndpoint('/cgi-bin/ticket/get', [
                'type' => $type,
                'access_token' => $this->app[ServiceProviders::AccessToken]->getToken()
            ]));

        $this->checkResponse($response, $result);

        $cache->set($cacheKey, $result, $result['expires_in'] - 500);

        if (!$cache->has($cacheKey)) {
            throw new RuntimeException('Failed to cache jssdk ticket.');
        }

        return $result;
    }
}