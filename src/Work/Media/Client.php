<?php

namespace EasySwoole\WeChat\Work\Media;

use EasySwoole\WeChat\Kernel\Exceptions\InvalidArgumentException;
use EasySwoole\WeChat\Kernel\Psr\StreamResponse;
use EasySwoole\WeChat\Kernel\ServiceProviders;
use EasySwoole\WeChat\Work\BaseClient;

/**
 * Class Client
 * @package EasySwoole\WeChat\Work\Media
 * @author: XueSi
 * @email: <1592328848@qq.com>
 */
class Client extends BaseClient
{
    /** @var string[] */
    protected $allowTypes = ['image', 'voice', 'video', 'file'];

    /**
     * Get media
     * 获取临时素材
     * doc link: https://work.weixin.qq.com/api/doc/90000/90135/90254
     *
     * @param string $mediaId
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function get(string $mediaId)
    {
        $query = [
            'media_id' => $mediaId,
            'access_token' => $this->app[ServiceProviders::AccessToken]->getToken()
        ];

        $response = $this->getClient()
            ->setMethod('GET')
            ->send($this->buildUrl(
                '/cgi-bin/media/get',
                $query
            ));

        if (false !== stripos($response->getHeaderLine('Content-disposition'), 'attachment')) {
            return new StreamResponse($response->getBody());
        }

        return $this->checkResponse($response);
    }

    /**
     * 上传临时素材(图片)
     * Upload Image
     * doc link: https://work.weixin.qq.com/api/doc/90000/90135/90256
     *
     * @param string $path
     * @param array $form
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function uploadImage(string $path, array $form = [])
    {
        return $this->upload('image', $path, $form);
    }

    /**
     * 上传临时素材(语音)
     * Upload Voice
     * doc link: https://work.weixin.qq.com/api/doc/90000/90135/90256
     *
     * @param string $path
     * @param array $form
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function uploadVoice(string $path, array $form = [])
    {
        return $this->upload('voice', $path, $form);
    }

    /**
     * 上传临时素材(视频)
     * Upload Voice
     * doc link: https://work.weixin.qq.com/api/doc/90000/90135/90256
     *
     * @param string $path
     * @param array $form
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function uploadVideo(string $path, array $form = [])
    {
        return $this->upload('video', $path, $form);
    }

    /**
     * 上传临时素材(普通文件)
     * Upload File
     * doc link: https://work.weixin.qq.com/api/doc/90000/90135/90253
     *
     * @param string $path
     * @param array $form
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function uploadFile(string $path, array $form = [])
    {
        return $this->upload('file', $path, $form);
    }

    /**
     * @param string $type
     * @param string $path
     * @param array $formData
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    protected function upload(string $type, string $path, array $formData = [])
    {
        if (!in_array($type, $this->allowTypes, true)) {
            throw new InvalidArgumentException(sprintf("Unsupported media type: '%s'", $type));
        }

        if (!file_exists($path) || !is_readable($path)) {
            throw new InvalidArgumentException(sprintf("File does not exist, or the file is unreadable: '%s'", $path));
        }

        $client = $this->getClient()->setMethod('POST')->addFile($path, 'media');

        foreach ($formData as $key => $value) {
            $client = $client->addData($value, $key);
        }

        $response = $client->send($this->buildUrl(
            '/cgi-bin/media/upload',
            [
                'access_token' => $this->app[ServiceProviders::AccessToken]->getToken(),
                'type' => $type
            ]
        ));

        $this->checkResponse($response, $parseData);
        return $parseData;
    }
}