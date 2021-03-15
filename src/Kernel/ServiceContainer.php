<?php


namespace EasySwoole\WeChat\Kernel;


use EasySwoole\WeChat\Kernel\Providers\CacheServiceProvider;
use EasySwoole\WeChat\Kernel\Providers\ConfigServiceProvider;
use EasySwoole\WeChat\Kernel\Providers\HttpClientServiceProvider;
use EasySwoole\WeChat\Kernel\Providers\LogServiceProvider;
use Pimple\Container;

class ServiceContainer extends Container
{
    protected $config;
    protected $name;
    protected $providers = [];

    public function __construct(array $config = null, string $name = null, array $values = [])
    {
        $this->config = $config;
        parent::__construct($values);
        $this->name = $name;
        $this->registerProviders($this->getProviders());
    }

    public function getName(): string
    {
        return $this->name;
    }

    public function getConfig(): array
    {
        return $this->config ?? [];
    }

    public function getProviders(): array
    {
        return array_merge([
            LogServiceProvider::class,
            ConfigServiceProvider::class,
            CacheServiceProvider::class,
            HttpClientServiceProvider::class
        ], $this->providers);
    }

    public function registerProviders(array $providers)
    {
        foreach ($providers as $provider) {
            parent::register(new $provider());
        }
    }

    public function rebind($name, $value)
    {
        $this->offsetUnset($name);
        $this->offsetSet($name, $value);
    }

    public function __get($name)
    {
        return $this->offsetGet($name);
    }

    public function __set($name, $value)
    {
        $this->offsetSet($name, $value);
    }
}
