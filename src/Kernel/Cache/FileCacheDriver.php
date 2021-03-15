<?php


namespace EasySwoole\WeChat\Kernel\Cache;


use EasySwoole\Utility\File;
use EasySwoole\WeChat\Kernel\Exceptions\InvalidArgumentException;
use EasySwoole\WeChat\Kernel\Exceptions\RuntimeException;
use Psr\SimpleCache\CacheInterface;
use Throwable;

class FileCacheDriver implements CacheInterface
{
    /**
     * @var string
     */
    protected $directory;

    /**
     * FileCacheDriver constructor.
     * @param string $directory
     * @throws RuntimeException
     */
    public function __construct(string $directory)
    {
        if (!is_dir($directory)) {
            if (!mkdir($directory, 0755, true)) {
                throw new RuntimeException("create dir {$directory} fail");
            }
        }

        $this->directory = $directory;
    }

    public function get($key, $default = null)
    {
        return $this->getPayload($key)['data'] ?? $default;
    }

    protected function getPayload($key)
    {

        $path = $this->path($key);
        try {
            $expire = substr($contents = $this->getFileContents($path, true), 0, 10);
            $currentTime = time();

            if ($currentTime >= $expire) {
                $this->delete($key);
                return ['data' => null, 'time' => null];
            }

            $data = unserialize(substr($contents, 10));
            $time = $expire - $currentTime;

            return [
                'data' => $data,
                'tome' => $time
            ];

        } catch (Throwable $exception) {
            $this->delete($key);
            return ['data' => null, 'time' => null];
        }


    }

    protected function getFileContents($path, $lock = false)
    {
        if (!file_exists($path)) {
            throw new RuntimeException("File does not exist at path {$path}.");
        }

        if ($lock == false) {
            return file_get_contents($path);
        }

        $contents = '';

        $handle = fopen($path, 'rb');

        if (!$handle) {
            return $contents;
        }

        try {
            if (flock($handle, LOCK_SH)) {
                clearstatcache(true, $path);
                $contents = fread($handle, filesize($path) ?: 1);
            }
        } finally {
            flock($handle, LOCK_UN);
            fclose($handle);
        }

        return $contents;
    }

    protected function path($key)
    {
        $parts = array_slice(str_split($hash = sha1($key), 2), 0, 2);
        return $this->directory . '/' . implode('/', $parts) . '/' . $hash;
    }

    public function set($key, $value, $ttl = null)
    {
        $path = $this->path($key);

        if (is_int($ttl) && $ttl <= 0) {
            return $this->delete($key);
        }

        $expiration = ($ttl === null || $ttl > 9999999999) ? 9999999999 : time() + $ttl;
        $contents = $expiration . serialize($value);

        if (!file_exists(dirname($path))) {
            if (!mkdir(dirname($path), 0755, true)) {
                throw new RuntimeException("create dir {$path} fail");
            }
        }

        $size = file_put_contents($path, $contents, LOCK_EX);
        if ($size !== 0 && $size > 0) {
            return true;
        }

        return false;
    }

    public function delete($key)
    {
        $file = $this->path($key);
        try {
            if (file_exists($file)) {
                return unlink($file);
            }
            return false;
        } catch (Throwable $exception) {
            return false;
        }
    }

    public function clear()
    {
        return File::cleanDirectory($this->directory);
    }

    public function getMultiple($keys, $default = null)
    {
        if (!is_array($keys) && !($keys instanceof \Iterator)) {
            throw new InvalidArgumentException('Not a valid key');
        }

        if (!($keys instanceof \Iterator) && (range(0, count($keys) - 1) !== array_keys($keys))) {
            throw new InvalidArgumentException('Not a valid key');
        }

        $result = [];
        foreach ($keys as $index => $key) {
            $result[$key] = $this->get($key, $default);
        }

        return $result;
    }

    public function setMultiple($values, $ttl = null)
    {
        if (!is_array($values) && !($values instanceof \Iterator)) {
            throw new InvalidArgumentException('Not a valid value');
        }

        $result = true;
        foreach ($values as $key => $value) {
            if ($this->set($key, $value, $ttl) === false && $result === true) {
                $result = false;
            }
        }

        return $result;
    }

    public function deleteMultiple($keys)
    {
        if (!is_array($keys) && !($keys instanceof \Iterator)) {
            throw new InvalidArgumentException('Not a valid key');
        }

        if (!($keys instanceof \Iterator) && (range(0, count($keys) - 1) !== array_keys($keys))) {
            throw new InvalidArgumentException('Not a valid key');
        }

        $success = true;
        foreach ($keys as $key) {
            $ret = $this->delete($key);
            if ($ret !== true && $success) {
                $success = false;
            }
        }
        return $success;
    }

    public function has($key)
    {
        $file = $this->path($key);
        return file_exists($file);
    }
}
