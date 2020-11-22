<?php


namespace EasySwoole\WeChat\Work;


use EasySwoole\WeChat\Kernel\BaseClient as Client;

class BaseClient extends Client
{
    protected $baseUrl = 'https://qyapi.weixin.qq.com';
}