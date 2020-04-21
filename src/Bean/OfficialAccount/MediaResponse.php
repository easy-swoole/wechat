<?php
/**
 * Created by PhpStorm.
 * User: runs
 * Date: 19-1-6
 * Time: 上午6:47
 */

namespace EasySwoole\WeChat\Bean\OfficialAccount;

use EasySwoole\HttpClient\Bean\Response;
use EasySwoole\Utility\Mime\MimeDetectorException;
use EasySwoole\Utility\MimeType;
use EasySwoole\WeChat\Exception\RequestError;
use EasySwoole\WeChat\Utility\NetWork;
use InvalidArgumentException;
use Swoole\Coroutine;

/**
 * 微信素材对象
 * Class MediaResponse
 * @package EasySwoole\WeChat\Bean\OfficialAccount
 */
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
    public function httpResponse(): Response
    {
        return $this->httpResponse;
    }

    public function isJson(): bool
    {
        if ($this->getContent()[0] === '{') {
            return true;
        }
        return false;
    }


    public function isVideo()
    {
        if (isset($this->httpResponse()->getHeaders()['content-type']) && $this->httpResponse()->getHeaders()['content-type'] === 'text/plain') {
            $data = json_decode($this->getContent(), true);
            if (isset($data['down_url'])) {
                return $data['down_url'];
            }
            if (isset($data['video_url'])) {
                return $data['video_url'];
            }
        }

        return false;
    }

    public function isEmpty(): bool
    {
        return empty($this->getContent());
    }

    public function getContent(): string
    {
        return $this->httpResponse()->getBody();
    }

    /**
     * 保存到本地文件
     * @param string $directory
     * @param string|null $filename
     * @return string
     * @throws MimeDetectorException
     */
    public function save(string $directory, string $filename = null, int $timeout = 15)
    {
        $directory = rtrim($directory, '/');

        if (!is_dir($directory)) {
            mkdir($directory, 0755, true);
        }

        if (!is_writable($directory)) {
            throw new InvalidArgumentException(sprintf("'%s' is not writable.", $directory));
        }

        if ($fileUrl = $this->isVideo()) {
            NetWork::$TIMEOUT = $timeout;

            $fileData = NetWork::get($fileUrl);

            if (($fileData->getClient()->errCode)) {
                throw new RequestError($fileData->getClient()->errMsg);
            }

            $this->httpResponse = $fileData;
        }

        $contents = $this->httpResponse()->getBody();

        if (empty($filename)) {
            if (isset($this->httpResponse()->getHeaders()['content-disposition']) && preg_match('/filename=["]{0,1}(?<filename>.*)/', $this->httpResponse()->getHeaders()['content-disposition'], $match)) {
                $filename = $match['filename'];
            } else {
                $filename = md5($contents);
            }
        }

        $filename = trim($filename, '"');

        if (empty(pathinfo($filename, PATHINFO_EXTENSION))) {
            $filename .= '.'.MimeType::getExtFromStream($contents);
        }

        Coroutine::writeFile($directory . '/' . $filename, $contents);

        return $filename;
    }

    /**
     * 保存到本地文件别名
     * @param string $directory
     * @param string $filename
     * @return string
     * @throws MimeDetectorException
     */
    public function saveAs(string $directory, string $filename)
    {
        return $this->save($directory, $filename);
    }
}