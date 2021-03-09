<?php


namespace EasySwoole\WeChat\MiniProgram;


use EasySwoole\WeChat\Kernel\ServiceContainer;

/**
 * Class Application
 * @package EasySwoole\WeChat\MiniProgram
 * @property Auth\AccessToken $accessToken
 */
class Application extends ServiceContainer
{
    protected $providers = [
        Auth\ServiceProvider::class
    ];
}
