<?php


namespace EasySwoole\WeChat\BasicService\Media;


use EasySwoole\WeChat\Kernel\BaseClient;
use EasySwoole\WeChat\Kernel\Exceptions\HttpException;
use EasySwoole\WeChat\Kernel\Exceptions\InvalidArgumentException;
use EasySwoole\WeChat\Kernel\Psr\StreamResponse;
use EasySwoole\WeChat\Kernel\ServiceProviders;

class Client extends BaseClient
{
    /** @var string[] */
    protected $allowTypes = ['image', 'voice', 'video', 'thumb'];

    /**
     * @param string $path
     * @return mixed
     * @throws HttpException
     * @throws InvalidArgumentException
     */
    public function uploadImage(string $path)
    {
        return $this->upload('image', $path);
    }

    /**
     * @param string $path
     * @return mixed
     * @throws HttpException
     * @throws InvalidArgumentException
     */
    public function uploadVoice(string $path)
    {
        return $this->upload('voice', $path);
    }

    /**
     * @param string $path
     * @throws HttpException
     * @throws InvalidArgumentException
     */
    public function uploadThumb(string $path)
    {
        $this->upload('thumb', $path);
    }

    /**
     * @param string $path
     * @return mixed
     * @throws HttpException
     * @throws InvalidArgumentException
     */
    public function uploadVideo(string $path)
    {
        return $this->upload('video', $path);
    }

    /***
     * @param string $mediaId
     * @param string $title
     * @param string $description
     * @return mixed
     * @throws HttpException
     */
    public function createVideoForBroadcasting(string $mediaId, string $title, string $description)
    {
        $response = $this->getClient()->setMethod("POST")
            ->setBody($this->jsonDataToStream([
                'media_id' => $mediaId,
                'title' => $title,
                'description' => $description,
            ]))->send('/cgi-bin/media/uploadvideo');

        $this->checkResponse($response, $parseData);
        return $parseData;
    }

    /**
     * @param string $type
     * @param string $path
     * @return mixed
     * @throws HttpException
     * @throws InvalidArgumentException
     */
    public function upload(string $type, string $path)
    {
        if (!in_array($type, $this->allowTypes, true)) {
            throw new InvalidArgumentException(sprintf("Unsupported media type: '%s'", $type));
        }

        if (!file_exists($path) || !is_readable($path)) {
            throw new InvalidArgumentException(sprintf("File does not exist, or the file is unreadable: '%s'", $path));
        }

        $response = $this->getClient()
            ->setMethod('POST')
            ->addFile($path, 'media')
            ->send($this->buildUrl(
                '/cgi-bin/media/upload',
                [
                    'access_token' => $this->app[ServiceProviders::AccessToken]->getToken(),
                    'type' => $type
                ]
            ));

        $this->checkResponse($response, $parseData);
        return $parseData;
    }

    /**
     * @param string $mediaId
     * @return StreamResponse
     * @throws HttpException
     */
    public function getJssdkMedia(string $mediaId)
    {
        $response = $this->getClient()
            ->setMethod('GET')
            ->send($this->buildUrl(
                '/cgi-bin/media/get/jssdk',
                [
                    'media_id' => $mediaId,
                    'access_token' => $this->app[ServiceProviders::AccessToken]->getToken()
                ]
            ));

        if (false !== stripos($response->getHeaderLine('Content-disposition'), 'attachment')) {
            return new StreamResponse($response->getBody());
        }

        $this->checkResponse($response, $parseData);
        return $parseData;
    }

    /**
     * @param string $mediaId
     * @return mixed
     * @throws HttpException
     */
    public function get(string $mediaId)
    {
        $response = $this->getClient()
            ->setMethod('GET')
            ->send($this->buildUrl(
                '/cgi-bin/media/get',
                [
                    'media_id' => $mediaId,
                    'access_token' => $this->app[ServiceProviders::AccessToken]->getToken()
                ]
            ));

        if (false !== stripos($response->getHeaderLine('Content-disposition'), 'attachment')) {
            return new StreamResponse($response->getBody());
        }

        $this->checkResponse($response, $parseData);
        return $parseData;
    }
}