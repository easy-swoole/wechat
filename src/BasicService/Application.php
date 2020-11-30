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

    protected $providers = [
        Media\ServiceProvider::class,
    ];
}