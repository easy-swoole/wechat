<?php


namespace EasySwoole\WeChat\OpenPlatform;


use BadMethodCallException;
use EasySwoole\WeChat\Kernel\ServiceContainer;
use EasySwoole\WeChat\Kernel\ServiceProviders;
use EasySwoole\WeChat\OpenPlatform\Authorizer\Aggregate\OfficialAccount\Application as OfficialAccount;
use EasySwoole\WeChat\OpenPlatform\Authorizer\Aggregate\OfficialAccount\Account\Client as OfficialAccountAccountClient;
use EasySwoole\WeChat\OpenPlatform\Authorizer\Auth\AccessToken;

/**
 * Class ServiceProvider
 *
 * @package EasySwoole\WeChat\OpenPlatform
 * @property Auth\AccessToken $accessToken
 * @property Base\Client $base
 * @property Server\Guard $server
 * @property CodeTemplate\Client $codeTemplate
 * @property Component\Client $component
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
    const Account = 'account';
    const Base = 'base';
    const Server = 'server';
    const VerifyTicket = 'verifyTicket';
    const CodeTemplate = 'codeTemplate';
    const Component = 'component';


    protected $providers = [
        Auth\ServiceProvider::class,
        Base\ServiceProvider::class,
        Server\ServiceProvider::class,
        CodeTemplate\ServiceProvider::class,
        Component\ServiceProvider::class,
    ];

    /**
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
            Application::Account => function ($app) {
                return new OfficialAccountAccountClient($app, $this);
            }
        ]);

        return $officialAccount;
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
