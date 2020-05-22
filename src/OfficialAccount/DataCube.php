<?php
/**
 * Created by PhpStorm.
 * User: EZ
 * Date: 2020/5/19
 * Time: 22:44
 */

namespace EasySwoole\WeChat\OfficialAccount;


use EasySwoole\WeChat\Bean\OfficialAccount\DataCubeMsg;
use EasySwoole\WeChat\Bean\OfficialAccount\DataCubeRequest;
use EasySwoole\WeChat\Exception\OfficialAccountError;
use EasySwoole\WeChat\Utility\NetWork;

class DataCube extends OfficialAccountBase
{

    /**
     * 获取接口分析分时数据(最大时间跨度1)
     *
     * @param DataCubeRequest $dataCubeRequest
     *
     * @return DataCubeRequest
     * @throws OfficialAccountError
     * @throws \EasySwoole\HttpClient\Exception\InvalidUrl
     * @throws \EasySwoole\WeChat\Exception\RequestError
     */
    public function getInterfaceSummaryHour(DataCubeRequest $dataCubeRequest)
    {
        return $this->send($dataCubeRequest, ApiUrl::GET_INTERFACE_SUMMARY_HOUR);
    }

    /**
     * 获取接口分析数据(最大时间跨度30)
     *
     * @param DataCubeRequest $dataCubeRequest
     *
     * @return DataCubeRequest
     * @throws OfficialAccountError
     * @throws \EasySwoole\HttpClient\Exception\InvalidUrl
     * @throws \EasySwoole\WeChat\Exception\RequestError
     */
    public function getInterfaceSummary(DataCubeRequest $dataCubeRequest)
    {
        return $this->send($dataCubeRequest, ApiUrl::GET_INTERFACE_SUMMARY);
    }

    /**
     * 获取公众号结算收入数据及结算主体信息
     *
     * @param DataCubeRequest $dataCubeRequest
     *
     * @return DataCubeRequest
     * @throws OfficialAccountError
     * @throws \EasySwoole\HttpClient\Exception\InvalidUrl
     * @throws \EasySwoole\WeChat\Exception\RequestError
     */
    public function publisherSettlement(DataCubeRequest $dataCubeRequest)
    {
        return $this->send($dataCubeRequest, ApiUrl::PUBLISHER_SETTLEMENT);
    }

    /**
     * 获取公众号返佣商品数据(最大时间跨度60)
     *
     * @param DataCubeRequest $dataCubeRequest
     *
     * @return DataCubeRequest
     * @throws OfficialAccountError
     * @throws \EasySwoole\HttpClient\Exception\InvalidUrl
     * @throws \EasySwoole\WeChat\Exception\RequestError
     */
    public function publisherCpsGeneral(DataCubeRequest $dataCubeRequest)
    {
        return $this->send($dataCubeRequest, ApiUrl::PUBLISHER_CPS_GENERAL);
    }

    /**
     * 获取公众号分广告位数据(最大时间跨度90)
     * @param DataCubeRequest $dataCubeRequest
     *
     * @return DataCubeRequest
     * @throws OfficialAccountError
     * @throws \EasySwoole\HttpClient\Exception\InvalidUrl
     * @throws \EasySwoole\WeChat\Exception\RequestError
     */
    public function publisherAdposGeneral(DataCubeRequest $dataCubeRequest)
    {
        return $this->send($dataCubeRequest, ApiUrl::PUBLISHER_ADPOS_GENERAL);
    }

    /**
     * 获取消息发送分布月数据(最大时间跨度30)
     * @param DataCubeRequest $dataCubeRequest
     *
     * @return DataCubeRequest
     * @throws OfficialAccountError
     * @throws \EasySwoole\HttpClient\Exception\InvalidUrl
     * @throws \EasySwoole\WeChat\Exception\RequestError
     */
    public function getUpStreamMsgDistMonth(DataCubeRequest $dataCubeRequest)
    {
        return $this->send($dataCubeRequest, ApiUrl::GET_UP_STREAM_MSG_DIST_MONTH);
    }

