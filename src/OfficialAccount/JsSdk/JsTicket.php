<?php


namespace EasySwoole\WeChat\OfficialAccount\JsSdk;


use EasySwoole\WeChat\AbstractInterface\JsTicketInterface;
use EasySwoole\WeChat\Exception\OfficialAccountError;
use EasySwoole\WeChat\OfficialAccount\AccessToken;
use EasySwoole\WeChat\OfficialAccount\ApiUrl;
use EasySwoole\WeChat\Utility\NetWork;

class JsTicket extends JsApiBase implements JsTicketInterface
{
    /**
     * 获取JsTick
     * 自带版本不刷新
     * @param int $refreshTimes
     * @return string
     * @throws OfficialAccountError
     * @throws \EasySwoole\WeChat\Exception\RequestError
     */
    function getTicket($refreshTimes = 1): ?string
    {
        return $this->getOfficialAccount()->getConfig()->getStorage()->get('jsapi_ticket');
    }

    /**
     * 刷新本地的Tick
     * @return string
     * @throws OfficialAccountError
     * @throws \EasySwoole\WeChat\Exception\RequestError
     */
    function refreshTicket(): ?string
    {
        $officialAccountConfig = $this->getOfficialAccount()->getConfig();
        $accessToken = $this->getOfficialAccount()->accessToken()->getToken();
        $response = NetWork::getForJson(ApiUrl::generateURL(ApiUrl::JSAPI_GET_TICKET, [
            'ACCESS_TOKEN' => $accessToken,
        ]));
        $ex = OfficialAccountError::hasException($response);
        if ($ex) {
            throw $ex;
        } else {
            $ticket = $response['ticket'];
            /**
             * 这里故意设置为7180
             */
            $officialAccountConfig->getStorage()->set('jsapi_ticket', $ticket, time() + 7180);
            return $ticket;
        }

    }
}