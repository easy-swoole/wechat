<?php

namespace EasySwoole\WeChat\Work\MiniProgram;

use EasySwoole\WeChat\Kernel\ServiceProviders;
use EasySwoole\WeChat\MiniProgram\Application as MiniProgramApplication;
use EasySwoole\WeChat\Work\Auth\AccessToken;
use EasySwoole\WeChat\Work\MiniProgram\Auth\Client;

/**
 * Class Application
 * @package EasySwoole\WeChat\Work\MiniProgram
 * @author: XueSi
 * @email: <1592328848@qq.com>
 *
 * @property Auth\Client $auth
 */
class Application extends MiniProgramApplication
{
    const Auth = 'auth';

    /**
     * Application constructor.
     * @param array $config
     * @param array $prepends
     */
    public function __construct(array $config = [], array $prepends = [])
    {
        parent::__construct($config, null, $prepends + [
                ServiceProviders::AccessToken => function ($app) {
                    return new AccessToken($app);
                },
                self::Auth => function ($app) {
                    return new Client($app);
                },
            ]);
    }
}