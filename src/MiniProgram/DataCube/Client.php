<?php

namespace EasySwoole\WeChat\MiniProgram\DataCube;

use EasySwoole\WeChat\MiniProgram\BaseClient;
use EasySwoole\WeChat\Kernel\ServiceProviders;

/**
 * Class Client
 * @author master@kyour.cn
 * @package EasySwoole\WeChat\MiniProgram\DataCube
 * desc 数据分析
 * doc link: https://developers.weixin.qq.com/miniprogram/dev/api-backend/open-api/data-analysis/visit-retain/analysis.getDailyRetain.html
 */
class Client extends BaseClient
{
    /**
     * Get daily retain info.
     * 获取用户访问小程序日留存
     * doc link: https://developers.weixin.qq.com/miniprogram/dev/api-backend/open-api/data-analysis/visit-retain/analysis.getDailyRetain.html
     *
     * @param string $from
     * @param string $to
     *
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function dailyRetainInfo(string $from, string $to)
    {
        return $this->query('/datacube/getweanalysisappiddailyretaininfo', $from, $to);
    }

    /**
     * Get monthly retain info.
     * 获取用户访问小程序月留存
     * doc link: https://developers.weixin.qq.com/miniprogram/dev/api-backend/open-api/data-analysis/visit-retain/analysis.getMonthlyRetain.html
     *
     * @param string $from
     * @param string $to
     *
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function monthlyRetainInfo(string $from, string $to)
    {
        return $this->query('/datacube/getweanalysisappidmonthlyretaininfo', $from, $to);
    }

    /**
     * Get weekly retain info.
     * 获取用户访问小程序周留存
     * doc link: https://developers.weixin.qq.com/miniprogram/dev/api-backend/open-api/data-analysis/visit-retain/analysis.getWeeklyRetain.html
     *
     * @param string $from
     * @param string $to
     *
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function weeklyRetainInfo(string $from, string $to)
    {
        return $this->query('/datacube/getweanalysisappidweeklyretaininfo', $from, $to);
    }

    /**
     * Get summary trend.
     * 获取用户访问小程序数据概况
     * doc link: https://developers.weixin.qq.com/miniprogram/dev/api-backend/open-api/data-analysis/analysis.getDailySummary.html
     *
     * @param string $from
     * @param string $to
     *
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function summaryTrend(string $from, string $to)
    {
        return $this->query('/datacube/getweanalysisappiddailysummarytrend', $from, $to);
    }

    /**
     * Get daily visit trend.
     * 获取用户访问小程序数据日趋势
     * doc link: https://developers.weixin.qq.com/miniprogram/dev/api-backend/open-api/data-analysis/visit-trend/analysis.getDailyVisitTrend.html
     *
     * @param string $from
     * @param string $to
     *
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function dailyVisitTrend(string $from, string $to)
    {
        return $this->query('/datacube/getweanalysisappiddailyvisittrend', $from, $to);
    }


    /**
     * Get monthly visit trend.
     * 获取用户访问小程序数据月趋势(能查询到的最新数据为上一个自然月的数据)
     * doc link: https://developers.weixin.qq.com/miniprogram/dev/api-backend/open-api/data-analysis/visit-trend/analysis.getMonthlyVisitTrend.html
     *
     * @param string $from
     * @param string $to
     *
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function monthlyVisitTrend(string $from, string $to)
    {
        return $this->query('/datacube/getweanalysisappidmonthlyvisittrend', $from, $to);
    }

    /**
     * Get weekly visit trend.
     * 获取用户访问小程序数据周趋势
     * doc link: https://developers.weixin.qq.com/miniprogram/dev/api-backend/open-api/data-analysis/visit-trend/analysis.getWeeklyVisitTrend.html
     *
     * @param string $from
     * @param string $to
     *
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function weeklyVisitTrend(string $from, string $to)
    {
        return $this->query('/datacube/getweanalysisappidweeklyvisittrend', $from, $to);
    }

    /**
     * Get user portrait.
     * 获取小程序新增或活跃用户的画像分布数据
     * doc link: https://developers.weixin.qq.com/miniprogram/dev/api-backend/open-api/data-analysis/analysis.getUserPortrait.html
     *
     * @param string $from
     * @param string $to
     *
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function userPortrait(string $from, string $to)
    {
        return $this->query('/datacube/getweanalysisappiduserportrait', $from, $to);
    }

    /**
     * Get visit distribution.
     * 获取用户小程序访问分布数据
     * doc link: https://developers.weixin.qq.com/miniprogram/dev/api-backend/open-api/data-analysis/analysis.getVisitDistribution.html
     *
     * @param string $from
     * @param string $to
     *
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function visitDistribution(string $from, string $to)
    {
        return $this->query('/datacube/getweanalysisappidvisitdistribution', $from, $to);
    }

    /**
     * Get visit page.
     * 访问页面
     * doc link: https://developers.weixin.qq.com/miniprogram/dev/api-backend/open-api/data-analysis/analysis.getVisitPage.html
     *
     * @param string $from
     * @param string $to
     *
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function visitPage(string $from, string $to)
    {
        return $this->query('/datacube/getweanalysisappidvisitpage', $from, $to);
    }

    /**
     * Unify query.
     *
     * @param string $api
     * @param string $from
     * @param string $to
     *
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    private function query(string $api, string $from, string $to)
    {
        $params = [
            'begin_date' => $from,
            'end_date' => $to,
        ];

        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                $api,
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()])
            );

        $this->checkResponse($response, $parseData);

        return $parseData;
    }
}
