<?php
/**
 * Created by PhpStorm.
 * User: runs
 * Date: 19-1-6
 * Time: 上午6:47
 */

namespace EasySwoole\WeChat\Bean\OfficialAccount;

use EasySwoole\HttpClient\Bean\Response;
use EasySwoole\WeChat\OfficialAccount\File;
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

        if (empty($contents) || '{' === $contents[0]) {
            throw new \RuntimeException('Invalid media response content.');
        }

        if (empty($filename)) {
            if (preg_match('/filename="(?<filename>.*?)"/', $this->httpResponse()->getHeaders()['content-disposition'], $match)) {
                $filename = $match['filename'];
            } else {
                $filename = md5($contents);
            }
        }

        if (empty(pathinfo($filename, PATHINFO_EXTENSION))) {
            $filename .= File::getStreamExt($contents);
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