    /**
     * 获取消息发送分布周数据(最大时间跨度30)
     * @param DataCubeRequest $dataCubeRequest
     *
     * @return DataCubeRequest
     * @throws OfficialAccountError
     * @throws \EasySwoole\HttpClient\Exception\InvalidUrl
     * @throws \EasySwoole\WeChat\Exception\RequestError
     */
    public function getUpStreamMsgDistWeek(DataCubeRequest $dataCubeRequest)
    {
        return $this->send($dataCubeRequest, ApiUrl::GET_UP_STREAM_MSG_DIST_WEEK);
    }

    /**
     * 获取消息发送分布数据(最大时间跨度15)
     * @param DataCubeRequest $dataCubeRequest
     *
     * @return DataCubeRequest
     * @throws OfficialAccountError
     * @throws \EasySwoole\HttpClient\Exception\InvalidUrl
     * @throws \EasySwoole\WeChat\Exception\RequestError
     */
    public function getUpStreamMsgDist(DataCubeRequest $dataCubeRequest)
    {
        return $this->send($dataCubeRequest, ApiUrl::GET_UP_STREAM_MSG_DIST);
    }

    /**
     * 获取消息发送月数据(最大时间跨度30)
     * @param DataCubeRequest $dataCubeRequest
     *
     * @return DataCubeRequest
     * @throws OfficialAccountError
     * @throws \EasySwoole\HttpClient\Exception\InvalidUrl
     * @throws \EasySwoole\WeChat\Exception\RequestError
     */
    public function getUpStreamMsgMonth(DataCubeRequest $dataCubeRequest)
    {
        return $this->send($dataCubeRequest, ApiUrl::GET_UP_STREAM_MSG_MONTH);
    }

    /**
     * 获取消息发送周数据(最大时间跨度30)
     * @param DataCubeRequest $dataCubeRequest
     *
     * @return DataCubeRequest
     * @throws OfficialAccountError
     * @throws \EasySwoole\HttpClient\Exception\InvalidUrl
     * @throws \EasySwoole\WeChat\Exception\RequestError
     */
    public function getUpStreamMsgWeek(DataCubeRequest $dataCubeRequest)
    {
        return $this->send($dataCubeRequest, ApiUrl::GET_UP_STREAM_MSG_WEEK);
    }

    /**
     * 获取消息发送分时数据(最大时间跨度1)
     * @param DataCubeRequest $dataCubeRequest
     *
     * @return DataCubeRequest
     * @throws OfficialAccountError
     * @throws \EasySwoole\HttpClient\Exception\InvalidUrl
     * @throws \EasySwoole\WeChat\Exception\RequestError
     */
    public function getUpStreamMsgHour(DataCubeRequest $dataCubeRequest)
    {
        return $this->send($dataCubeRequest, ApiUrl::GET_UP_STREAM_MSG_HOUR);
    }

    /**
     * 获取消息发送概况数据(最大时间跨度7)
     * @param DataCubeRequest $dataCubeRequest
     *
     * @return DataCubeRequest
     * @throws OfficialAccountError
     * @throws \EasySwoole\HttpClient\Exception\InvalidUrl
     * @throws \EasySwoole\WeChat\Exception\RequestError
     */
    public function getUpStreamMsg(DataCubeRequest $dataCubeRequest)
    {
        return $this->send($dataCubeRequest, ApiUrl::GET_UP_STREAM_MSG);
    }

    /**
     * 获取图文分享转发分时数据(最大时间跨度1)
     * @param DataCubeRequest $dataCubeRequest
     *
     * @return DataCubeRequest
     * @throws OfficialAccountError
     * @throws \EasySwoole\HttpClient\Exception\InvalidUrl
     * @throws \EasySwoole\WeChat\Exception\RequestError
     */
    public function getUserShareHour(DataCubeRequest $dataCubeRequest)
    {
        return $this->send($dataCubeRequest, ApiUrl::GET_USER_SHARE_HOUR);
    }

    /**
     * 获取图文分享转发数据(最大时间跨度7)
     * @param DataCubeRequest $dataCubeRequest
     *
     * @return DataCubeRequest
     * @throws OfficialAccountError
     * @throws \EasySwoole\HttpClient\Exception\InvalidUrl
     * @throws \EasySwoole\WeChat\Exception\RequestError
     */
    public function getUserShare(DataCubeRequest $dataCubeRequest)
    {
        return $this->send($dataCubeRequest, ApiUrl::GET_USER_SHARE);
    }

