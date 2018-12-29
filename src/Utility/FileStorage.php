<?php
/**
 * Created by PhpStorm.
 * User: yf
 * Date: 2018/12/24
 * Time: 9:44 PM
 */

namespace EasySwoole\WeChat\Utility;

use EasySwoole\WeChat\AbstractInterface\StorageInterface;

class FileStorage implements StorageInterface
{
    public function __construct(string $tempDir, $appId)
    {

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