<?php


namespace EasySwoole\WeChat\OfficialAccount;


use EasySwoole\WeChat\Kernel\ServiceContainer;
use EasySwoole\WeChat\OfficialAccount\Auth\AccessToken;
use EasySwoole\WeChat\OfficialAccount\Base\Client;
use EasySwoole\WeChat\OfficialAccount\Server\Guard;

/**
 * Class ServiceProvider
 *
 * @package EasySwoole\WeChat\OfficialAccount
 * @property AccessToken $accessToken
 * @property Client  $base
 * @property Guard  $server
 */
class Application extends ServiceContainer
{
    const Base = 'base';
    const Server = 'server';

    protected $providers = [
        Auth\ServiceProvider::class,
        Base\ServiceProvider::class,
        Server\ServiceProvider::class
    ];
}