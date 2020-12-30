<?php
/**
 * Created by PhpStorm.
 * User: 67066
 * Date: 2020/12/30
 * Time: 11:34
 */

namespace EasySwoole\WeChat\OfficialAccount\DataCube;

use EasySwoole\WeChat\Kernel\BaseClient;
use EasySwoole\WeChat\Kernel\Exceptions\HttpException;
use EasySwoole\WeChat\Kernel\ServiceProviders;
use Psr\Http\Message\ResponseInterface;

class PublisherClient extends BaseClient
{
    /**
     * 获取公众号分广告位数据
     * @param int $page 数据返回页数
     * @param int $pageSize 每页返回数据条数
     * @param string $startDate 获取数据的开始时间 yyyy-mm-dd
     * @param string $endDate 获取数据的结束时间 yyyy-mm-dd
     * @param string $adSlot 广告位类型名称 详见https://developers.weixin.qq.com/doc/offiaccount/Analytics/Ad_Analysis.html#%E4%B8%80%E3%80%81%E8%8E%B7%E5%8F%96%E5%85%AC%E4%BC%97%E5%8F%B7%E5%88%86%E5%B9%BF%E5%91%8A%E4%BD%8D%E6%95%B0%E6%8D%AE%EF%BC%88publisher-adpos-general%EF%BC%89
     * @return array
     * @throws
     * */
    function adposGeneral(int $page, int $pageSize, string $startDate, string $endDate, string $adSlot = null)
    {
        $getParam = [
            'access_token' => $this->app[ServiceProviders::AccessToken]->getToken(),
            'action' => 'publisher_adpos_general',
            'page' => $page,
            'page_size' => $pageSize,
            'start_date' => $startDate,
            'end_date' => $endDate,
        ];
        if ($adSlot) {
            $getParam['ad_slot'] = $adSlot;
        }
        $response = $this->getClient()
            ->setMethod('GET')
            ->send($this->buildUrl(
                '/publisher/stat',
                $getParam
            ));
        $this->checkResponse($response, $jsonData);
        return $jsonData;
    }

    /**
     * 获取公众号返佣商品数据
     * @param int $page 数据返回页数
     * @param int $pageSize 每页返回数据条数
     * @param string $startDate 获取数据的开始时间 yyyy-mm-dd
     * @param string $endDate 获取数据的结束时间 yyyy-mm-dd
     * @return array
     * @throws
     * */
    function cpsGeneral(int $page, int $pageSize, string $startDate, string $endDate)
    {
        $getParam = [
            'access_token' => $this->app[ServiceProviders::AccessToken]->getToken(),
            'action' => 'publisher_cps_general',
            'page' => $page,
            'page_size' => $pageSize,
            'start_date' => $startDate,
            'end_date' => $endDate,
        ];

        $response = $this->getClient()
            ->setMethod('GET')
            ->send($this->buildUrl(
                '/publisher/stat',
                $getParam
            ));
        $this->checkResponse($response, $jsonData);
        return $jsonData;
    }

    /**
     * 获取公众号结算收入数据及结算主体信息
     * @param int $page 数据返回页数
     * @param int $pageSize 每页返回数据条数
     * @param string $startDate 获取数据的开始时间 yyyy-mm-dd
     * @param string $endDate 获取数据的结束时间 yyyy-mm-dd
     * @return array
     * @throws
     * */
    function settlement(int $page, int $pageSize, string $startDate, string $endDate)
    {
        $getParam = [
            'access_token' => $this->app[ServiceProviders::AccessToken]->getToken(),
            'action' => 'publisher_settlement',
            'page' => $page,
            'page_size' => $pageSize,
            'start_date' => $startDate,
            'end_date' => $endDate,
        ];

        $response = $this->getClient()
            ->setMethod('GET')
            ->send($this->buildUrl(
                '/publisher/stat',
                $getParam
            ));
        $this->checkResponse($response, $jsonData);
        return $jsonData;
    }

    protected function checkResponse(ResponseInterface $response, &$parseData = null): bool
    {
        if (!in_array($response->getStatusCode(), [200])) {
            throw new HttpException(
                $response->getBody()->__toString(),
                $response
            );
        }

        $data = $this->parseData($response);
        $parseData = $data;

        if (isset($data['base_resp']['ret']) && (int)$data['base_resp']['ret'] !== 0) {
            throw new HttpException(
                "request wechat error, message: ({$data['base_resp']['ret']}) {$data['err_msg']}",
                $response,
                $data['errcode']
            );
        }

        return true;
    }
}