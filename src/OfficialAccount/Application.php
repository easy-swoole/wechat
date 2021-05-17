<?php

namespace EasySwoole\WeChat\OfficialAccount;

use EasySwoole\WeChat\BasicService;
use EasySwoole\WeChat\Kernel\ServiceContainer;

/**
 * Class ServiceProvider
 * @package EasySwoole\WeChat\OfficialAccount
 *
 * @property Auth\AccessToken $accessToken
 * @property AutoReplay\Client $autoReplay
 * @property Base\Client $base
 * @property Broadcasting\Client $broadcasting
 * @property Card\Card $card
 * @property Comment\Client $comment
 * @property CustomerService\Client $customerService
 * @property CustomerService\SessionClient $customerServiceSession
 * @property DataCube\Client $dataCube
 * @property DataCube\PublisherClient $dataCubePublisher
 * @property Device\Client $device
 * @property Goods\Client $goods
 * @property Material\Client $material
 * @property Menu\Client $menu
 * @property OAuth\Client $oauth
 * @property OCR\Client $ocr
 * @property POI\Client $poi
 * @property Semantic\Client $semantic
 * @property Server\Guard $server
 * @property ShakeAround\ShakeAround $shakeAround
 * @property Store\Client $store
 * @property TemplateMessage\Client $templateMessage
 * @property User\UserClient $user
 * @property User\TagClient $userTag
 * @property WiFi\CardClient $wifiCard
 * @property Wifi\Client $wifi
 * @property WiFi\DeviceClient $wifiDevice
 * @property WiFi\ShopClient $wifiShop
 *
 * @property BasicService\Jssdk\Client $jssdk
 * @property BasicService\QrCode\Client $qrcode
 * @property BasicService\Media\Client $media
 */
class Application extends ServiceContainer
{
    const AutoReplay = 'autoReplay';
    const Base = 'base';
    const Broadcasting = 'broadcasting';
    const Card = 'card';
    const Comment = 'comment';
    const CustomerService = 'customerService';
    const CustomerServiceSession = 'customerServiceSession';
    const DataCube = 'dataCube';
    const DataCubePublisher = 'dataCubePublisher';
    const Device = 'device';
    const Goods = 'goods';
    const Material = 'material';
    const Menu = 'menu';
    const OAuth = 'oauth';
    const Ocr = 'ocr';
    const Poi = 'poi';
    const Semantic = 'semantic';
    const Server = 'server';
    const ShakeAround = 'shakeAround';
    const Store = 'store';
    const TemplateMessage = 'templateMessage';
    const User = 'user';
    const UserTag = 'userTag';
    const WifiCard = 'wifiCard';
    const Wifi = 'wifi';
    const WifiDevice = 'wifiDevice';
    const WifiShop = 'wifiShop';

    protected $providers = [
        Auth\ServiceProvider::class,
        AutoReplay\ServiceProvider::class,
        Base\ServiceProvider::class,
        Broadcasting\ServiceProvider::class,
        Card\ServiceProvider::class,
        Comment\ServiceProvider::class,
        CustomerService\ServiceProvider::class,
        DataCube\ServiceProvider::class,
        Device\ServiceProvider::class,
        Goods\ServiceProvider::class,
        Material\ServiceProvider::class,
        Menu\ServiceProvider::class,
        OAuth\ServiceProvider::class,
        OCR\ServiceProvider::class,
        POI\ServiceProvider::class,
        Semantic\ServiceProvider::class,
        Server\ServiceProvider::class,
        ShakeAround\ServiceProvider::class,
        Store\ServiceProvider::class,
        TemplateMessage\ServiceProvider::class,
        User\ServiceProvider::class,
        WiFi\ServiceProvider::class,

        // Basic Service
        BasicService\Media\ServiceProvider::class,
        BasicService\Jssdk\ServiceProvider::class,
        BasicService\QrCode\ServiceProvider::class
    ];
}
