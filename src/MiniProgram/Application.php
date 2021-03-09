<?php


namespace EasySwoole\WeChat\MiniProgram;


use EasySwoole\WeChat\Kernel\ServiceContainer;

/**
 * Class Application
 * @package EasySwoole\WeChat\MiniProgram
 * @property Auth\AccessToken $accessToken
 * @property Auth\Client $auth
 * @property AppCode\Client $appCode
 * @property UrlScheme\Client $urlScheme
 */
class Application extends ServiceContainer
{
    const Auth = 'auth';
    const AppCode = 'appCode';
    const UrlScheme = 'urlScheme';

    protected $providers = [
        Auth\ServiceProvider::class,
        AppCode\ServiceProvider::class,
        UrlScheme\ServiceProvider::class
    ];
}
