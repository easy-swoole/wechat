<?php

namespace EasySwoole\WeChat\OpenPlatform\Authorizer\MiniProgram;

use EasySwoole\WeChat\MiniProgram\Application as MiniProgram;

/**
 * Class Application
 * @package EasySwoole\WeChat\OpenPlatform\Authorizer\MiniProgram
 * @property Account\Client $account
 * @property BetaMiniProgram\Client $betaMiniProgram
 * @property Code\Client $code
 * @property Domain\Client $domain
 * @property Material\Client $material
 * @property PrivacyConfig\Client $privacyConfig
 * @property PrivacyInterface\Client $privacyInterface
 * @property QrCodeJump\Client $qrCodeJump
 * @property Setting\Client $setting
 * @property Tester\Client $tester
 * @property Embedded\Client $embedded
 * @property Record\Client $record
 */
class Application extends MiniProgram
{
    const Account = 'account';
    const BetaMiniProgram = 'betaMiniProgram';
    const Code = 'code';
    const Domain = 'domain';
    const Material = 'material';
    const OpenAuth = 'openAuth';
    const PrivacyConfig = 'privacyConfig';
    const PrivacyInterface = 'privacyInterface';
    const QrCodeJump = 'qrCodeJump';
    const Setting = 'setting';
    const Tester = 'tester';
    const Embedded = 'embedded';
    const Record = 'record';

    public function __construct(array $config = null, string $name = null, array $values = [])
    {
        parent::__construct($config, $name, $values);

        $providers = [
            BetaMiniProgram\ServiceProvider::class,
            Code\ServiceProvider::class,
            Domain\ServiceProvider::class,
            Material\ServiceProvider::class,
            PrivacyConfig\ServiceProvider::class,
            PrivacyInterface\ServiceProvider::class,
            QrCodeJump\ServiceProvider::class,
            Setting\ServiceProvider::class,
            Tester\ServiceProvider::class,
            Embedded\ServiceProvider::class,
            Record\ServiceProvider::class,
        ];

        foreach ($providers as $provider) {
            $this->register(new $provider());
        }
    }
}
