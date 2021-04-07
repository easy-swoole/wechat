<?php

namespace EasySwoole\WeChat\MiniProgram\UniformMessage;

use EasySwoole\WeChat\Kernel\Exceptions\InvalidArgumentException;
use EasySwoole\WeChat\MiniProgram\BaseClient;

/**
 * Class Client
 * @package EasySwoole\WeChat\MiniProgram\UniformMessage
 * @author: XueSi
 * @email: <1592328848@qq.com>
 * doc link:
 */
class Client extends BaseClient
{
    public const API_SEND = '';

    /**
     * @var array
     */
    protected $message = [
        'touser' => '',
    ];

    /**
     * Weapp Attributes.
     *
     * @var array
     */
    protected $weappMessage = [
        'template_id' => '',
        'page' => '',
        'form_id' => '',
        'data' => [],
        'emphasis_keyword' => '',
    ];

    /**
     * Official account attributes.
     *
     * @var array
     */
    protected $mpMessage = [
        'appid' => '',
        'template_id' => '',
        'url' => '',
        'miniprogram' => [],
        'data' => [],
    ];

    /**
     * Required attributes.
     *
     * @var array
     */
    protected $required = ['touser', 'template_id', 'form_id', 'miniprogram', 'appid'];

    /**
     * uniformMessage.send
     * 下发小程序和公众号统一的服务消息
     *
     * @param array $data
     * @return bool
     * @throws InvalidArgumentException
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function send(array $data = [])
    {
        $params = $this->formatMessage($data);

        $this->restoreMessage();

        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/cgi-bin/message/wxopen/template/uniform_send',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()])
            );

        return $this->checkResponse($response);
    }

    /**
     * Restore message.
     */
    protected function restoreMessage()
    {
        $this->message = (new \ReflectionClass(static::class))->getDefaultProperties()['message'];
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
        $params = array_merge($this->message, $data);

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
    protected function formatWeappMessage(array $data = [])
    {
        $params = $this->baseFormat($data, $this->weappMessage);

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
        $params = $this->baseFormat($data, $this->mpMessage);

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
            if (in_array($key, $this->required, true) && empty($value) && empty($default[$key])) {
                throw new InvalidArgumentException(sprintf('Attribute "%s" can not be empty!', $key));
            }

            $params[$key] = empty($value) ? $default[$key] : $value;
        }

        return $params;
    }

    /**
     * @param array $data
     * @return array
     */
    protected function formatData(array $data)
    {
        $formatted = [];

        foreach ($data as $key => $value) {
            if (is_array($value)) {
                if (\array_key_exists('value', $value)) {
                    $formatted[$key] = $value;

                    continue;
                }

                if (count($value) >= 2) {
                    $value = [
                        'value' => $value[0],
                        'color' => $value[1],
                    ];
                }
            } else {
                $value = [
                    'value' => strval($value),
                ];
            }

            $formatted[$key] = $value;
        }

        return $formatted;
    }
}