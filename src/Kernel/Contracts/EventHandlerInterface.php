<?php


namespace EasySwoole\WeChat\Kernel\Contracts;


interface EventHandlerInterface
{
    /**
     * @param null $payload
     * @return mixed
     */
    public function handle($payload = null);
}