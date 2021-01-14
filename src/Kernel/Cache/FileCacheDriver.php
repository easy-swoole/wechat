<?php


namespace EasySwoole\WeChat\Kernel\Cache;


use EasySwoole\Utility\File;
use EasySwoole\WeChat\Kernel\Exceptions\RuntimeException;
use Psr\SimpleCache\CacheInterface;

class FileCacheDriver implements CacheInterface
{
    /**
     * @var string
     */
    protected $tmpDir;

    public function __construct(string $directory)
    {
        if (!is_dir($directory)) {
            if(!mkdir($directory, 0755, true)){
                throw new RuntimeException("create dir {$directory} fail");
            }
        }

        $this->tmpDir = $directory;
    }

    public function get($key, $default = null)
    {
        $file = $this->key2File($key);
        if(file_exists($file)){
            $data = unserialize(file_get_contents($file));
            if($data && time() < $data['t']){
                return $data['d'];
            }
        }
        return  $default;
    }

    public function set($key, $value, $ttl = null)
    {
        $data = [
            'd'=>$value,
            't'=>$ttl + time()
        ];
        return file_put_contents($this->key2File($key),serialize($data));
    }

    public function delete($key)
    {
        $file = $this->key2File($key);
        if(file_exists($file)){
            unlink($file);
        }
        return true;
    }

    public function clear()
    {
        File::cleanDirectory($this->tmpDir);
    }

    public function getMultiple($keys, $default = null)
    {

    }

    public function setMultiple($values, $ttl = null)
    {

    }

    public function deleteMultiple($keys)
    {
        foreach ($keys as $key){
            $this->delete($key);
        }
    }

    public function has($key)
    {
        $file = $this->key2File($key);
        return file_exists($file);
    }

    private function key2File($key):string
    {
        return $this->tmpDir.'/'.substr(md5($key),8,16);
    }


}