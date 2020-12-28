<?php


namespace EasySwoole\WeChat\OfficialAccount\Card;


use EasySwoole\WeChat\Kernel\ServiceContainer;
use EasySwoole\WeChat\OfficialAccount\Application;
use Pimple\Container;
use Pimple\ServiceProviderInterface;

class ServiceProvider implements ServiceProviderInterface
{
    public function register(Container $app)
    {
        $app[Application::Card] = function (ServiceContainer $app) {
            return new Card($app);
        };

        $app[Card::BoardingPass] = function (ServiceContainer $app) {
            return new BoardingPassClient($app);
        };

        $app[Card::Code] = function (ServiceContainer $app) {
            return new CodeClient($app);
        };

        $app[Card::GiftCard] = function (ServiceContainer $app) {
            return new GiftCardClient($app);
        };

        $app[Card::GiftCardOrder] = function (ServiceContainer $app) {
            return new GiftCardOrderClient($app);
        };

        $app[Card::GiftCardPage] = function (ServiceContainer $app) {
            return new GiftCardPageClient($app);
        };

        $app[Card::Invoice] = function (ServiceContainer $app) {
            return new InvoiceClient($app);
        };
    }
}