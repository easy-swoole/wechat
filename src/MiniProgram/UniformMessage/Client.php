<?php

namespace EasySwoole\WeChat\MiniProgram\UniformMessage;

use EasySwoole\WeChat\Kernel\Exceptions\InvalidArgumentException;
use EasySwoole\WeChat\Kernel\ServiceProviders;
use EasySwoole\WeChat\OfficialAccount\TemplateMessage\Client as BaseClient;
use EasySwoole\WeChat\Kernel\Exceptions\HttpException;

/**
 * Class Client
 * @package EasySwoole\WeChat\MiniProgram\UniformMessage
 * @author: XueSi
 * @email: <1592328848@qq.com>
 * doc link: https://developers.weixin.qq.com/miniprogram/dev/api-backend/open-api/uniform-message/uniformMessage.send.html
 */
class Client extends BaseClient
{
    public const API_SEND = '/cgi-bin/message/wxopen/template/uniform_send';

    /**
     * @return string[]
     */
    protected function messageTemplate(): array
    {
        return [
            'touser' => '',
        ];
    }

    /**
     * @return array
     */
    protected function weAppMessageTemplate(): array
    {
        return [
            'template_id' => '',
            'page' => '',
            'form_id' => '',
            'data' => [],
            'emphasis_keyword' => '',
        ];
    }

    /**
     * @return array
     */
    protected function mpMessageTemplate()
    {
        return [
            'appid' => '',
            'template_id' => '',
            'url' => '',
            'miniprogram' => [],
            'data' => [],
        ];
    }

    /**
     * @return string[]
     */
    protected function requiredKeys(): array
    {
        return ['touser', 'template_id', 'form_id', 'miniprogram', 'appid'];
    }

    /**
     * uniformMessage.send
     * 下发小程序和公众号统一的服务消息
     * doc link:
     *
     * @param array $data
     * @return bool
     * @throws InvalidArgumentException
     * @throws HttpException
     */
    public function send(array $data = [])
    {
        $params = $this->formatMessage($data);

        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                self::API_SEND,
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()])
            );

        return $this->checkResponse($response);
    }

    /**
     * @param array $data
     *
     * @return array
     *
     * @throws InvalidArgumentException
     */
    protected function formatMessage(array $data = [])
    {
        $message = $this->messageTemplate();
        $params = array_merge($message, $data);

        if (empty($params['touser'])) {
            throw new InvalidArgumentException(sprintf('Attribute "touser" can not be empty!'));
        }

        if (!empty($params['weapp_template_msg'])) {
            $params['weapp_template_msg'] = $this->formatWeappMessage($params['weapp_template_msg']);
        }

        if (!empty($params['mp_template_msg'])) {
            $params['mp_template_msg'] = $this->formatMpMessage($params['mp_template_msg']);
        }

        return $params;
    }

    /**
     * @param array $data
     * @return array
     * @throws InvalidArgumentException
     */
    protected function formatWeAppMessage(array $data = [])
    {
        $params = $this->baseFormat($data, $this->weAppMessageTemplate());

        $params['data'] = $this->formatData($params['data'] ?? []);

        return $params;
    }

    /**
     * @param array $data
     * @return array
     * @throws InvalidArgumentException
     */
    protected function formatMpMessage(array $data = [])
    {
        $params = $this->baseFormat($data, $this->mpMessageTemplate());

        if (empty($params['miniprogram']['appid'])) {
            $params['miniprogram']['appid'] = $this->app['config']['app_id'];
        }

        $params['data'] = $this->formatData($params['data'] ?? []);

        return $params;
    }

    /**
     * @param array $data
     * @param array $default
     * @return array
     * @throws InvalidArgumentException
     */
    protected function baseFormat($data = [], $default = [])
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
