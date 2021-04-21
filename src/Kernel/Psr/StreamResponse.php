<?php


namespace EasySwoole\WeChat\Kernel\Psr;


use EasySwoole\Utility\File;
use EasySwoole\Utility\Mime\MimeDetectorException;
use EasySwoole\Utility\MimeType;
use EasySwoole\WeChat\Kernel\Contracts\StreamResponseInterface;
use EasySwoole\WeChat\Kernel\Exceptions\InvalidArgumentException;
use EasySwoole\WeChat\Kernel\Exceptions\RuntimeException;
use Psr\Http\Message\StreamInterface;

/**
 * Class StreamResponse
 * @package EasySwoole\WeChat\Kernel\Psr
 */
class StreamResponse extends Stream implements StreamResponseInterface
{
    /**
     * @param string $directory
     * @param string $filename
     * @param bool $appendSuffix
     * @return string
     * @throws InvalidArgumentException
     * @throws RuntimeException
     */
    public function save(string $directory, string $filename = '', bool $appendSuffix = true): string
    {
        $directory = rtrim($directory, '/');

        if (!File::createDirectory($directory)) {
            throw new RuntimeException(sprintf('Directory "%s" was not created', $directory));
        }

        if (!is_writable($directory)) {
            throw new InvalidArgumentException(sprintf("'%s' is not writable.", $directory));
        }

        $contents = $this->__toString();

        if (empty($contents) || '{' === $contents[0]) {
            throw new RuntimeException('Invalid media response content.');
        }

        if (empty($filename)) {
            $filename = md5($contents);
        }

        if ($appendSuffix && empty(pathinfo($filename, PATHINFO_EXTENSION))) {
            try {
                $filename .= '.';
                $filename .= MimeType::getExtFromStream($this);
            } catch (MimeDetectorException $e) {
                throw new RuntimeException($e->getMessage(), $e->getCode(), $e);
            }
        }

        $this->writeFile($directory . '/' . $filename, $contents);

        return $filename;
    }

    /**
     * @param string $directory
     * @param string $filename
     * @param bool $appendSuffix
     * @return string
     * @throws InvalidArgumentException
     * @throws RuntimeException
     */
    public function saveAs(string $directory, string $filename, bool $appendSuffix = true): string
    {
        return $this->save($directory, $filename, $appendSuffix);
    }

    /**
     * @return StreamInterface
     */
    public function getStream(): StreamInterface
    {
        return $this;
    }

    /**
     * @param string $filename
     * @param string $contents
     * @return mixed
     * @throws RuntimeException
     */
    protected function writeFile(string $filename, string $contents)
    {
        $fp = fopen($filename, 'w');
        $len = fwrite($fp, $contents);
        fclose($fp);
        if ($len === false) {
            throw new RuntimeException('Write file error.');
        }
        return $len;
    }
}
