<?php

namespace EasySwoole\WeChat\Work\ExternalContact;

use EasySwoole\WeChat\Work\Application;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

/**
 * Class ServiceProvider
 * @package EasySwoole\WeChat\Work\ExternalContact
 * @author: XueSi
 * @email: <1592328848@qq.com>
 */
class ServiceProvider implements ServiceProviderInterface
{
    /**
     * @param Container $app
     */
    public function register(Container $app)
    {
        $app[Application::ExternalContact] = function ($app) {
            return new ExternalContact($app);
        };

        $app[ExternalContact::ContactWay] = function ($app) {
            return new ContactWayClient($app);
        };

        $app[ExternalContact::ExternalContactStatistics] = function ($app) {
            return new StatisticsClient($app);
        };

        $app[ExternalContact::ExternalContactMessage] = function ($app) {
            return new MessageClient($app);
        };

        $app[ExternalContact::School] = function ($app) {
            return new SchoolClient($app);
        };

        $app[ExternalContact::ExternalContactMoment] = function ($app) {
            return new MomentClient($app);
        };

        $app[ExternalContact::ExternalContactMessageTemplate] = function ($app) {
            return new MessageTemplateClient($app);
        };

    }
}
