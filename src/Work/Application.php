<?php


namespace EasySwoole\WeChat\Work;


use EasySwoole\WeChat\Kernel\ServiceContainer;

/**
 * Class ServiceProvider
 *
 * @package EasySwoole\WeChat\Work
 * @property Auth\AccessToken $accessToken
 */
class Application extends ServiceContainer
{
    const Agent = 'Agent';

    /**
     * @var string[]
     */
    protected $providers = [
        Auth\AccessToken::class
    ];
}