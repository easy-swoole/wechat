<?php

namespace EasySwoole\WeChat\Work\MsgAudit;

use EasySwoole\WeChat\Kernel\ServiceProviders;
use EasySwoole\WeChat\Work\BaseClient;

/**
 * Class Client
 * @package EasySwoole\WeChat\Work\MsgAudit
 * @author: XueSi
 * @email: <1592328848@qq.com>
 */
class Client extends BaseClient
{
    /**
     * 获取会话内容存档开启成员列表
     * doc link: https://work.weixin.qq.com/api/doc/90000/90135/91614
     *
     * @param string|null $type
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function getPermitUsers(string $type = null)
    {
        $data = empty($type) ? [] : ['type' => $type];

        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($data))
            ->send($this->buildUrl(
                '/cgi-bin/msgaudit/get_permit_user_list',
                [
                    'access_token' => $this->app[ServiceProviders::AccessToken]->getToken()
                ]
            ));

        $this->checkResponse($response, $parseData);
        return $parseData;
    }

    /**
     * 获取会话同意情况
     * doc link: https://work.weixin.qq.com/api/doc/90000/90135/91782#获取会话同意情况
     *
     * @param array $info 数组，格式: [[userid, exteranalopenid], [userid, exteranalopenid]]
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function getSingleAgreeStatus(array $info)
    {
        $params = [
            'info' => $info
        ];

        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/cgi-bin/msgaudit/check_single_agree',
                [
                    'access_token' => $this->app[ServiceProviders::AccessToken]->getToken()
                ]
            ));

        $this->checkResponse($response, $parseData);
        return $parseData;
    }

    /**
     * 获取会话同意情况(群聊会话)
     * doc link: https://work.weixin.qq.com/api/doc/90000/90135/91782
     *
     * @param array $info 数组，格式: [[userid, exteranalopenid], [userid, exteranalopenid]]
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function getRoomAgreeStatus(string $roomId)
    {
        $params = [
            'roomid' => $roomId
        ];

        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/cgi-bin/msgaudit/check_room_agree',
                [
                    'access_token' => $this->app[ServiceProviders::AccessToken]->getToken()
                ]
            ));

        $this->checkResponse($response, $parseData);
        return $parseData;
    }

    /**
     * 获取会话内容存档内部群信息
     * doc link: https://work.weixin.qq.com/api/doc/90000/90135/92951
     *
     * @param string $roomId
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function getRoom(string $roomId)
    {
        $params = [
            'roomid' => $roomId
        ];

        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/cgi-bin/msgaudit/groupchat/get',
                [
                    'access_token' => $this->app[ServiceProviders::AccessToken]->getToken()
                ]
            ));

        $this->checkResponse($response, $parseData);
        return $parseData;
    }
}