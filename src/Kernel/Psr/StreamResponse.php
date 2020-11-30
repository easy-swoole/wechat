<?php


namespace EasySwoole\WeChat\Kernel\Psr;


use EasySwoole\WeChat\Kernel\Contracts\StreamResponseInterface;
use Psr\Http\Message\StreamInterface;

class StreamResponse extends Stream implements StreamResponseInterface
{
    public function save(string $directory, string $filename = '', bool $appendSuffix = true): string
    {
        // TODO 实现保存文件
        return '';
    }

    /**
     * @param string $directory
     * @param string $filename
     * @param bool $appendSuffix
     * @return string
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
}