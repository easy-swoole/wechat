<?php
/**
 * Created by PhpStorm.
 * User: yf
 * Date: 2018/12/24
 * Time: 9:44 PM
 */

namespace EasySwoole\WeChat\Utility;

use EasySwoole\WeChat\AbstractInterface\StorageInterface;
use Swoole\Coroutine;

class FileStorage implements StorageInterface
{
    private $file;

    private $tempDir;
    private $context = [];

    public function __construct(string $tempDir, $appId)
    {
        $this->tempDir = $tempDir;
        $this->file = "{$tempDir}/wx_{$appId}.data";
    }

    public function get($key)
    {
        // TODO: Implement get() method.
        $data = $this->read();
        if(isset($data[$key])){
            $data = $data[$key];
            if(isset($data['expire'])){
                if(time() <= $data['expire']){
                    return $data['data'];
                }
            }else{
                return $data['data'];
            }
        }
        return null;
    }

    public function set($key, $value, int $expire = null)
    {
        // TODO: Implement set() method.
        $data = $this->read();
        $data[$key] = [
            'data'=>$value,
            'expire'=>$expire
        ];
        return $this->write($data);
    }

    public function lock(string $appId, float $timeout = 3.0): bool
    {
        $cid = Coroutine::getCid();
        if(!isset($this->context[$cid])){
            $fp = fopen("{$this->tempDir}/{$appId}.lock",'c+');
            if(!$fp){
                return false;
            }
            $this->context[$cid] = $fp;
        }
        $fp = $this->context[$cid];
        return flock($fp,LOCK_EX);
    }

    public function unlock(string $appId, float $timeout = 3.0): bool
    {
        $cid = Coroutine::getCid();
        if(isset($this->context[$cid])){
            $fp = $this->context[$cid];
            $ret = flock($fp,LOCK_UN);
            unset($this->context[$cid]);
            fclose($fp);
            return $ret;
        }
        return true;
    }


    private function read():array
    {
        if(!file_exists($this->file)){
            return [];
        }
        $data = file_get_contents($this->file);
        $json = json_decode($data,true);
        if(!is_array($json)){
            $json = [];
        }
        return $json;
    }

    private function write(array $data)
    {
        return file_put_contents($this->file,json_encode($data,JSON_UNESCAPED_SLASHES|JSON_UNESCAPED_UNICODE));
    }
}