<?php

namespace EasySwoole\WeChat\Work\ExternalContact;

use EasySwoole\WeChat\Kernel\Exceptions\InvalidArgumentException;
use EasySwoole\WeChat\Kernel\ServiceProviders;
use EasySwoole\WeChat\Work\BaseClient;

/**
 * Class MessageClient
 * @package EasySwoole\WeChat\Work\ExternalContact
 * @author: XueSi
 * @email: <1592328848@qq.com>
 */
class MessageClient extends BaseClient
{
    /**
     * @return string[]
     */
    protected function requiredKeys(): array
    {
        return ['content', 'title', 'url', 'pic_media_id', 'appid', 'page'];
    }

    /**
     * @return array
     */
    protected function textMessageTemplate(): array
    {
        return [
            'content' => '',
        ];
    }

    /**
     * @return array
     */
    protected function imageMessageTemplate(): array
    {
        return [];
    }

    /**
     * @return array
     */
    protected function linkMessageTemplate(): array
    {
        return [
            'title' => '',
            'picurl' => '',
            'desc' => '',
            'url' => '',
        ];
    }

    protected function miniprogramMessageTemplate(): array
    {
        return [
            'title' => '',
            'pic_media_id' => '',
            'appid' => '',
            'page' => '',
        ];
    }

    /**
     * 添加企业群发消息模板
     * 创建企业群发
     * doc link: https://work.weixin.qq.com/api/doc/90000/90135/92135
     *
     * @param array $msg
     * @return mixed
     * @throws InvalidArgumentException
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function submit(array $msg)
    {
        $params = $this->formatMessage($msg);

        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/cgi-bin/externalcontact/add_msg_template',
                [
                    'access_token' => $this->app[ServiceProviders::AccessToken]->getToken()
                ]
            ));

        $this->checkResponse($response, $jsonData);
        return $jsonData;
    }

    /**
     * 获取企业群发成员执行结果
     * doc link: https://open.work.weixin.qq.com/api/doc/16251
     *
     * @param string $msgId
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function get(string $msgId)
    {
        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream([
                'msgid' => $msgId,
            ]))
            ->send($this->buildUrl(
                '/cgi-bin/externalcontact/get_group_msg_result',
                [
                    'access_token' => $this->app[ServiceProviders::AccessToken]->getToken()
                ]
            ));

        $this->checkResponse($response, $jsonData);
        return $jsonData;
    }

    /**
     * 发送新客户欢迎语
     * doc link: https://work.weixin.qq.com/api/doc/90000/90135/92137
     *
     * @param string $welcomeCode
     * @param array $msg
     * @return mixed
     * @throws InvalidArgumentException
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function sendWelcome(string $welcomeCode, array $msg)
    {
        $formattedMsg = $this->formatMessage($msg);

        $params = array_merge($formattedMsg, [
            'welcome_code' => $welcomeCode,
        ]);

        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/cgi-bin/externalcontact/send_welcome_msg',
                [
                    'access_token' => $this->app[ServiceProviders::AccessToken]->getToken()
                ]
            ));

        return $this->checkResponse($response);
    }

    /**
     * @param array $data
     * @return array
     * @throws InvalidArgumentException
     */
    protected function formatMessage(array $data = [])
    {
        $params = $data;

        $textMessage = $this->textMessageTemplate();
        $imageMessage = $this->imageMessageTemplate();
        $linkMessage = $this->linkMessageTemplate();
        $miniprogramMessage = $this->miniprogramMessageTemplate();

        if (!empty($params['text'])) {
            $params['text'] = $this->formatFields($params['text'], $textMessage);
        }

        if (!empty($params['image'])) {
            $params['image'] = $this->formatFields($params['image'], $imageMessage);
        }

        if (!empty($params['link'])) {
            $params['link'] = $this->formatFields($params['link'], $linkMessage);
        }

        if (!empty($params['miniprogram'])) {
            $params['miniprogram'] = $this->formatFields($params['miniprogram'], $miniprogramMessage);
        }

        return $params;
    }

    /**
     * @param array $data
     * @param array $default
     * @return array
     * @throws InvalidArgumentException
     */
    protected function formatFields(array $data = [], array $default = [])
    {
        $params = array_merge($default, $data);
        foreach ($params as $key => $value) {
            if (in_array($key, $this->requiredKeys(), true) && empty($value) && empty($default[$key])) {
                throw new InvalidArgumentException(sprintf('Attribute "%s" can not be empty!', $key));
            }

            $params[$key] = empty($value) ? $default[$key] : $value;
        }

        return $params;
    }
}
