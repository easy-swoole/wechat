<?php

namespace EasySwoole\WeChat\Work\GroupRobot;


use EasySwoole\WeChat\Kernel\ServiceProviders;
use EasySwoole\WeChat\Work\BaseClient;

class Client extends BaseClient
{
    /**
     * @param $message
     * @return Messenger
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\InvalidArgumentException
     */
    public function message($message)
    {
        return (new Messenger($this))->message($message);
    }

    /**
     * 使用群机器人
     * doc link: https://open.work.weixin.qq.com/api/doc/90000/90136/91770#如何使用群机器人
     *
     * @param string $key
     * @param array $message
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function send(string $key, array $message)
    {
        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($message))
            ->send($this->buildUrl(
                '/cgi-bin/webhook/send',
                ['key' => $key,]
            ));

        $this->checkResponse($response, $jsonData);
        return $jsonData;
    }

    /**
     * 文件上传接口
     * doc link: https://open.work.weixin.qq.com/api/doc/90000/90136/91770#文件上传接口
     *
     * @param string $path
     * @param string $key
     * @param array $formData
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function uploadMedia(string $path, string $key, array $formData = [])
    {
        $client = $this->getClient()
            ->setMethod('POST')
            ->addFile($path, 'media');

        foreach ($formData as $k => $v) {
            $client = $client->addData($v, $k);
        }

        $response = $client->send($this->buildUrl(
            '/cgi-bin/webhook/upload_media',
            [
                'key' => $key,
                'type' => 'file'
            ]
        ));

        $this->checkResponse($response, $jsonData);
        return $jsonData;
    }
}
