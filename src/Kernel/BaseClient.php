<?php


namespace EasySwoole\WeChat\Kernel;


use EasySwoole\WeChat\Kernel\Contracts\ClientInterface;

class BaseClient
{
    protected $app;

    public function __construct(ServiceContainer $app)
    {
        $this->app = $app;
    }

    /**
     * @return ClientInterface
     */
    public function getClient():ClientInterface
    {
        return $this->app[ServiceProviders::Request]->getClient();
    }
}