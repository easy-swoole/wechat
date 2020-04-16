<?php


namespace EasySwoole\WeChat\MiniProgram;

use EasySwoole\WeChat\Exception\MiniProgramError;
use EasySwoole\WeChat\Utility\NetWork;

/**
 * 小程序订阅消息
 * Class SubscribeMsg
 * @package EasySwoole\WeChat\MiniProgram
 */
class SubscribeMsg extends MinProgramBase
{

    /**
     * 获取小程序账号的类目（订阅消息）
     * @return array
     * @throws MiniProgramError
     * @throws \EasySwoole\HttpClient\Exception\InvalidUrl
     * @throws \EasySwoole\WeChat\Exception\RequestError
     */
    public function getCategory()
    {
        $token = $this->getMiniProgram()->accessToken()->getToken();
        $url = ApiUrl::generateURL(ApiUrl::GET_CATEGORY, [
            'ACCESS_TOKEN' => $token
        ]);
        $responseArray = NetWork::getForJson($url, []);
        $ex = MiniProgramError::hasException($responseArray);
        if ($ex) {
            throw $ex;
        }
        return $responseArray;
    }

    /**
     * 获取帐号所属类目下的公共模板标题（订阅消息）
     * @param array $data
     * @return mixed
     * @throws MiniProgramError
     * @throws \EasySwoole\HttpClient\Exception\InvalidUrl
     * @throws \EasySwoole\WeChat\Exception\RequestError
     */
    public function getPubTemplateTitleList(array $data)
    {
        $token = $this->getMiniProgram()->accessToken()->getToken();
        $url = ApiUrl::generateURL(ApiUrl::GET_PUB_TEMPLATE_TITLES, [
            'ACCESS_TOKEN' => $token
        ]);
        $responseArray = NetWork::getForJson($url, $data);
        $ex = MiniProgramError::hasException($responseArray);
        if ($ex) {
            throw $ex;
        }
        return $responseArray;
    }

    /**
     * 获取模板标题下的关键词列表（订阅消息）
     * @param array $data
     * @return array
     * @throws MiniProgramError
     * @throws \EasySwoole\HttpClient\Exception\InvalidUrl
     * @throws \EasySwoole\WeChat\Exception\RequestError
     */
    public function getPubTemplateKeyWordsById(array $data)
    {
        $token = $this->getMiniProgram()->accessToken()->getToken();
        $url = ApiUrl::generateURL(ApiUrl::GET_PUB_TEMPLATE_KEYWORDS, [
            'ACCESS_TOKEN' => $token
        ]);
        $responseArray = NetWork::getForJson($url, $data);
        $ex = MiniProgramError::hasException($responseArray);
        if ($ex) {
            throw $ex;
        }
        return $responseArray;
    }

    /**
     * 删除帐号下的个人模板（订阅消息）
     * @return array
     * @throws MiniProgramError
     * @throws \EasySwoole\HttpClient\Exception\InvalidUrl
     * @throws \EasySwoole\WeChat\Exception\RequestError
     */
    public function deleteTemplate(string $priTmplId)
    {
        $token = $this->getMiniProgram()->accessToken()->getToken();
        $url = ApiUrl::generateURL(ApiUrl::DEL_TEMPLATE, [
            'ACCESS_TOKEN' => $token
        ]);
        $responseArray = NetWork::postJsonForJson($url, $priTmplId);
        $ex = MiniProgramError::hasException($responseArray);
        if ($ex) {
            throw $ex;
        }
        return $responseArray;
    }

    /**
     * 组合模板并添加至帐号下的个人模板库（订阅信息）
     * @return array
     * @throws MiniProgramError
     * @throws \EasySwoole\HttpClient\Exception\InvalidUrl
     * @throws \EasySwoole\WeChat\Exception\RequestError
     */
    public function addTemplate(array $data)
    {
        $token = $this->getMiniProgram()->accessToken()->getToken();
        $url = ApiUrl::generateURL(ApiUrl::ADD_TEMPLATE, [
            'ACCESS_TOKEN' => $token
        ]);
        $responseArray = NetWork::postJsonForJson($url, $data);
        $ex = MiniProgramError::hasException($responseArray);
        if ($ex) {
            throw $ex;
        }
        return $responseArray;
    }

    /**
     * 获取当前帐号下的个人模板列表（订阅消息）
     * @return array
     * @throws MiniProgramError
     * @throws \EasySwoole\HttpClient\Exception\InvalidUrl
     * @throws \EasySwoole\WeChat\Exception\RequestError
     */
    public function getTemplateList()
    {
        $token = $this->getMiniProgram()->accessToken()->getToken();
        $url = ApiUrl::generateURL(ApiUrl::GET_TEMPLATE, [
            'ACCESS_TOKEN' => $token
        ]);
        $responseArray = NetWork::getForJson($url, []);
        $ex = MiniProgramError::hasException($responseArray);
        if ($ex) {
            throw $ex;
        }
        return $responseArray;
    }

    /**
     * 发送订阅消息
     * @param array $data
     * @return array
     * @throws MiniProgramError
     * @throws \EasySwoole\HttpClient\Exception\InvalidUrl
     * @throws \EasySwoole\WeChat\Exception\RequestError
     */
    public function sendMsg(array $data)
    {
        $token = $this->getMiniProgram()->accessToken()->getToken();
        $url = ApiUrl::generateURL(ApiUrl::SUBSCRIBE_SEND, [
            'ACCESS_TOKEN' => $token
        ]);
        $responseArray = NetWork::postJsonForJson($url, $data);
        $ex = MiniProgramError::hasException($responseArray);
        if ($ex) {
            throw $ex;
        }
        return $responseArray;
    }
}