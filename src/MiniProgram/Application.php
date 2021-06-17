<?php

namespace EasySwoole\WeChat\MiniProgram;


use EasySwoole\WeChat\Kernel\ServiceContainer;
use EasySwoole\WeChat\OfficialAccount\CustomerService;
use EasySwoole\WeChat\OfficialAccount\OCR;
use EasySwoole\WeChat\OfficialAccount\Server;

/**
 * Class Application
 * @package EasySwoole\WeChat\MiniProgram
 * @property ActivityMessage\Client $activityMessage
 * @property AppCode\Client $appCode
 * @property Auth\AccessToken $accessToken
 * @property Auth\Client $auth
 * @property Base\Client $base
 * @property Broadcast\Client $broadcast
 * @property CustomerService\Client $customerService
 * @property DataCube\Client $dataCube
 * @property Express\Client $express
 * @property Live\Client $live
 * @property Mall\ForwardsMall $mall
 * @property NearbyPoi\Client $nearbyPoi
 * @property OCR\Client $ocr
 * @property OpenData\Client $openData
 * @property Plugin\Client $plugin
 * @property Plugin\DevClient $pluginDev
 * @property RealtimeLog\Client $realtimeLog
 * @property RiskControl\Client $riskControl
 * @property Search\Client $search
 * @property Server\Guard $server
 * @property Soter\Client $soter
 * @property SubscribeMessage\Client $subscribeMessage
 * @property TemplateMessage\Client $templateMessage
 * @property UniformMessage\Client $uniformMessage
 * @property Union\Client $union
 * @property UrlLink\Client $urlLink
 * @property UrlScheme\Client $urlScheme
 */
class Application extends ServiceContainer
{
    const ActivityMessage = 'activityMessage';
    const AppCode = 'appCode';
    const Auth = 'auth';
    const Base = 'base';
    const Broadcast = 'broadcast';
    const CustomerService = 'customerService';
    const DataCube = "dataCube";
    const Express = "express";
    const Live = "live";
    const Mall = 'mall';
    const NearbyPoi = 'nearbyPoi';
    const OCR = "ocr";
    const OpenData = "openData";
    const Plugin = "plugin";
    const PluginDev = "pluginDev";
    const RealtimeLog = 'realtimeLog';
    const RiskControl = 'riskControl';
    const Search = "search";
    const Server = 'server';
    const Soter = "soter";
    const SubscribeMessage = 'subscribeMessage';
    const TemplateMessage = "templateMessage";
    const UniformMessage = 'uniformMessage';
    const Union = 'union';
    const UrlLink = 'urlLink';
    const UrlScheme = 'urlScheme';

    protected $providers = [
        ActivityMessage\ServiceProvider::class,
        AppCode\ServiceProvider::class,
        Auth\ServiceProvider::class,
        Base\ServiceProvider::class,
        Broadcast\ServiceProvider::class,
        CustomerService\ServiceProvider::class,
        DataCube\ServiceProvider::class,
        Express\ServiceProvider::class,
        Live\ServiceProvider::class,
        Mall\ServiceProvider::class,
        NearbyPoi\ServiceProvider::class,
        OCR\ServiceProvider::class,
        OpenData\ServiceProvider::class,
        Plugin\ServiceProvider::class,
        RealtimeLog\ServiceProvider::class,
        RiskControl\ServiceProvider::class,
        Search\ServiceProvider::class,
        Server\ServiceProvider::class,
        Soter\ServiceProvider::class,
        SubscribeMessage\ServiceProvider::class,
        TemplateMessage\ServiceProvider::class,
        UniformMessage\ServiceProvider::class,
        Union\ServiceProvider::class,
        UrlLink\ServiceProvider::class,
        UrlScheme\ServiceProvider::class,
    ];

    /**
     * Handle dynamic calls.
     *
     * @param string $method
     * @param array  $args
     *
     * @return mixed
     */
    public function __call($method, $args)
    {
        return $this->base->$method(...$args);
    }
}
