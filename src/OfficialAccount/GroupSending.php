<?php
/**
 * Created by PhpStorm.
 * User: EZ
 * Date: 2020/4/7
 * Time: 23:39
 */

namespace EasySwoole\WeChat\OfficialAccount;


use EasySwoole\WeChat\Bean\OfficialAccount\GroupSendingMessage\RequestedReplyMsg;
use EasySwoole\WeChat\Bean\OfficialAccount\RequestConst;
use EasySwoole\WeChat\Exception\OfficialAccountError;
use EasySwoole\WeChat\Utility\NetWork;

class GroupSending extends OfficialAccountBase
{

    // 根据标签进行群发
    public function sendAllTag(RequestedReplyMsg $requestedReplyMsg)
    {
        $url = ApiUrl::generateURL(ApiUrl::MESSAGE_MASS_SEND_ALL, [
            'ACCESS_TOKEN' => $this->getOfficialAccount()->accessToken()->getToken()
        ]);

        return $this->send($url, $requestedReplyMsg);
    }

    // 根据OPENID进行群发
    public function sendAllOpenID(RequestedReplyMsg $requestedReplyMsg)
    {
        if (!is_array($requestedReplyMsg->getTouser())) {
            throw new OfficialAccountError('touser is not array');
        }

        $url = ApiUrl::generateURL(ApiUrl::MESSAGE_MASS_SEND, [
            'ACCESS_TOKEN' => $this->getOfficialAccount()->accessToken()->getToken()
        ]);

        return $this->send($url, $requestedReplyMsg);

    }


    /**
     * 获取群发速度
     *
     * @return array
     * @throws OfficialAccountError
     * @throws \EasySwoole\HttpClient\Exception\InvalidUrl
     * @throws \EasySwoole\WeChat\Exception\RequestError
     */
    public function getSendingSpeed()
    {
        $url = ApiUrl::generateURL(ApiUrl::MESSAGE_MASS_SPEED_GET, [
            'ACCESS_TOKEN' => $this->getOfficialAccount()->accessToken()->getToken()
        ]);

        $response = NetWork::postForJson($url,[]);

        $this->hasException($response);

        return $response;
    }

    /**
     * 设置群发速度
     *
     * @param int $speed
     * @param int $realspeed
     *
     * @return array
     * @throws OfficialAccountError
     * @throws \EasySwoole\HttpClient\Exception\InvalidUrl
     * @throws \EasySwoole\WeChat\Exception\RequestError
     */
    public function setSendingSpeed(int $speed)
    {

        if ($speed < 0 || $speed > 4) {
            throw new OfficialAccountError('speed is not 0 - 4');
        }

        $url = ApiUrl::generateURL(ApiUrl::MESSAGE_MASS_SPEED_SET, [
            'ACCESS_TOKEN' => $this->getOfficialAccount()->accessToken()->getToken()
        ]);

        $response = NetWork::postForJson($url, ['speed' => $speed]);

        $this->hasException($response);

        return $response;
    }

    /**
     * 查询群发状态
     *
     * @param int $msgId
     *
     * @return array
     * @throws OfficialAccountError
     * @throws \EasySwoole\HttpClient\Exception\InvalidUrl
     * @throws \EasySwoole\WeChat\Exception\RequestError
     */
    public function queryState(int $msgId)
    {
        $url = ApiUrl::generateURL(ApiUrl::MESSAGE_MASS_GET, [
            'ACCESS_TOKEN' => $this->getOfficialAccount()->accessToken()->getToken()
        ]);

        $response = NetWork::postForJson($url, ['msg_id' => $msgId]);

        $this->hasException($response);

        return $response;
    }

    /**
     * 发送预览信息
     *
     * @param RequestedReplyMsg $requestedReplyMsg
     *
     * @return array
     * @throws OfficialAccountError
     * @throws \EasySwoole\HttpClient\Exception\InvalidUrl
     * @throws \EasySwoole\WeChat\Exception\RequestError
     */
    public function sendPreview(RequestedReplyMsg $requestedReplyMsg)
    {
        $url = ApiUrl::generateURL(ApiUrl::MESSAGE_MASS_PREVIEW, [
            'ACCESS_TOKEN' => $this->getOfficialAccount()->accessToken()->getToken()
        ]);

        $response = NetWork::postForJson($url, $requestedReplyMsg->buildMessage());

        $this->hasException($response);

        return $response;
    }

    /**
     * 删除群发信息
     *
     * @param int $msgId
     * @param int $articleIdx
     *
     * @return bool
     * @throws OfficialAccountError
     * @throws \EasySwoole\HttpClient\Exception\InvalidUrl
     * @throws \EasySwoole\WeChat\Exception\RequestError
     */
    public function delete(int $msgId, int $articleIdx = 0)
    {
        $url = ApiUrl::generateURL(ApiUrl::MESSAGE_MASS_DELETE, [
            'ACCESS_TOKEN' => $this->getOfficialAccount()->accessToken()->getToken()
        ]);

        $response = NetWork::postForJson($url, ['msg_id' => $msgId, 'article_idx' => $articleIdx]);

        $this->hasException($response);

        return true;
    }

    /**
     * 执行发送
     *
     * @param string            $url
     * @param RequestedReplyMsg $requestedReplyMsg
     *
     * @return bool
     * @throws OfficialAccountError
     * @throws \EasySwoole\HttpClient\Exception\InvalidUrl
     * @throws \EasySwoole\WeChat\Exception\RequestError
     */
    protected function send(string $url, RequestedReplyMsg $requestedReplyMsg)
    {

        if ($requestedReplyMsg->getMsgType() === RequestConst::MSG_TYPE_MPVIDEO && $requestedReplyMsg->getIsTemporary() === true) {
            $url = ApiUrl::generateURL(ApiUrl::MEDIA_TO_VIDEO, [
                'ACCESS_TOKEN' => $this->getOfficialAccount()->accessToken()->getToken()
            ]);

            $data = [
                'media_id'    => $requestedReplyMsg->getMediaId(),
                'title'       => $requestedReplyMsg->getTitle(),
                'description' => $requestedReplyMsg->getDescription()
            ];

            $responseInfo = NetWork::postForJson($url, $data);

            $this->hasException($responseInfo);

            $requestedReplyMsg->setMediaId($responseInfo['media_id']);
        }

        $response = NetWork::postForJson($url, $requestedReplyMsg->buildMessage());

        $this->hasException($response);

        return true;
    }

}