<?php


namespace EasySwoole\WeChat\OfficialAccount;


use EasySwoole\WeChat\Kernel\ServiceContainer;
use EasySwoole\WeChat\OfficialAccount\Auth\AccessToken;
use EasySwoole\WeChat\OfficialAccount\Server\Guard;

/**
 * Class ServiceProvider
 *
 * @package EasySwoole\WeChat\OfficialAccount
 * @property AccessToken $accessToken
 * @property AutoReplay\Client $autoReplay
 * @property Base\Client $base
 * @property Guard $server
 * @property Wifi\Client $wifi
 * @property WiFi\CardClient $wifiCard
 * @property WiFi\DeviceClient $wifiDevice
 * @property WiFi\ShopClient $wifiShop
 * @property User\UserClient $user
 * @property User\TagClient $userTag
 */
class Application extends ServiceContainer
{
    const Base = 'base';
    const Server = 'server';
    const AutoReplay = 'autoReplay';
    const Broadcasting = 'broadcasting';
    const Wifi = 'wifi';
    const WifiCard = 'wifiCard';
    const WifiDevice = 'wifiDevice';
    const WifiShop = 'wifShop';
    const User = 'user';
    const UserTag = 'userTag';

    protected $providers = [
        Auth\ServiceProvider::class,
        AutoReplay\ServiceProvider::class,
        Broadcasting\ServiceProvider::class,
        Base\ServiceProvider::class,
        Server\ServiceProvider::class,
        WiFi\ServiceProvider::class,
        User\ServiceProvider::class
    ];
}