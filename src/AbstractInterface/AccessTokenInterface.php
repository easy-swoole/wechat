<?php


namespace EasySwoole\WeChat\AbstractInterface;


interface AccessTokenInterface
{
    public function getToken($refreshTimes = 1): ?string;

    public function refresh(): ?string;
}