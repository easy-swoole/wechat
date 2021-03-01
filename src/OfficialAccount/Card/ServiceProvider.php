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

        $app[Card::Coin] = function (ServiceContainer $app) {
            return new CoinClient($app);
        };

        $app[Card::GeneralCard] = function (ServiceContainer $app) {
            return new GeneralCardClient($app);
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

        $app[Card::Jssdk] = function (ServiceContainer $app) {
            return new JssdkClient($app);
        };

        $app[Card::MeetingTicket] = function (ServiceContainer $app) {
            return new MeetingTicketClient($app);
        };

        $app[Card::MemberCard] = function (ServiceContainer $app) {
            return new MemberCardClient($app);
        };

        $app[Card::MovieTicket] = function (ServiceContainer $app) {
            return new MovieTicketClient($app);
        };

        $app[Card::SubMerchant] = function (ServiceContainer $app) {
            return new SubMerchantClient($app);
        };
    }
}