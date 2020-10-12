<?php


namespace EasySwoole\WeChat\OfficialAccount;


use EasySwoole\WeChat\Kernel\ServiceContainer;
use EasySwoole\WeChat\OfficialAccount\Server\Guard;

/**
 * Class Application
 *
 * @package EasySwoole\WeChat\OfficialAccount
 * @property Guard  $server
 */
class Application extends ServiceContainer
{
    const BASE = 'base';

    protected $providers = [
        Server\ServiceProvider::class
    ];
}