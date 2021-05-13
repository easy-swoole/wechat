<?php

namespace EasySwoole\WeChat\OpenPlatform\Authorizer\OfficialAccount;

use EasySwoole\WeChat\OfficialAccount\Application as OfficialAccount;

/**
 * Class Application
 * @package EasySwoole\WeChat\OpenPlatform\Authorizer\Aggregate\OfficialAccount
 * @property MiniProgram\Client $miniProgram
 */
class Application extends OfficialAccount
{
    const Account = 'account';
    const CallApi = 'callApi';
    const OpenOAuth = 'openOAuth';
    const MiniProgram = 'miniProgram';

    /**
     * Application constructor.
     * @param array|null $config
     * @param string|null $name
     * @param array $values
     */
    public function __construct(array $config = null, string $name = null, array $values = [])
    {
        parent::__construct($config, $name, $values);

        $providers = [
            MiniProgram\ServiceProvider::class
        ];

        foreach ($providers as $provider) {
            $this->register(new $provider());
        }
    }
}
