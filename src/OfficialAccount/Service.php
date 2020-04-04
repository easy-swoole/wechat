<?php
/**
 * Created by PhpStorm.
 * User: EZ
 * Date: 2020/3/31
 * Time: 22:58
 */

namespace EasySwoole\WeChat\OfficialAccount;


use EasySwoole\HttpClient\Exception\InvalidUrl;
use EasySwoole\Utility\Mime\MimeDetectorException;
use EasySwoole\Utility\MimeType;
use EasySwoole\Utility\Random;
use EasySwoole\WeChat\Bean\OfficialAccount\ServiceMessage\RequestedReplyMsg;
use EasySwoole\WeChat\Bean\PostFile;
use EasySwoole\WeChat\Exception\OfficialAccountError;
use EasySwoole\WeChat\Exception\RequestError;
use EasySwoole\WeChat\Utility\NetWork;
use EasySwoole\WeChat\Bean\OfficialAccount\CustomerService;
use Swoole\Coroutine;

class Service extends OfficialAccountBase
{
    /**
     * 添加客服账号
     *
     * @param CustomerService $service
     *
     * @return bool
     * @throws InvalidUrl
     * @throws OfficialAccountError
     * @throws RequestError
     */
    public function create(CustomerService $service) : bool
    {
        $url = ApiUrl::generateURL(ApiUrl::CUSTOM_SERVICE_KF_ACCOUNT_ADD, [
            'ACCESS_TOKEN' => $this->getOfficialAccount()->accessToken()->getToken()
        ]);

        $data = [
            'kf_account' => $service->getKfAccount(),
            'nickname' => $service->getNickname(),
        ];
        $response = NetWork::postJsonForJson($url, $data);

        $this->hasException($response);

        return true;
    }

    /**
     * 修改客服账号
     *
     * @param CustomerService $service
     *
     * @return bool
     * @throws InvalidUrl
     * @throws OfficialAccountError
     * @throws RequestError
     */
    public function update(CustomerService $service) : bool
    {
        $url = ApiUrl::generateURL(ApiUrl::CUSTOM_SERVICE_KF_ACCOUNT_UPDATE, [
            'ACCESS_TOKEN' => $this->getOfficialAccount()->accessToken()->getToken()
        ]);

        $data = [
            'kf_account' => $service->getKfAccount(),
            'nickname' => $service->getNickname(),
        ];
        $response = NetWork::postJsonForJson($url, $data);

        $this->hasException($response);

        return true;
    }

    /**
     * 删除客服账号
     *
     * @param string $kfAccount
     *
     * @return bool
     * @throws InvalidUrl
     * @throws OfficialAccountError
     * @throws RequestError
     */
    public function delete(string $kfAccount) : bool
    {
        $url = ApiUrl::generateURL(ApiUrl::CUSTOM_SERVICE_KF_ACCOUNT_DELETE, [
            'ACCESS_TOKEN' => $this->getOfficialAccount()->accessToken()->getToken()
        ]);

        $data = [
            'kf_account' => $kfAccount
        ];
        $response = NetWork::postJsonForJson($url, $data);

        $this->hasException($response);

        return true;
    }

    /**
     * 上传客服头像
     *
     * @param string   $kfAccount
     * @param PostFile $postFile
     * @return bool
     * @throws InvalidUrl
     * @throws OfficialAccountError
     * @throws MimeDetectorException
     */
    public function setAvatar(string $kfAccount, PostFile $postFile) : bool
    {
        $url = ApiUrl::generateURL(ApiUrl::CUSTOM_SERVICE_KF_ACCOUNT_UPLOAD_HEAD_IMG, [
            'ACCESS_TOKEN' => $this->getOfficialAccount()->accessToken()->getToken(),
            'KF_ACCOUNT'    => $kfAccount,
        ]);

        return $this->uploadAvatar($url, $this->crateFileBean($postFile));
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
     * @throws InvalidUrl
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
     * @throws InvalidUrl
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
     * @throws InvalidUrl
     */
    public function sendServiceMsg(RequestedReplyMsg $requestedReplyMsg) : bool
    {
        $url = ApiUrl::generateURL(ApiUrl::MESSAGE_CUSTOM_SEND, [
            'ACCESS_TOKEN' => $this->getOfficialAccount()->accessToken()->getToken()
        ]);

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
     * @throws InvalidUrl
     */
    public function sendServiceCommand(RequestedReplyMsg $requestedReplyMsg) : bool
    {
        $url = ApiUrl::generateURL(ApiUrl::MESSAGE_CUSTOM_TYPING, [
            'ACCESS_TOKEN' => $this->getOfficialAccount()->accessToken()->getToken()
        ]);

        $response = NetWork::postForJson($url, $requestedReplyMsg->buildMessage());

        $this->hasException($response);

        return true;
    }

    /**
     * 创建一个文件对象
     *
     * @param PostFile $fileBean
     * @return PostFile
     * @throws MimeDetectorException
     * @throws OfficialAccountError
     */
    protected function crateFileBean(PostFile $fileBean) : PostFile
    {
        if (empty($fileBean->getData())) {
            if (!is_null($fileBean->getPath())) {
                $fileBean->setData(Coroutine::readFile($fileBean->getPath()));
                $fileBean->setFilename(basename($fileBean->getPath()));
            }
            throw new OfficialAccountError('upload file is empty.');
        }

        if (empty($fileBean->getMimeType())) {
            $fileBean->setMimeType(MimeType::getMimeTypeFromStream($fileBean->getData()));
        }

        if (empty($fileBean->getFilename())) {
            $filename = Random::character(). MimeType::getExtByMimeType($fileBean->getMimeType());
            $fileBean->setFilename($filename);
        }

        $fileBean->setName('media');
        return $fileBean;
    }


}