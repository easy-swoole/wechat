<?php


namespace EasySwoole\WeChat\OfficialAccount;


use EasySwoole\WeChat\BasicService;
use EasySwoole\WeChat\Kernel\ServiceContainer;

/**
 * Class ServiceProvider
 *
 * @package EasySwoole\WeChat\OfficialAccount
 * @property Auth\AccessToken $accessToken
 * @property JsSdk\JsSdk $jsSdk
 * @property AutoReplay\Client $autoReplay
 * @property Comment\Client $comment
 * @property Card\Card $card
 * @property Device\Client $device
 * @property Base\Client $base
 * @property Server\Guard $server
 * @property Wifi\Client $wifi
 * @property WiFi\CardClient $wifiCard
 * @property WiFi\DeviceClient $wifiDevice
 * @property WiFi\ShopClient $wifiShop
 * @property User\UserClient $user
 * @property User\TagClient $userTag
 * @property TemplateMessage\Client $templateMessage
 * @property Store\Client $store
 * @property ShakeAround\ShakeAround $shakeAround
 * @property BasicService\Media\Client $media
 * @property Material\Client $material
 * @property Menu\Client $menu
 * @property Semantic\Client $semantic
 * @property POI\Client $poi
 * @property Goods\Client $goods
 * @property DataCube\Client $dateCube
 * @property DataCube\PublisherClient $dataCubePublisher
 * @property OCR\Client $ocr
 * @property CustomerService\Client $customerService
 * @property CustomerService\SessionClient $customerServiceSession
 */
class Application extends ServiceContainer
{
    const Base = 'base';
    const Server = 'server';
    const AutoReplay = 'autoReplay';
    const Broadcasting = 'broadcasting';
    const Card = 'card';
    const Comment = 'comment';
    const Device = 'device';
    const Wifi = 'wifi';
    const WifiCard = 'wifiCard';
    const WifiDevice = 'wifiDevice';
    const WifiShop = 'wifShop';
    const User = 'user';
    const UserTag = 'userTag';
    const TemplateMessage = 'templateMessage';
    const Store = 'store';
    const ShakeAround = 'shakeAround';
    const Material = 'material';
    const Menu = 'menu';
    const Semantic = 'semantic';
    const Poi = 'poi';
    const Goods = 'goods';
    const DataCube = 'dataCube';
    const DataCubePublisher = 'dataCubePublisher';
    const Ocr = 'ocr';
    const CustomerService = 'customerService';
    const CustomerServiceSession = 'customerServiceSession';


    protected $providers = [
        Auth\ServiceProvider::class,
        AutoReplay\ServiceProvider::class,
        Broadcasting\ServiceProvider::class,
        Base\ServiceProvider::class,
        Comment\ServiceProvider::class,
        Card\ServiceProvider::class,
        Device\ServiceProvider::class,
        JsSdk\ServiceProvider::class,
        Server\ServiceProvider::class,
        WiFi\ServiceProvider::class,
        User\ServiceProvider::class,
        TemplateMessage\ServiceProvider::class,
        Store\ServiceProvider::class,
        ShakeAround\ServiceProvider::class,
        Material\ServiceProvider::class,
        Menu\ServiceProvider::class,
        Semantic\ServiceProvider::class,
        POI\ServiceProvider::class,
        Goods\ServiceProvider::class,
        DataCube\ServiceProvider::class,
        OCR\ServiceProvider::class,

        // Basic Service
        BasicService\Media\ServiceProvider::class
    ];
}