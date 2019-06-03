<?php
/**
 * Created by PhpStorm.
 * User: yf
 * Date: 2018/12/24
 * Time: 9:32 PM
 */

namespace EasySwoole\WeChat\MiniProgram;


class MiniProgram
{
    private $config;
    private $auth;
    public function __construct(MiniProgramConfig $config)
    {
        $this->config = $config;
    }

    /**
     * getConfig
     *
     * @return MiniProgramConfig
     */
    public function getConfig() : MiniProgramConfig
    {
        return $this->config;
    }

    /**
     * auth
     *
     * @return Auth
     */
    public function auth() : Auth
    {
        if (!isset($this->auth)) {
            $this->auth = new Auth($this);
        }

        return $this->auth;
    }
}