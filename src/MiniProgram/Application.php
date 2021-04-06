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
 * @property TemplateMessage\Client $templateMessage
 * @property Server\Guard $server
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
        Server\ServiceProvider::class
    ];
}
