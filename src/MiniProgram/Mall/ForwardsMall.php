<?php

namespace EasySwoole\WeChat\MiniProgram\Mall;

class ForwardsMall
{
    /**
     * @var \EasySwoole\WeChat\Kernel\ServiceContainer
     */
    protected $app;

    /**
     * @param \EasySwoole\WeChat\Kernel\ServiceContainer $app
     */
    public function __construct($app)
    {
        $this->app = $app;
    }

    /**
     * @param string $property
     *
     * @return mixed
     */
    public function __get($property)
    {
        return $this->app["mall.{$property}"];
    }
}