<?php
/**
 * Created by PhpStorm.
 * User: XueSi
 * Email: <1592328848@qq.com>
 * Date: 2021/4/27
 * Time: 1:39
 */

namespace EasySwoole\WeChat\Tests\OfficialAccount;

use EasySwoole\WeChat\OfficialAccount\Application;
use EasySwoole\WeChat\Tests\TestCase;

class ApplicationTest extends TestCase
{
    public function testProperties()
    {
        $app = new Application([
            'appId' => 'mock_appId',
            'appSecret' => 'mock_appSecret'
        ]);

        $this->assertInstanceOf(\EasySwoole\WeChat\OfficialAccount\Auth\AccessToken::class, $app->accessToken);

        $this->assertInstanceOf(\EasySwoole\WeChat\OfficialAccount\AutoReplay\Client::class, $app->autoReplay);

        $this->assertInstanceOf(\EasySwoole\WeChat\OfficialAccount\Base\Client::class, $app->base);

        $this->assertInstanceOf(\EasySwoole\WeChat\OfficialAccount\BroadCasting\Client::class, $app->broadcasting);

        $this->assertInstanceOf(\EasySwoole\WeChat\OfficialAccount\Card\Card::class, $app->card);
        $this->assertInstanceOf(\EasySwoole\WeChat\OfficialAccount\Card\BoardingPassClient::class, $app->card->boardingPass);
        $this->assertInstanceOf(\EasySwoole\WeChat\OfficialAccount\Card\CodeClient::class, $app->card->code);
        $this->assertInstanceOf(\EasySwoole\WeChat\OfficialAccount\Card\CoinClient::class, $app->card->coin);
        $this->assertInstanceOf(\EasySwoole\WeChat\OfficialAccount\Card\GiftCardClient::class, $app->card->giftCard);
        $this->assertInstanceOf(\EasySwoole\WeChat\OfficialAccount\Card\GiftCardOrderClient::class, $app->card->giftCardOrder);
        $this->assertInstanceOf(\EasySwoole\WeChat\OfficialAccount\Card\GiftCardPageClient::class, $app->card->giftCardPage);
        $this->assertInstanceOf(\EasySwoole\WeChat\OfficialAccount\Card\InvoiceClient::class, $app->card->invoice);
        $this->assertInstanceOf(\EasySwoole\WeChat\OfficialAccount\Card\JssdkClient::class, $app->card->jssdk);
        $this->assertInstanceOf(\EasySwoole\WeChat\OfficialAccount\Card\MeetingTicketClient::class, $app->card->meetingTicket);
        $this->assertInstanceOf(\EasySwoole\WeChat\OfficialAccount\Card\MemberCardClient::class, $app->card->memberCard);
        $this->assertInstanceOf(\EasySwoole\WeChat\OfficialAccount\Card\MovieTicketClient::class, $app->card->movieTicket);
        $this->assertInstanceOf(\EasySwoole\WeChat\OfficialAccount\Card\SubMerchantClient::class, $app->card->subMerchant);

        $this->assertInstanceOf(\EasySwoole\WeChat\OfficialAccount\Comment\Client::class, $app->comment);

        $this->assertInstanceOf(\EasySwoole\WeChat\OfficialAccount\CustomerService\Client::class, $app->customerService);

        $this->assertInstanceOf(\EasySwoole\WeChat\OfficialAccount\CustomerService\SessionClient::class, $app->customerServiceSession);

        $this->assertInstanceOf(\EasySwoole\WeChat\OfficialAccount\DataCube\Client::class, $app->dataCube);

        $this->assertInstanceOf(\EasySwoole\WeChat\OfficialAccount\DataCube\PublisherClient::class, $app->dataCubePublisher);

        $this->assertInstanceOf(\EasySwoole\WeChat\OfficialAccount\Device\Client::class, $app->device);

        $this->assertInstanceOf(\EasySwoole\WeChat\OfficialAccount\Goods\Client::class, $app->goods);

        $this->assertInstanceOf(\EasySwoole\WeChat\OfficialAccount\Material\Client::class, $app->material);

        $this->assertInstanceOf(\EasySwoole\WeChat\OfficialAccount\Menu\Client::class, $app->menu);

        $this->assertInstanceOf(\EasySwoole\WeChat\OfficialAccount\Oauth\Client::class, $app->oauth);

        $this->assertInstanceOf(\EasySwoole\WeChat\OfficialAccount\Ocr\Client::class, $app->ocr);

        $this->assertInstanceOf(\EasySwoole\WeChat\OfficialAccount\POI\Client::class, $app->poi);

        $this->assertInstanceOf(\EasySwoole\WeChat\OfficialAccount\Semantic\Client::class, $app->semantic);

        $this->assertInstanceOf(\EasySwoole\WeChat\OfficialAccount\Server\Guard::class, $app->server);

        $this->assertInstanceOf(\EasySwoole\WeChat\OfficialAccount\shakeAround\shakeAround::class, $app->shakeAround);
        $this->assertInstanceOf(\EasySwoole\WeChat\OfficialAccount\shakeAround\DeviceClient::class, $app->shakeAround->device);
        $this->assertInstanceOf(\EasySwoole\WeChat\OfficialAccount\shakeAround\GroupClient::class, $app->shakeAround->group);
        $this->assertInstanceOf(\EasySwoole\WeChat\OfficialAccount\shakeAround\MaterialClient::class, $app->shakeAround->material);
        $this->assertInstanceOf(\EasySwoole\WeChat\OfficialAccount\shakeAround\PageClient::class, $app->shakeAround->page);
        $this->assertInstanceOf(\EasySwoole\WeChat\OfficialAccount\shakeAround\RelationClient::class, $app->shakeAround->relation);
        $this->assertInstanceOf(\EasySwoole\WeChat\OfficialAccount\shakeAround\StatsClient::class, $app->shakeAround->stats);

        $this->assertInstanceOf(\EasySwoole\WeChat\OfficialAccount\Store\Client::class, $app->store);

        $this->assertInstanceOf(\EasySwoole\WeChat\OfficialAccount\TemplateMessage\Client::class, $app->templateMessage);

        $this->assertInstanceOf(\EasySwoole\WeChat\OfficialAccount\User\TagClient::class, $app->userTag);
        $this->assertInstanceOf(\EasySwoole\WeChat\OfficialAccount\User\UserClient::class, $app->user);

        $this->assertInstanceOf(\EasySwoole\WeChat\OfficialAccount\WiFi\CardClient::class, $app->wifiCard);
        $this->assertInstanceOf(\EasySwoole\WeChat\OfficialAccount\WiFi\Client::class, $app->wifi);
        $this->assertInstanceOf(\EasySwoole\WeChat\OfficialAccount\WiFi\DeviceClient::class, $app->wifiDevice);
        $this->assertInstanceOf(\EasySwoole\WeChat\OfficialAccount\WiFi\ShopClient::class, $app->wifiShop);

        // basic service
        $this->assertInstanceOf(\EasySwoole\WeChat\BasicService\Jssdk\Client::class, $app->jssdk);
        $this->assertInstanceOf(\EasySwoole\WeChat\BasicService\QrCode\Client::class, $app->qrcode);
        $this->assertInstanceOf(\EasySwoole\WeChat\BasicService\Media\Client::class, $app->media);
    }
}