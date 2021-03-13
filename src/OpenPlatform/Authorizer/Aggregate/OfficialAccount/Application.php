<?php


namespace EasySwoole\WeChat\OpenPlatform\Authorizer\Aggregate\OfficialAccount;


use EasySwoole\WeChat\OfficialAccount\Application as OfficialAccount;
use EasySwoole\WeChat\OpenPlatform\Authorizer\Aggregate\AggregateServiceProvider;

/**
 * Class Application
 * @package EasySwoole\WeChat\OpenPlatform\Authorizer\Aggregate\OfficialAccount
 * @property Account\Client $account
 * @property MiniProgram\Client $miniProgram
 */
class Application extends OfficialAccount
{
    const MiniProgram = 'miniProgram';

    /**
     * Application constructor.
     * @param array|null $config
     * @param string|null $name
     * @param array $values
     *
     */
    public function __construct(array $config = null, string $name = null, array $values = [])
    {
        parent::__construct($config, $name, $values);

        $providers = [
            AggregateServiceProvider::class,
            MiniProgram\ServiceProvider::class,
        ];

        foreach ($providers as $provider) {
            $this->register(new $provider());
        }
    }
}
