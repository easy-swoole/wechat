<?php


namespace EasySwoole\WeChat\MiniProgram;

use EasySwoole\WeChat\Exception\MiniProgramError;
use EasySwoole\WeChat\Bean\MiniProgram\TemplateMsg as TemplateMsgBean;
use EasySwoole\WeChat\Utility\NetWork;

/**
 * 小程序模板消息
 * Class TemplateMsg
 *
 * @package EasySwoole\WeChat\MiniProgram
 */
class TemplateMsg extends MinProgramBase
{
    /**
     * 获取帐号下已存在的模板列表
     *
     * @param int $offset
     * @param int $count
     * @return array
     * @throws MiniProgramError
     * @throws \EasySwoole\HttpClient\Exception\InvalidUrl
     * @throws \EasySwoole\WeChat\Exception\RequestError
     */
    public function getTemplateList(int $offset, int $count): array
    {
        $url = ApiUrl::generateURL(ApiUrl::TEMPLATE_GET_TEMPLATE_LIST, [
            'ACCESS_TOKEN' => $this->getMiniProgram()->accessToken()->getToken()
        ]);

        $responseArrays = NetWork::postJsonForJson($url, [
            'offset' => $offset,
            'count'  => $count
        ]);
        $ex = MiniProgramError::hasException($responseArrays);
        if ($ex) {
            throw $ex;
        }

        return $responseArrays;
    }

    /**
     * 获取模板库某个模板标题下关键词库
     *
     * @param string $id
     * @return array
     * @throws MiniProgramError
     * @throws \EasySwoole\HttpClient\Exception\InvalidUrl
     * @throws \EasySwoole\WeChat\Exception\RequestError
     */
    public function getTemplateLibraryById(string $id)
    {
        $url = ApiUrl::generateURL(ApiUrl::TEMPLATE_GET_TEMPLATE_LIBRARY_BY_ID, [
            'ACCESS_TOKEN' => $this->getMiniProgram()->accessToken()->getToken()
        ]);

        $response = NetWork::postJsonForJson($url, ['id' => $id]);
        $ex = MiniProgramError::hasException($response);
        if ($ex) {
            throw $ex;
        }

        return $response;
    }

    /**
     * 组合模板并添加至帐号下的个人模板库
     *
     * @param string $id
     * @param array  $keywordIdList
     * @return string template_id
     * @throws MiniProgramError
     * @throws \EasySwoole\HttpClient\Exception\InvalidUrl
     * @throws \EasySwoole\WeChat\Exception\RequestError
     */
    public function addTemplate(string $id, array $keywordIdList): string
    {
        $url = ApiUrl::generateURL(ApiUrl::TEMPLATE_ADD_TEMPLATE, [
            'ACCESS_TOKEN' => $this->getMiniProgram()->accessToken()->getToken()
        ]);

        $response = NetWork::postJsonForJson($url, [
            'id'              => $id,
            'keyword_id_list' => $keywordIdList
        ]);
        $ex = MiniProgramError::hasException($response);
        if ($ex) {
            throw $ex;
        }

        return $response['template_id'];
    }

    /**
     * 删除帐号下的某个模板
     *
     * @param string $templateId
     * @return bool
     * @throws MiniProgramError
     * @throws \EasySwoole\HttpClient\Exception\InvalidUrl
     * @throws \EasySwoole\WeChat\Exception\RequestError
     */
    public function deleteTemplate(string $templateId): bool
    {
        $url = ApiUrl::generateURL(ApiUrl::TEMPLATE_DELETE_TEMPLATE, [
            'ACCESS_TOKEN' => $this->getMiniProgram()->accessToken()->getToken()
        ]);

        $response = NetWork::postJsonForJson($url, ['template_id' => $templateId]);
        $ex = MiniProgramError::hasException($response);
        if ($ex) {
            throw $ex;
        }

        return true;
    }

    /**
     * 获取小程序模板库标题列表
     *
     * @param int $offset
     * @param int $count
     * @return array
     * @throws MiniProgramError
     * @throws \EasySwoole\HttpClient\Exception\InvalidUrl
     * @throws \EasySwoole\WeChat\Exception\RequestError
     */
    public function getTemplateLibraryList(int $offset, int $count)
    {
        $url = ApiUrl::generateURL(ApiUrl::TEMPLATE_GET_TEMPLATE_LIBRARY_BY_LIST, [
            'ACCESS_TOKEN' => $this->getMiniProgram()->accessToken()->getToken()
        ]);

        $responseArrays = NetWork::postJsonForJson($url, [
            'offset' => $offset,
            'count'  => $count
        ]);
        $ex = MiniProgramError::hasException($responseArrays);
        if ($ex) {
            throw $ex;
        }

        return $responseArrays;
    }

    /**
     * 发送模板消息
     *
     * @param TemplateMsgBean $templateMsg
     * @return bool
     * @throws MiniProgramError
     * @throws \EasySwoole\HttpClient\Exception\InvalidUrl
     * @throws \EasySwoole\WeChat\Exception\RequestError
     */
    public function send(TemplateMsgBean $templateMsg): bool
    {
        $url = ApiUrl::generateURL(ApiUrl::TEMPLATE_SEND, [
            'ACCESS_TOKEN' => $this->getMiniProgram()->accessToken()->getToken()
        ]);

        $response = NetWork::postJsonForJson($url, $templateMsg->getSendMessage());
        $ex = MiniProgramError::hasException($response);
        if ($ex) {
            throw $ex;
        }

        return true;
    }
}