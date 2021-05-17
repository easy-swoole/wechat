<?php
/**
 * Created by PhpStorm.
 * User: XueSi
 * Email: <1592328848@qq.com>
 * Date: 2021/5/18
 * Time: 0:27
 */

namespace EasySwoole\WeChat\Tests\OfficialAccount\Card;

use EasySwoole\WeChat\OfficialAccount\Application;
use EasySwoole\WeChat\OfficialAccount\Card\BoardingPassClient;
use EasySwoole\WeChat\OfficialAccount\Card\Card;
use EasySwoole\WeChat\OfficialAccount\Card\Client;
use EasySwoole\WeChat\OfficialAccount\Card\CodeClient;
use EasySwoole\WeChat\OfficialAccount\Card\CoinClient;
use EasySwoole\WeChat\OfficialAccount\Card\GeneralCardClient;
use EasySwoole\WeChat\OfficialAccount\Card\GiftCardClient;
use EasySwoole\WeChat\OfficialAccount\Card\GiftCardOrderClient;
use EasySwoole\WeChat\OfficialAccount\Card\GiftCardPageClient;
use EasySwoole\WeChat\OfficialAccount\Card\InvoiceClient;
use EasySwoole\WeChat\OfficialAccount\Card\JssdkClient;
use EasySwoole\WeChat\OfficialAccount\Card\MeetingTicketClient;
use EasySwoole\WeChat\OfficialAccount\Card\MemberCardClient;
use EasySwoole\WeChat\OfficialAccount\Card\MovieTicketClient;
use EasySwoole\WeChat\OfficialAccount\Card\SubMerchantClient;
use EasySwoole\WeChat\Tests\TestCase;

class CardTest extends TestCase
{
    public function testBasicProperties()
    {
        $app = new Application([
            'appId' => 'mock_appId',
            'appSecret' => 'mock_appSecret'
        ]);

        $card = new Card($app);

        $this->assertInstanceOf(Client::class, $card);

        $this->assertInstanceOf(BoardingPassClient::class, $card->boardingPass);

        $this->assertInstanceOf(CodeClient::class, $card->code);

        $this->assertInstanceOf(CoinClient::class, $card->coin);

//        $this->assertInstanceOf(GeneralCardClient::class, $card->generalCard);

        $this->assertInstanceOf(GiftCardClient::class, $card->giftCard);

        $this->assertInstanceOf(GiftCardOrderClient::class, $card->giftCardOrder);

        $this->assertInstanceOf(GiftCardPageClient::class, $card->giftCardPage);

        $this->assertInstanceOf(InvoiceClient::class, $card->invoice);

        $this->assertInstanceOf(JssdkClient::class, $card->jssdk);

        $this->assertInstanceOf(MeetingTicketClient::class, $card->meetingTicket);

        $this->assertInstanceOf(MemberCardClient::class, $card->memberCard);

        $this->assertInstanceOf(MovieTicketClient::class, $card->movieTicket);

        $this->assertInstanceOf(SubMerchantClient::class, $card->subMerchant);

        try {
            $card->foo;
            $this->fail('No expected exception thrown.');
        } catch (\Exception $e) {
            $this->assertSame('No card service named "foo".', $e->getMessage());
        }
    }
}