    /**
     * 获取图文统计分时数据(最大时间跨度1)
     * @param DataCubeRequest $dataCubeRequest
     *
     * @return DataCubeRequest
     * @throws OfficialAccountError
     * @throws \EasySwoole\HttpClient\Exception\InvalidUrl
     * @throws \EasySwoole\WeChat\Exception\RequestError
     */
    public function getUserReadHour(DataCubeRequest $dataCubeRequest)
    {
        return $this->send($dataCubeRequest, ApiUrl::GET_USER_READ_HOUR);
    }

    /**
     * 获取图文统计数据(最大时间跨度3)
     * @param DataCubeRequest $dataCubeRequest
     *
     * @return DataCubeRequest
     * @throws OfficialAccountError
     * @throws \EasySwoole\HttpClient\Exception\InvalidUrl
     * @throws \EasySwoole\WeChat\Exception\RequestError
     */
    public function getUserRead(DataCubeRequest $dataCubeRequest)
    {
        return $this->send($dataCubeRequest, ApiUrl::GET_USER_READ);
    }

    /**
     * 获取图文群发总数据(最大时间跨度1)
     *
     * @param DataCubeRequest $dataCubeRequest
     *
     * @return DataCubeRequest
     * @throws OfficialAccountError
     * @throws \EasySwoole\HttpClient\Exception\InvalidUrl
     * @throws \EasySwoole\WeChat\Exception\RequestError
     */
    public function getArticleTotal(DataCubeRequest $dataCubeRequest)
    {
        return $this->send($dataCubeRequest, ApiUrl::GET_ARTICLE_TOTAL);
    }

    /**
     * 获取图文群发每日数据(最大时间跨度1)
     * @param DataCubeRequest $dataCubeRequest
     *
     * @return DataCubeRequest
     * @throws OfficialAccountError
     * @throws \EasySwoole\HttpClient\Exception\InvalidUrl
     * @throws \EasySwoole\WeChat\Exception\RequestError
     */
    public function getArticleSummary(DataCubeRequest $dataCubeRequest)
    {
        return $this->send($dataCubeRequest, ApiUrl::GET_ARTICLE_SUMMARY);
    }

    /**
     * 获取累计用户数据(最大时间跨度7)
     *
     * @param DataCubeRequest $dataCubeRequest
     *
     * @return DataCubeRequest
     * @throws OfficialAccountError
     * @throws \EasySwoole\HttpClient\Exception\InvalidUrl
     * @throws \EasySwoole\WeChat\Exception\RequestError
     */
    public function getUserCumulate(DataCubeRequest $dataCubeRequest)
    {
        return $this->send($dataCubeRequest, ApiUrl::GET_USER_CUMULATE);
    }

    /**
     * 获取永不增减数据(最大时间跨度7)
     *
     * @param DataCubeRequest $dataCubeRequest
     *
     * @return DataCubeRequest
     * @throws OfficialAccountError
     * @throws \EasySwoole\HttpClient\Exception\InvalidUrl
     * @throws \EasySwoole\WeChat\Exception\RequestError
     */
    public function getUserSummary(DataCubeRequest $dataCubeRequest)
    {
        return $this->send($dataCubeRequest, ApiUrl::GET_USER_SUMMARY);
    }

    /**
     * @param DataCubeRequest $dataCubeRequest
     * @param string          $url
     *
     * @return DataCubeRequest
     * @throws OfficialAccountError
     * @throws \EasySwoole\HttpClient\Exception\InvalidUrl
     * @throws \EasySwoole\WeChat\Exception\RequestError
     */
    private function send(DataCubeRequest $dataCubeRequest, string $url)
    {
        $url = ApiUrl::generateURL($url, [
            'ACCESS_TOKEN' => $this->getOfficialAccount()->accessToken()->getToken()
        ]);

        $data = $dataCubeRequest->buildRequest()->getArrayCopy();

        $response = NetWork::postJsonForJson($url, $data);

        $ex = OfficialAccountError::hasException($response);

        if ($ex) {
            throw $ex;
        } else {
            return new DataCubeRequest($response);
        }
    }
}