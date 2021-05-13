<?php

namespace EasySwoole\WeChat\OpenPlatform;

use BadMethodCallException;
use EasySwoole\WeChat\Kernel\Encryptor;
use EasySwoole\WeChat\Kernel\ServiceContainer;
use EasySwoole\WeChat\Kernel\ServiceProviders;
use EasySwoole\WeChat\OpenPlatform\Authorizer\OfficialAccount\Application as OfficialAccount;
use EasySwoole\WeChat\OpenPlatform\Authorizer\MiniProgram\Application as MiniProgram;
use EasySwoole\WeChat\OpenPlatform\Authorizer\OfficialAccount\Account\Client as OfficialAccountAccountClient;
use EasySwoole\WeChat\OpenPlatform\Authorizer\OfficialAccount\OpenOAuth\Client as OfficialAccountOAuthClient;
use EasySwoole\WeChat\OpenPlatform\Authorizer\OfficialAccount\CallApi\Client as OfficialAccountCallApiClient;
use EasySwoole\WeChat\OpenPlatform\Authorizer\MiniProgram\OpenAuth\Client as MiniProgramOpenAuthClient;
use EasySwoole\WeChat\OpenPlatform\Authorizer\MiniProgram\Account\Client as MiniProgramAccountClient;
use EasySwoole\WeChat\OpenPlatform\Authorizer\Auth\AccessToken;

/**
 * Class ServiceProvider
 *
 * @package EasySwoole\WeChat\OpenPlatform
 * @property Auth\AccessToken $accessToken
 * @property Auth\VerifyTicket $verifyTicket
 * @property Base\Client $base
 * @property CodeTemplate\Client $codeTemplate
 * @property Component\Client $component
 * @property Server\Guard $server
 *
 * @method mixed handleAuthorize(string $authCode)
 * @method mixed createPreAuthorizationCode()
 * @method string getPreAuthorizationUrl(string $callbackUrl, ?string $preAuthCode = null, array $optional = [])
 * @method string getMobilePreAuthorizationUrl(string $callbackUrl, ?string $preAuthCode = null, array $optional = [])
 * @method string getAuthorizerOption(string $appId, string $name)
 * @method bool setAuthorizerOption(string $appId, string $name, string $value)
 * @method mixed getAuthorizers(int $offset = 0, int $count = 500)
 * @method mixed getAuthorizer(string $appId)
 * @method bool clearQuota()
 */
class Application extends ServiceContainer
{
    const VerifyTicket = 'verifyTicket';
    const Base = 'base';
    const CodeTemplate = 'codeTemplate';
    const Component = 'component';
    const Server = 'server';

    protected $providers = [
        Auth\ServiceProvider::class,
        Base\ServiceProvider::class,
        Server\ServiceProvider::class,
        CodeTemplate\ServiceProvider::class,
        Component\ServiceProvider::class,
    ];

    /**
     * 创建代公众号业务实例
     * Creates the officialAccount application.
     *
     * @param string $appId
     * @param string|null $refreshToken
     * @param AccessToken|null $accessToken
     * @return OfficialAccount
     */
    public function officialAccount(string $appId, string $refreshToken = null, AccessToken $accessToken = null): OfficialAccount
    {
        $officialAccount = new OfficialAccount($this->getAuthorizerConfig($appId, $refreshToken), null, [
            ServiceProviders::AccessToken => $accessToken ?: function ($app) {
                return new AccessToken($app, $this);
            },
            ServiceProviders::Encryptor => function ($app) {
                return new Encryptor();
            },
            OfficialAccount::Account => function ($app) {
                return new OfficialAccountAccountClient($app, $this);
            },
            OfficialAccount::CallApi => function ($app) {
                return new OfficialAccountCallApiClient($app, $this);
            },
            OfficialAccount::OpenOAuth => function ($app) {
                return new OfficialAccountOAuthClient($app, $this);
            }
        ]);

        return $officialAccount;
    }

    /**
     * Creates the miniProgram application.
     * 创建代注册小程序实例
     *
     * @param string $appId
     * @param string|null $refreshToken
     * @param AccessToken|null $accessToken
     * @return MiniProgram
     */
    public function miniProgram(string $appId, string $refreshToken = null, AccessToken $accessToken = null): MiniProgram
    {
        return new MiniProgram($this->getAuthorizerConfig($appId, $refreshToken), null, [
            ServiceProviders::AccessToken => $accessToken ?: function ($app) {
                return new AccessToken($app, $this);
            },
            ServiceProviders::Encryptor => function ($app) {
                return new \EasySwoole\WeChat\MiniProgram\Encryptor();
            },
            MiniProgram::Account => function ($app) {
                return new MiniProgramAccountClient($app, $this);
            },
            MiniProgram::OpenAuth => function ($app) {
                return new MiniProgramOpenAuthClient($app, $this);
            }
        ]);
    }

    /**
     * @param string $appId
     * @param string|null $refreshToken
     * @return array
     */
    protected function getAuthorizerConfig(string $appId, string $refreshToken = null): array
    {
        $config = $this->getConfig();
        return array_merge($config, [
            'componentAppId' => $config['appId'],
            'componentAppToken' => $config['token'],
            'appId' => $appId,
            'refreshToken' => $refreshToken,
        ]);
    }

    /**
     * @param $method
     * @param $arguments
     * @return mixed
     */
    public function __call($method, $arguments)
    {
        if (method_exists($this->base, $method)) {
            return $this->base->$method(...$arguments);
        }

        throw new BadMethodCallException(sprintf('Method %s not exists.', $method));
    }
}
