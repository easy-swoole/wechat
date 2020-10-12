<?php


namespace EasySwoole\WeChat\Kernel;


class BaseClient
{
    protected $app;

    public function __construct(ServiceContainer $app)
    {
        $this->app = $app;
    }

    
}