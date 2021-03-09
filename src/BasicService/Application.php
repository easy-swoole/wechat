<?php


namespace EasySwoole\WeChat\BasicService;


use EasySwoole\WeChat\Kernel\ServiceContainer;

/**
 * Class ServiceProvider
 *
 * @package EasySwoole\WeChat\BasicService
 * @property Media\Client $media
 */
class Application extends ServiceContainer
{
    const Media = 'media';
    const Jssdk = 'jssdk';
    const Ticket = 'ticket';
    const QrCode = 'qrcode';

    protected $providers = [
        Media\ServiceProvider::class,
        Jssdk\ServiceProvider::class,
        QrCode\ServiceProvider::class
    ];
}
