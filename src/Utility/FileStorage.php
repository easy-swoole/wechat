<?php
/**
 * Created by PhpStorm.
 * User: yf
 * Date: 2018/12/24
 * Time: 9:44 PM
 */

namespace EasySwoole\WeChat\Utility;


use EasySwoole\WeChat\AbstractInterface\AbstractStorage;

class FileStorage extends AbstractStorage
{
    protected $dir;

    function __construct($recognizeId)
    {
        parent::__construct($recognizeId);
        $this->dir = getcwd().'/Temp';
        clearstatcache();
        if(!is_dir($this->dir)){
            if(!mkdir($this->dir)){
                throw new \Exception("mkdir {$this->dir} fail");
            }
        }
    }

    public function get($key)
    {
        // TODO: Implement get() method.
    }

    public function set($key, $value, int $expire = null)
    {
        // TODO: Implement set() method.
    }
}