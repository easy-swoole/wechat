<?php
/**
 * Created by PhpStorm.
 * User: eValor
 * Date: 2019-03-18
 * Time: 10:18
 */

namespace EasySwoole\WeChat\OpenPlatform;

class OpenPlatform
{
    private $config;

    private $auth;

    function __construct(OpenPlatformConfig $config)
    {
        $this->config = $config;
    }

    /**
     * authorization
     * @return Auth
     */
    function auth()
    {
        if (!isset($this->auth)) {
            $this->auth = new Auth($this);
        }
        return $this->auth;
    }

    /**
     * ConfigGetter
     * @return OpenPlatformConfig
     */
    public function getConfig(): OpenPlatformConfig
    {
        return $this->config;
    }
}