<?php


namespace EasySwoole\WeChat\Kernel\Cache;


use EasySwoole\Utility\FileSystem;
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

    /** @var FileSystem */
    protected $fileSystem;

    /**
     * FileCacheDriver constructor.
     * @param string $directory
     * @throws RuntimeException
     */
    public function __construct(string $directory)
    {
        $this->fileSystem = new FileSystem();

        // Detect the existence of a folder and create
        if (!$this->fileSystem->ensureDirectoryExists($directory, 0755, true)) {
            throw new RuntimeException("create dir {$directory} fail");
        }

        $this->directory = $directory;
    }

    /**
     * @param string $key
     * @param null $default
     * @return mixed|null
     */
    public function get($key, $default = null)
    {
        return $this->getPayload($key)['data'] ?? $default;
    }

    /**
     * @param $key
     * @return array|null[]
     */
    protected function getPayload($key)
    {
        // Get the file path of key
        $path = $this->path($key);
        try {
            // Get expiration time
            $expire = substr($contents = $this->fileSystem->get($path, true), 0, 10);
            $currentTime = time();

            if ($currentTime >= $expire) {
                // Delete as soon as it expires
                $this->fileSystem->delete($path);
                return ['data' => null, 'time' => null];
            }

            // Intercept data
            $data = unserialize(substr($contents, 10));
            $time = $expire - $currentTime;

            return [
                'data' => $data,
                'time' => $time
            ];

        } catch (Throwable $exception) {
            // Abnormal deletion of the file
            $this->delete($key);
            return ['data' => null, 'time' => null];
        }


    }

    /**
     * @param $key
     * @return string
     */
    protected function path($key)
    {
        $parts = array_slice(str_split($hash = sha1($key), 2), 0, 2);
        return $this->directory . '/' . implode('/', $parts) . '/' . $hash;
    }

    /**
     * @param string $key
     * @param mixed $value
     * @param null $ttl
     * @return bool
     * @throws RuntimeException
     */
    public function set($key, $value, $ttl = null)
    {
        $path = $this->path($key);

        //Psr: Delete if ttl is negative or 0
        if (is_int($ttl) && $ttl <= 0) {
            return $this->delete($key);
        }

        // Set the expiration time to 10 digits
        $expiration = ($ttl === null || $ttl > 9999999999) ? 9999999999 : time() + $ttl;
        // Splicing data
        $contents = $expiration . serialize($value);

        // Detect the existence of a folder and create
        $directory = dirname($path);
        if (!$this->fileSystem->ensureDirectoryExists($directory, 0755, true)) {
            throw new RuntimeException("create dir {$directory} fail");
        }

        // Write to a file
        $size = $this->fileSystem->put($path, $contents, true);
        if ($size !== 0 && $size > 0) {
            return true;
        }

        return false;
    }

    /**
     * @param string $key
     * @return bool
     */
    public function delete($key)
    {
        $path = $this->path($key);
        return $this->fileSystem->exists($path) && $this->fileSystem->delete($path);
    }

    /**
     * @return bool
     */
    public function clear()
    {
        return $this->fileSystem->cleanDirectory($this->directory);
    }

    /**
     * @param iterable $keys
     * @param null $default
     * @return array|iterable
     * @throws InvalidArgumentException
     */
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

    /**
     * @param iterable $values
     * @param null $ttl
     * @return bool
     * @throws InvalidArgumentException
     * @throws RuntimeException
     */
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

    /**
     * @param iterable $keys
     * @return bool
     * @throws InvalidArgumentException
     */
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

    /**
     * @param string $key
     * @return bool
     */
    public function has($key)
    {
        $path = $this->path($key);
        return $this->fileSystem->exists($path);
    }
}
