<?php
/**
 * Created by PhpStorm.
 * User: yf
 * Date: 2018-12-30
 * Time: 14:46
 */

namespace EasySwoole\WeChat\AbstractInterface;


use EasySwoole\Spl\SplEnum;

class AbstractErrorCodeEnum extends SplEnum
{
    function __toString()
    {
        $res = strtolower(parent::__toString());
        return str_replace("_",' ',$res);
    }
}