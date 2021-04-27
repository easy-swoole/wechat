<?php

namespace EasySwoole\WeChat\Work\User;

use EasySwoole\WeChat\Work\Application;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

/**
 * Class ServiceProvider
 * @package EasySwoole\WeChat\Work\User
 * @author: XueSi
 * @email: <1592328848@qq.com>
 */
class ServiceProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        $app[Application::User] = function ($app) {
            return new User($app);
        };

        $app[User::Tag] = function ($app) {
            return new TagClient($app);
        };

        $app[User::LinkedCorp] = function ($app) {
            return new LinkedCorpClient($app);
        };

        $app[User::BatchJobs] = function ($app) {
            return new BatchJobsClient($app);
        };
    }
}
