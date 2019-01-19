<?php
/**
 * Created by PhpStorm.
 * User: yf
 * Date: 2018-12-30
 * Time: 14:16
 */

namespace EasySwoole\WeChat\OfficialAccount;


use EasySwoole\WeChat\Bean\OfficialAccount\TemplateMsg as MsgBean;
use EasySwoole\WeChat\Utility\HttpClient;

class TemplateMsg extends OfficialAccountBase
{
    /**
     * @param MsgBean $templateMsg
     * @return bool
     * @throws \EasySwoole\WeChat\Exception\OfficialAccountError
     * @throws \EasySwoole\WeChat\Exception\RequestError
     */
    public function send(MsgBean $templateMsg) : bool
    {
        $url = ApiUrl::generateURL(ApiUrl::TEMPLATE_SEND, [
            'ACCESS_TOKEN'=> $this->getOfficialAccount()->accessToken()->getToken()
        ]);

        $response = HttpClient::postJsonForJson($url, $templateMsg->toArray(null, MsgBean::FILTER_NOT_NULL));
        $this->hasException($response);
        return true;
    }

    /**
     * @param $templateId
     * @return mixed
     * @throws \EasySwoole\WeChat\Exception\OfficialAccountError
     * @throws \EasySwoole\WeChat\Exception\RequestError
     */
    public function deletePrivateTemplate($templateId) : bool
    {
        $url = ApiUrl::generateURL(ApiUrl::TEMPLATE_DELETE, [
            'ACCESS_TOKEN'=> $this->getOfficialAccount()->accessToken()->getToken()
        ]);

        $response = HttpClient::postJsonForJson($url, ['template_id' => $templateId]);
        $this->hasException($response);
        return true;
    }

    /**
     * @return mixed
     * @throws \EasySwoole\WeChat\Exception\OfficialAccountError
     * @throws \EasySwoole\WeChat\Exception\RequestError
     */
    public function getPrivateTemplates()
    {
        $url = ApiUrl::generateURL(ApiUrl::TEMPLATE_GET_ALL, [
            'ACCESS_TOKEN'=> $this->getOfficialAccount()->accessToken()->getToken()
        ]);

        $response = HttpClient::getForJson($url);
        return $this->hasException($response);
    }

    /**
     * @param $shortId
     * @return string
     * @throws \EasySwoole\WeChat\Exception\OfficialAccountError
     * @throws \EasySwoole\WeChat\Exception\RequestError
     */
    public function addTemplate($shortId)
    {
        $url = ApiUrl::generateURL(ApiUrl::TEMPLATE_ADD, [
            'ACCESS_TOKEN'=> $this->getOfficialAccount()->accessToken()->getToken()
        ]);

        $response = HttpClient::postJsonForJson($url, ['template_id_short' => $shortId]);
        return $this->hasException($response)['template_id_short'];
    }

    /**
     * @param  mixed ...$industryId
     * @return bool
     * @throws \EasySwoole\WeChat\Exception\OfficialAccountError
     * @throws \EasySwoole\WeChat\Exception\RequestError
     */
    public function setIndustry(...$industryId) : bool
    {
        $url = ApiUrl::generateURL(ApiUrl::TEMPLATE_SET_INDUSTRY, [
            'ACCESS_TOKEN'=> $this->getOfficialAccount()->accessToken()->getToken()
        ]);

        $response = HttpClient::postJsonForJson($url, $industryId);
        $this->hasException($response);
        return true;
    }

    /**
     * @return mixed
     * @throws \EasySwoole\WeChat\Exception\OfficialAccountError
     * @throws \EasySwoole\WeChat\Exception\RequestError
     */
    public function getIndustry()
    {
        $url = ApiUrl::generateURL(ApiUrl::TEMPLATE_GET_INDUSTRY, [
            'ACCESS_TOKEN'=> $this->getOfficialAccount()->accessToken()->getToken()
        ]);

        $response = HttpClient::getForJson($url);
        return $this->hasException($response);
    }

    /**
     * @param MsgBean $templateMsg
     * @return mixed
     * @throws \EasySwoole\WeChat\Exception\OfficialAccountError
     * @throws \EasySwoole\WeChat\Exception\RequestError
     */
    public function sendSubscription(MsgBean $templateMsg)
    {
        $url = ApiUrl::generateURL(ApiUrl::TEMPLATE_SEND_SUBSCRIBE, [
            'ACCESS_TOKEN'=> $this->getOfficialAccount()->accessToken()->getToken()
        ]);

        $response = HttpClient::postJsonForJson($url, $templateMsg->toArray(null, MsgBean::FILTER_NOT_NULL));
        return $this->hasException($response);
    }
}