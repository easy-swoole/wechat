<?php

namespace EasySwoole\WeChat\MiniProgram;


use EasySwoole\WeChat\Kernel\ServiceContainer;
use EasySwoole\WeChat\OfficialAccount\OCR;
use EasySwoole\WeChat\OfficialAccount\Server;

/**
 * Class Application
 * @package EasySwoole\WeChat\MiniProgram
 * @property Auth\AccessToken $accessToken
 * @property Auth\Client $auth
 * @property AppCode\Client $appCode
 * @property UrlScheme\Client $urlScheme
 * @property Live\Client $live
 * @property DataCube\Client $dataCube
 * @property Express\Client $express
 * @property OpenData\Client $openData
 * @property OCR\Client $ocr
 * @property Search\Client $search
 * @property Soter\Client $soter
 * @property TemplateMessage\Client $templateMessage
 * @property Server\Guard $server
 * @property ActivityMessage\Client $activityMessage
 * @property Broadcast\Client $broadcast
 * @property Mall\Mall $mall
 * @property NearbyPoi\Client $nearbyPoi
 * @property RealtimeLog\Client $realtimeLog
 * @property RiskControl\Client $riskControl
 * @property SubscribeMessage\Client $subscribeMessage
 * @property UniformMessage\Client $uniformMessage
 * @property Base\Client $base
 */
class Application extends ServiceContainer
{
    const Auth = 'auth';
    const AppCode = 'appCode';
    const UrlScheme = 'urlScheme';
    const Live = "live";
    const DataCube = "dataCube";
    const Express = "express";
    const OpenData = "openData";
    const Plugin = "plugin";
    const PluginDev = "pluginDev";
    const OCR = "ocr";
    const Search = "search";
    const Soter = "soter";
    const TemplateMessage = "templateMessage";
    const Server = 'server';
    const ActivityMessage = 'activityMessage';
    const Broadcast = 'broadcast';
    const CustomerService = 'customerService';
    const Mall = 'mall';
    const NearbyPoi = 'nearbyPoi';
    const RealtimeLog = 'realtimeLog';
    const RiskControl = 'riskControl';
    const SubscribeMessage = 'subscribeMessage';
    const UniformMessage = 'uniformMessage';
    const Base = 'base';


    protected $providers = [
        Auth\ServiceProvider::class,
        AppCode\ServiceProvider::class,
        UrlScheme\ServiceProvider::class,
        Live\ServiceProvider::class,
        DataCube\ServiceProvider::class,
        Express\ServiceProvider::class,
        OpenData\ServiceProvider::class,
        Plugin\ServiceProvider::class,
        OCR\ServiceProvider::class,
        Search\ServiceProvider::class,
        Soter\ServiceProvider::class,
        TemplateMessage\ServiceProvider::class,
        Server\ServiceProvider::class,
        ActivityMessage\ServiceProvider::class,
        Broadcast\ServiceProvider::class,
        CustomerService\ServiceProvider::class,
        Mall\ServiceProvider::class,
        NearbyPoi\ServiceProvider::class,
        RealtimeLog\ServiceProvider::class,
        RiskControl\ServiceProvider::class,
        SubscribeMessage\ServiceProvider::class,
        UniformMessage\ServiceProvider::class,
        Base\ServiceProvider::class,
    ];
}
