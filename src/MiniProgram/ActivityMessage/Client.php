<?php

namespace EasySwoole\WeChat\MiniProgram\ActivityMessage;


use EasySwoole\WeChat\Kernel\Exceptions\InvalidArgumentException;
use EasySwoole\WeChat\Kernel\ServiceProviders;
use EasySwoole\WeChat\MiniProgram\BaseClient;

/**
 * Class Client
 * @package EasySwoole\WeChat\MiniProgram\ActivityMessage
 * @author: XueSi
 * @email: <1592328848@qq.com>
 * doc link: https://developers.weixin.qq.com/miniprogram/dev/api-backend/open-api/updatable-message/updatableMessage.createActivityId.html
 * desc 微信小程序-动态消息
 */
class Client extends BaseClient
{

    /**
     * updatableMessage.createActivityId
     * 创建被分享动态消息或私密消息的 activity_id
     * doc link: https://developers.weixin.qq.com/miniprogram/dev/api-backend/open-api/updatable-message/updatableMessage.createActivityId.html
     *
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function createActivityId()
    {
        $response = $this->getClient()
            ->setMethod('GET')
            ->send($this->buildUrl(
                '/cgi-bin/message/wxopen/activityid/create',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()])
            );

        $this->checkResponse($response, $parseData);

        return $parseData;
    }

    /**
     * updatableMessage.setUpdatableMsg
     * 修改被分享的动态消息
     * doc link: https://developers.weixin.qq.com/miniprogram/dev/api-backend/open-api/updatable-message/updatableMessage.setUpdatableMsg.html
     *
     * @param string $activityId
     * @param int $state
     * @param array $params
     * @return bool
     * @throws InvalidArgumentException
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function updateMessage(string $activityId, int $state = 0, array $params = [])
    {
        if (!in_array($state, [0, 1], true)) {
            throw new InvalidArgumentException('"state" should be "0" or "1".');
        }

        $params = $this->formatParameters($params);

        $params = [
            'activity_id' => $activityId,
            'target_state' => $state,
            'template_info' => ['parameter_list' => $params],
        ];

        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/cgi-bin/message/wxopen/updatablemsg/send',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()])
            );

        return $this->checkResponse($response);
    }

    /**
     * @param array $params
     *
     * @return array
     *
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\InvalidArgumentException
     */
    protected function formatParameters(array $params)
    {
        $formatted = [];

        foreach ($params as $name => $value) {
            if (!in_array($name, ['member_count', 'room_limit', 'path', 'version_type'], true)) {
                continue;
            }

            if ('version_type' === $name && !in_array($value, ['develop', 'trial', 'release'], true)) {
                throw new InvalidArgumentException('Invalid value of attribute "version_type".');
            }

            $formatted[] = [
                'name' => $name,
                'value' => strval($value),
            ];
        }

        return $formatted;
    }
}