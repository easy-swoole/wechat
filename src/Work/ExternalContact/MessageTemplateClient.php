<?php

namespace EasySwoole\WeChat\Work\ExternalContact;

use EasySwoole\WeChat\Kernel\Exceptions\InvalidArgumentException;
use EasySwoole\WeChat\Kernel\ServiceProviders;
use EasySwoole\WeChat\Work\BaseClient;

/**
 * Class MessageTemplateClient
 * @package EasySwoole\WeChat\Work\ExternalContact
 * @author: XueSi
 * @email: <1592328848@qq.com>
 */
class MessageTemplateClient extends BaseClient
{
    /**
     * Required attributes.
     * @var array
     */
    protected $required = ['title', 'url', 'pic_media_id', 'appid', 'page'];

    protected $textMessage = [
        'content' => '',
    ];

    protected $imageMessage = [
        'media_id' => '',
        'pic_url' => '',
    ];

    protected $linkMessage = [
        'title' => '',
        'picurl' => '',
        'desc' => '',
        'url' => '',
    ];

    protected $miniprogramMessage = [
        'title' => '',
        'pic_media_id' => '',
        'appid' => '',
        'page' => '',
    ];

    /**
     * 添加入群欢迎语素材
     * doc link: https://work.weixin.qq.com/api/doc/90000/90135/92366#添加入群欢迎语素材
     *
     * @param array $msgTemplate
     * @return mixed
     * @throws InvalidArgumentException
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function create(array $msgTemplate)
    {
        $params = $this->formatMessage($msgTemplate);

        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/cgi-bin/externalcontact/group_welcome_template/add',
                [
                    'access_token' => $this->app[ServiceProviders::AccessToken]->getToken()
                ]
            ));

        $this->checkResponse($response, $jsonData);
        return $jsonData;
    }

    /**
     * 编辑入群欢迎语素材
     * doc link: https://work.weixin.qq.com/api/doc/90000/90135/92366#编辑入群欢迎语素材
     *
     * @param string $templateId
     * @param array $msgTemplate
     * @return bool
     * @throws InvalidArgumentException
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function update(string $templateId, array $msgTemplate)
    {
        $params = $this->formatMessage($msgTemplate);
        $params = array_merge([
            'template_id' => $templateId,
        ], $params);

        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/cgi-bin/externalcontact/group_welcome_template/edit',
                [
                    'access_token' => $this->app[ServiceProviders::AccessToken]->getToken()
                ]
            ));

        return $this->checkResponse($response);
    }

    /**
     * 获取入群欢迎语素材
     * doc link: https://work.weixin.qq.com/api/doc/90000/90135/92366#获取入群欢迎语素材
     *
     * @param string $templateId
     * @return bool
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function get(string $templateId)
    {
        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream([
                'template_id' => $templateId,
            ]))
            ->send($this->buildUrl(
                '/cgi-bin/externalcontact/group_welcome_template/get',
                [
                    'access_token' => $this->app[ServiceProviders::AccessToken]->getToken()
                ]
            ));

        $this->checkResponse($response, $jsonData);
        return $jsonData;
    }

    /**
     * 删除入群欢迎语素材
     * doc link: https://work.weixin.qq.com/api/doc/90000/90135/92366#删除入群欢迎语素材
     *
     * @param string $templateId
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function delete(string $templateId)
    {
        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream([
                'template_id' => $templateId,
            ]))
            ->send($this->buildUrl(
                '/cgi-bin/externalcontact/group_welcome_template/del',
                [
                    'access_token' => $this->app[ServiceProviders::AccessToken]->getToken()
                ]
            ));

        return $this->checkResponse($response);
    }

    /**
     * @throws InvalidArgumentException
     * @return array
     */
    protected function formatMessage(array $data = [])
    {
        $params = $data;

        if (!empty($params['text'])) {
            $params['text'] = $this->formatFields($params['text'], $this->textMessage);
        }

        if (!empty($params['image'])) {
            $params['image'] = $this->formatFields($params['image'], $this->imageMessage);
        }

        if (!empty($params['link'])) {
            $params['link'] = $this->formatFields($params['link'], $this->linkMessage);
        }

        if (!empty($params['miniprogram'])) {
            $params['miniprogram'] = $this->formatFields($params['miniprogram'], $this->miniprogramMessage);
        }

        return $params;
    }

    /**
     * @throws InvalidArgumentException
     * @return array
     */
    protected function formatFields(array $data = [], array $default = [])
    {
        $params = array_merge($default, $data);
        foreach ($params as $key => $value) {
            if (in_array($key, $this->required, true) && empty($value) && empty($default[$key])) {
                throw new InvalidArgumentException(sprintf('Attribute "%s" can not be empty!', $key));
            }

            $params[$key] = empty($value) ? $default[$key] : $value;
        }

        return $params;
    }
}