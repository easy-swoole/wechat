<?php


namespace EasySwoole\WeChat\MiniProgram;


use EasySwoole\WeChat\Kernel\ServiceContainer;

/**
 * Class Application
 * @package EasySwoole\WeChat\MiniProgram
 * @property Auth\AccessToken $accessToken
 * @property Auth\Client $auth
 */
class Application extends ServiceContainer
{
    const Auth = 'auth';

    protected $providers = [
        Auth\ServiceProvider::class
    ];
}
