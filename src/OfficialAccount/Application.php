<?php


namespace EasySwoole\WeChat\OfficialAccount;


use EasySwoole\WeChat\Kernel\ServiceContainer;
use EasySwoole\WeChat\OfficialAccount\Server\Guard;

/**
 * Class ServiceProvider
 *
 * @package EasySwoole\WeChat\OfficialAccount
 * @property Guard  $server
 */
class Application extends ServiceContainer
{
    const Base = 'base';
    const Server = 'server';

    protected $providers = [
        Base\ServiceProvider::class,
        Server\ServiceProvider::class
    ];
}