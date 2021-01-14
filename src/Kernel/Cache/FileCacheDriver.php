<?php


namespace EasySwoole\WeChat\Kernel\Cache;


use EasySwoole\WeChat\Kernel\Exceptions\InvalidArgumentException;
use EasySwoole\WeChat\Kernel\Exceptions\RuntimeException;
use Psr\SimpleCache\CacheInterface;

class FileCacheDriver implements CacheInterface
{
    /**
     * @var string
     */
    protected $tmpDir;

    /**
     * @var array
     */
    protected $keyMap = [];

    /**
     * FileCacheDriver constructor.
     * @param string $directory
     */
    public function __construct(string $directory)
    {
        if (!is_dir($directory)) {
            if(!mkdir($directory, 0644, true)){
                throw new RuntimeException("create dir {$tmpDir} fail");
            }
        }

        $this->tmpDir = $directory;
    }

    /**
     * @param string $key
     * @param null $default
     * @return mixed|null
     * @throws InvalidArgumentException
     */
    public function get($key, $default = null)
    {
        $filename = $this->getFileName($key);

        if (!file_exists($filename)) {
            return $default;
        }

        $resource = fopen($filename, 'r');

        if ($resource === false) {
            return $default;
        }

        $expire = trim(fgets($resource), "\n");
        if (!empty($expire) && (intval($expire) < time())) {
            return $default;
        }

        $buffer = fread($resource, filesize($filename));
        fclose($resource);

        return unserialize($buffer);

    }

    /**
     * @param string $key
     * @param mixed $value
     * @param null $ttl
     * @return bool
     * @throws InvalidArgumentException
     */
    public function set($key, $value, $ttl = null): bool
    {
        $filename = $this->getFileName($key);

        if ($ttl !== null && $ttl <= 0) {
            file_exists($filename) && @unlink($filename);
            return true;
        }

        $expire = is_null($ttl) ? null : (time() + intval($ttl));
        $buffer = implode("\n", [$expire, serialize($value)]);

        $resource = fopen($filename, 'w+');

        if ($resource === false) {
            return false;
        }

        if (fwrite($resource, $buffer) !== strlen($buffer)) {
            return false;
        }

        $this->keyMap[$key] = $filename;
        fclose($resource);

        return true;
    }

    /**
     * @param string $key
     * @return bool
     * @throws InvalidArgumentException
     */
    public function delete($key): bool
    {
        $filename = $this->getFileName($key);

        $result = file_exists($filename) && @unlink($filename);

        if ($result) {
            unset($this->keyMap[$key]);
        }

        return $result;
    }

    /**
     * @return bool
     * @throws InvalidArgumentException
     */
    public function clear(): bool
    {
        $result = true;
        foreach ($this->keyMap as $key => $filename) {
            if ($this->delete($key) === false && $result === true) {
                $result = false;
            }
        }

        return $result;
    }

    /**
     * @param iterable|array $keys
     * @param null $default
     * @return array
     * @throws InvalidArgumentException
     */
    public function getMultiple($keys, $default = null): array
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
     * @param iterable|array $values
     * @param null $ttl
     * @return bool
     * @throws InvalidArgumentException
     */
    public function setMultiple($values, $ttl = null): bool
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
     * @param iterable|array $keys
     * @return bool
     * @throws InvalidArgumentException
     */
    public function deleteMultiple($keys): bool
    {
        if (!is_array($keys) && !($keys instanceof \Iterator)) {
            throw new InvalidArgumentException('Not a valid key');
        }

        if (!($keys instanceof \Iterator) && (range(0, count($keys) - 1) !== array_keys($keys))) {
            throw new InvalidArgumentException('Not a valid key');
        }

        $result = true;
        foreach ($keys as $key) {
            if ($this->delete($key) === false && $result === true) {
                $result = false;
            }
        }

        return $result;
    }

    /**
     * @param string $key
     * @return bool
     * @throws InvalidArgumentException
     */
    public function has($key): bool
    {
        $filename = $this->getFileName($key);

        return file_exists($filename);
    }

    /**
     * @param string $key
     * @return string
     * @throws InvalidArgumentException
     */
    protected function getFileName(string $key): string
    {
        if (array_key_exists($key, $this->keyMap)) {
            return $this->keyMap[$key];
        }

        if (preg_match('#[^-+_.A-Za-z0-9]#', $key, $match)) {
            throw new InvalidArgumentException("Key contains {$match[0]},which does not conform to the rule [-+_.A-Za-z0-9]");
        }

        return $this->tmpDir . '/' . md5($key);
    }
}