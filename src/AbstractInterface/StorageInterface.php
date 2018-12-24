<?php
/**
 * Created by PhpStorm.
 * User: yf
 * Date: 2018/12/24
 * Time: 4:48 PM
 */

namespace EasySwoole\WeChat\AbstractInterface;


interface StorageInterface
{
    public function get($key);
    public function set($key,$value,int $expire = null);
}