<?php
/**
 * Created by PhpStorm.
 * User: yf
 * Date: 2018/12/24
 * Time: 4:48 PM
 */

namespace EasySwoole\WeChat\AbstractInterface;


abstract class AbstractStorage
{
    private $recognizeId;

    function __construct($recognizeId)
    {
        $this->recognizeId = $recognizeId;
    }

    protected function getRecognizeId()
    {
        return $this->recognizeId;
    }

    abstract public function get($key);
    abstract public function set($key,$value,int $expire = null);
}