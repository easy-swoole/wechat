<?php

namespace EasySwoole\WeChat\Work\Chat;

use EasySwoole\WeChat\Kernel\ServiceProviders;
use EasySwoole\WeChat\Work\BaseClient;

/**
 * Class Client
 * @package EasySwoole\WeChat\Work\Chat
 * @author: XueSi
 * @email: <1592328848@qq.com>
 */
class Client extends BaseClient
{
    /**
     * Get chat.
     * 获取群聊会话
     * doc link: https://work.weixin.qq.com/api/doc/90000/90135/90247
     *
     * @param string $chatId
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function get(string $chatId)
    {
        $query = [
            'chatid' => $chatId,
            'access_token' => $this->app[ServiceProviders::AccessToken]->getToken()
        ];

        $response = $this->getClient()
            ->setMethod('GET')
            ->send($this->buildUrl(
                '/cgi-bin/appchat/get',
                $query
            ));

        $this->checkResponse($response, $jsonData);
        return $jsonData;
    }

    /**
     * Create chat.
     * 创建群聊会话
     * doc link: https://work.weixin.qq.com/api/doc/90000/90135/90245
     *
     * @param array $data
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function create(array $data)
    {
        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($data))
            ->send($this->buildUrl(
                '/cgi-bin/appchat/create',
                [
                    'access_token' => $this->app[ServiceProviders::AccessToken]->getToken()
                ]
            ));

        $this->checkResponse($response, $jsonData);
        return $jsonData;
    }

    /**
     * Update chat.
     * 修改群聊会话
     * doc link: https://work.weixin.qq.com/api/doc/90000/90135/90246
     *
     * @param string $chatId
     * @param array $data
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function update(string $chatId, array $data)
    {
        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream(array_merge(['chatid' => $chatId], $data)))
            ->send($this->buildUrl(
                '/cgi-bin/appchat/update',
                [
                    'access_token' => $this->app[ServiceProviders::AccessToken]->getToken()
                ]
            ));

        return $this->checkResponse($response);
    }

    /**
     * Send a message.
     * 应用推送消息
     * doc link: https://work.weixin.qq.com/api/doc/90000/90135/90248
     *
     * @param array $message
     * @return bool
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function send(array $message)
    {
        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($message))
            ->send($this->buildUrl(
                '/cgi-bin/appchat/send',
                [
                    'access_token' => $this->app[ServiceProviders::AccessToken]->getToken()
                ]
            ));

        return $this->checkResponse($response);
    }
}