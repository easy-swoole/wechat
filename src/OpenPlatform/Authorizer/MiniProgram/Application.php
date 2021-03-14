<?php


namespace EasySwoole\WeChat\OpenPlatform\Authorizer\MiniProgram;


use EasySwoole\WeChat\MiniProgram\Application as MiniProgram;
use EasySwoole\WeChat\OpenPlatform\Authorizer\Aggregate\AggregateServiceProvider;

/**
 * Class Application
 * @package EasySwoole\WeChat\OpenPlatform\Authorizer\MiniProgram
 * @property Account\Client $account
 * @property Code\Client $code
 * @property Domain\Client $domain
 * @property Setting\Client $setting
 * @property Tester\Client $tester
 * @property Material\Client $material
 */
class Application extends MiniProgram
{
    const Code = 'code';
    const Domain = 'domain';
    const Material = 'material';
    const Setting = 'setting';
    const Tester = 'tester';

    public function __construct(array $config = null, string $name = null, array $values = [])
    {
        parent::__construct($config, $name, $values);

        $providers = [
            AggregateServiceProvider::class,
            Code\ServiceProvider::class,
            Domain\ServiceProvider::class,
            Account\ServiceProvider::class,
            Setting\ServiceProvider::class,
            Tester\ServiceProvider::class,
            Material\ServiceProvider::class,
        ];

        foreach ($providers as $provider) {
            $this->register(new $provider());
        }
    }
}
