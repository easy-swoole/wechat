<?php


namespace EasySwoole\WeChat\Kernel\Contracts;


interface JsSdkTicketInterface
{
    public function getToken(bool $autoRefresh = true):?string;

    public function refresh():JsSdkTicketInterface;
}