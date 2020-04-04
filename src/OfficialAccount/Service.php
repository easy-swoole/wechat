<?php
/**
 * Created by PhpStorm.
 * User: EZ
 * Date: 2020/3/31
 * Time: 22:58
 */

namespace EasySwoole\WeChat\OfficialAccount;


use EasySwoole\Utility\MimeType;
use EasySwoole\WeChat\Bean\OfficialAccount\MediaRequest;
use EasySwoole\WeChat\Bean\OfficialAccount\ServiceMessage\RequestedReplyMsg;
use EasySwoole\WeChat\Bean\PostFile;
use EasySwoole\WeChat\Exception\OfficialAccountError;
use EasySwoole\WeChat\Exception\RequestError;
use EasySwoole\WeChat\Utility\NetWork;
use EasySwoole\WeChat\Bean\OfficialAccount\Service as ServiceBean;
use Swoole\Coroutine;

class Service extends OfficialAccountBase
{
    /**
     * 添加客服账号
     *
     * @param ServiceBean $service
     *
     * @return bool
     * @throws \EasySwoole\HttpClient\Exception\InvalidUrl
     * @throws \EasySwoole\WeChat\Exception\OfficialAccountError
     * @throws \EasySwoole\WeChat\Exception\RequestError
     */
    public function addServiceAccount(ServiceBean $service) : bool
    {
        $url = ApiUrl::generateURL(ApiUrl::CUSTOM_SERVICE_KF_ACCOUNT_ADD, [
            'ACCESS_TOKEN' => $this->getOfficialAccount()->accessToken()->getToken()
        ]);

        $response = NetWork::postJsonForJson($url, $service->getSendMessage());

        $this->hasException($response);

        return true;
    }

    /**
     * 修改客服账号
     *
     * @param ServiceBean $service
     *
     * @return bool
     * @throws \EasySwoole\HttpClient\Exception\InvalidUrl
     * @throws \EasySwoole\WeChat\Exception\OfficialAccountError
     * @throws \EasySwoole\WeChat\Exception\RequestError
     */
    public function editServiceAccont(ServiceBean $service) : bool
    {
        $url = ApiUrl::generateURL(ApiUrl::CUSTOM_SERVICE_KF_ACCOUNT_UPDATE, [
            'ACCESS_TOKEN' => $this->getOfficialAccount()->accessToken()->getToken()
        ]);

        $response = NetWork::postJsonForJson($url, $service->getSendMessage());

        $this->hasException($response);

        return true;
    }

    /**
     * 删除客服账号
     *
     * @param ServiceBean $service
     *
     * @return bool
     * @throws \EasySwoole\HttpClient\Exception\InvalidUrl
     * @throws \EasySwoole\WeChat\Exception\OfficialAccountError
     * @throws \EasySwoole\WeChat\Exception\RequestError
     */
    public function delServiceAccont(ServiceBean $service) : bool
    {
        $url = ApiUrl::generateURL(ApiUrl::CUSTOM_SERVICE_KF_ACCOUNT_DELETE, [
            'ACCESS_TOKEN' => $this->getOfficialAccount()->accessToken()->getToken()
        ]);

        $response = NetWork::postJsonForJson($url, $service->getSendMessage());

        $this->hasException($response);

        return true;
    }

    /**
     * 设置客服账户图片
     *
     * @param ServiceBean $serviceBean
     *
     * @return bool
     * @throws OfficialAccountError
     * @throws \EasySwoole\HttpClient\Exception\InvalidUrl
     * @throws \EasySwoole\Utility\Mime\MimeDetectorException
     */
    public function setServiceAvatar(ServiceBean $serviceBean) : bool
    {
        $url = ApiUrl::generateURL(ApiUrl::CUSTOM_SERVICE_KF_ACCOUNT_UPLOAD_HEAD_IMG, [
            'ACCESS_TOKEN' => $this->getOfficialAccount()->accessToken()->getToken(),
            'KFACCOUNT'    => $serviceBean->getKfAccount(),
        ]);

        return $this->uploadAvatar($url, $this->crateFileBean($serviceBean->getMedia()));
    }

    /**
     * 上传客服头像
     *
     * @param string     $url
     * @param PostFile   $fileBean
     * @param array|null $form
     * @param int        $timeout
     *
     * @return bool
     * @throws OfficialAccountError
     * @throws \EasySwoole\HttpClient\Exception\InvalidUrl
     */
    protected function uploadAvatar(string $url, PostFile $fileBean, array $form = null, int $timeout = 30) : bool
    {
        $response = NetWork::uploadFileByPath($url, $fileBean, $form, $timeout);

        $json = $response->getBody();

        $this->hasException(json_decode($json, true));

        return true;
    }

    /**
     * 获取所有客服账号列表
     * @return array
     * @throws OfficialAccountError
     * @throws RequestError
     * @throws \EasySwoole\HttpClient\Exception\InvalidUrl
     */
    public function getAllServiceList() : array
    {
        $url = ApiUrl::generateURL(ApiUrl::CUSTOM_SERVICE_GET_KF_LIST, [
            'ACCESS_TOKEN' => $this->getOfficialAccount()->accessToken()->getToken()
        ]);

        $json = NetWork::getForJson($url);

        $this->hasException($json);

        return $json['kf_list'];
    }


    /**
     * 发送客服消息
     *
     * @param RequestedReplyMsg $requestedReplyMsg
     *
     * @return bool
     * @throws OfficialAccountError
     * @throws RequestError
     * @throws \EasySwoole\HttpClient\Exception\InvalidUrl
     */
    public function sendServiceMsg(RequestedReplyMsg $requestedReplyMsg) : bool
    {
        $url = ApiUrl::generateURL(ApiUrl::MESSAGE_CUSTOM_SEND, [
            'ACCESS_TOKEN' => $this->getOfficialAccount()->accessToken()->getToken()
        ]);

        var_dump($requestedReplyMsg->buildMessage());

        $response = NetWork::postForJson($url, $requestedReplyMsg->buildMessage());

        $this->hasException($response);

        return true;
    }

    /**
     * 发送输入状态
     *
     * @param RequestedReplyMsg $requestedReplyMsg
     *
     * @return bool
     * @throws OfficialAccountError
     * @throws RequestError
     * @throws \EasySwoole\HttpClient\Exception\InvalidUrl
     */
    public function sendServiceCommand(RequestedReplyMsg $requestedReplyMsg) : bool
    {
        $url = ApiUrl::generateURL(ApiUrl::MESSAGE_CUSTOM_TYPING, [
            'ACCESS_TOKEN' => $this->getOfficialAccount()->accessToken()->getToken()
        ]);

        var_dump($requestedReplyMsg->buildMessage());

        $response = NetWork::postForJson($url, $requestedReplyMsg->buildMessage());

        $this->hasException($response);

        return true;
    }

    /**
     * 创建一个文件对象
     *
     * @param MediaRequest $mediaBean
     *
     * @return PostFile
     * @throws \EasySwoole\Utility\Mime\MimeDetectorException
     */
    protected function crateFileBean(MediaRequest $mediaBean) : PostFile
    {
        $fileBean = new PostFile($mediaBean->toArray(null, MediaRequest::FILTER_NOT_EMPTY));
        $fileBean->setName('media');

        if (!is_null($fileBean->getPath())) {
            $fileBean->setData(Coroutine::readFile($fileBean->getPath()));
        }
        $fileBean->setFilename(basename($fileBean->getPath()));
        $fileBean->setMimeType(MimeType::getMimeTypeFromStream($fileBean->getData()));
        $fileBean->setFilename($fileBean->getFilename());

        return $fileBean;
    }


}