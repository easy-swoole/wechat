<?php
/**
 * Created by PhpStorm.
 * User: runs
 * Date: 19-1-6
 * Time: 上午6:47
 */

namespace EasySwoole\WeChat\Bean\OfficialAccount;

use EasySwoole\HttpClient\Bean\Response;
use EasySwoole\Utility\MimeType;
use Swoole\Coroutine;

class MediaResponse
{
    protected $httpResponse;

    public function __construct(Response $httpResponse)
    {
        $this->httpResponse = $httpResponse;
    }

    /**
     * @return Response
     */
    public function httpResponse() : Response
    {
        return $this->httpResponse;
    }

    public function isJson() : bool
    {
        if ($this->getContent()[0] === '{') {
            return true;
        }
        return false;
    }

    public function isEmpty() : bool
    {
        return empty($this->getContent());
    }

    public function getContent() : string
    {
        return $this->httpResponse()->getBody();
    }

    /**
     * @param string      $directory
     * @param string|null $filename
     * @return string
     */
    public function save(string $directory, string $filename = null)
    {
        $directory = rtrim($directory, '/');

        if (!is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        if (!is_writable($directory)) {
            throw new \InvalidArgumentException(sprintf("'%s' is not writable.", $directory));
        }

        $contents = $this->httpResponse()->getBody();

        if (empty($filename)) {
            if (preg_match('/filename="(?<filename>.*?)"/', $this->httpResponse()->getHeaders()['content-disposition'], $match)) {
                $filename = $match['filename'];
            } else {
                $filename = md5($contents);
            }
        }

        if (empty(pathinfo($filename, PATHINFO_EXTENSION))) {
            $filename .= MimeType::getExtFromStream($contents);
        }

        Coroutine::writeFile($directory.'/'.$filename, $contents);

        return $filename;
    }

    /**
     * @param string $directory
     * @param string $filename
     * @return string
     */
    public function saveAs(string $directory, string $filename)
    {
        return $this->save($directory, $filename);
    }
}