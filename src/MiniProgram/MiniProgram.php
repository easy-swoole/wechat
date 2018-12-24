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
    function __construct(MiniProgramConfig $config)
    {
        $this->config = $config;
    }
}