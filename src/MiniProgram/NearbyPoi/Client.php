<?php

namespace EasySwoole\WeChat\MiniProgram\NearbyPoi;

use EasySwoole\WeChat\Kernel\Exceptions\InvalidArgumentException;
use EasySwoole\WeChat\Kernel\ServiceProviders;
use EasySwoole\WeChat\MiniProgram\BaseClient;

/**
 * Class Client
 * @package EasySwoole\WeChat\MiniProgram\NearbyPoi
 * @author: XueSi
 * @email: <1592328848@qq.com>
 * doc link: https://developers.weixin.qq.com/miniprogram/dev/api-backend/open-api/nearby-poi/nearbyPoi.add.html
 * desc: 附近的小程序
 */
class Client extends BaseClient
{
    /**
     * Add nearby poi.
     * nearbyPoi.add 添加地点
     * doc link: https://developers.weixin.qq.com/miniprogram/dev/api-backend/open-api/nearby-poi/nearbyPoi.add.html
     *
     * @param array $params
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function add(array $params)
    {
        $params = array_merge([
            'is_comm_nearby' => '1',
            'poi_id' => '',
        ], $params);

        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/wxa/addnearbypoi',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()])
            );

        $this->checkResponse($response, $parseData);

        return $parseData;
    }

    /**
     * Update nearby poi.
     * 更新地点
     * doc link: https://developers.weixin.qq.com/miniprogram/dev/api-backend/open-api/nearby-poi/nearbyPoi.add.html
     *
     * @param string $poiId
     * @param array $params
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function update(string $poiId, array $params)
    {
        $params = array_merge([
            'is_comm_nearby' => '1',
            'poi_id' => $poiId,
        ], $params);

        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/wxa/addnearbypoi',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()])
            );

        $this->checkResponse($response, $parseData);

        return $parseData;
    }

    /**
     * Delete nearby poi.
     * nearbyPoi.delete 删除地点
     * doc link: https://developers.weixin.qq.com/miniprogram/dev/api-backend/open-api/nearby-poi/nearbyPoi.delete.html
     *
     * @param string $poiId
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function delete(string $poiId)
    {
        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream([
                'poi_id' => $poiId,
            ]))
            ->send($this->buildUrl(
                '/wxa/delnearbypoi',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()])
            );

        $this->checkResponse($response, $parseData);

        return $parseData;
    }

    /**
     * Get nearby poi list.
     * nearbyPoi.getList 查看地点列表
     * doc link: https://developers.weixin.qq.com/miniprogram/dev/api-backend/open-api/nearby-poi/nearbyPoi.getList.html
     *
     *
     * @param int $page
     * @param int $pageRows
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function list(int $page, int $pageRows)
    {
        $query = [
            'access_token' => $this->app[ServiceProviders::AccessToken]->getToken(),
            'page' => $page,
            'page_rows' => $pageRows,
        ];

        $response = $this->getClient()
            ->setMethod('GET')
            ->send($this->buildUrl(
                '/wxa/getnearbypoilist',
                $query)
            );

        $this->checkResponse($response, $parseData);

        return $parseData;
    }

    /**
     * Set nearby poi show status.
     * 展示/取消展示附近小程序
     * doc link: https://developers.weixin.qq.com/miniprogram/dev/api-backend/open-api/nearby-poi/nearbyPoi.setShowStatus.html
     *
     * @param string $poiId
     * @param int $status
     * @return mixed
     * @throws InvalidArgumentException
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function setVisibility(string $poiId, int $status)
    {
        if (!in_array($status, [0, 1], true)) {
            throw new InvalidArgumentException('status should be 0 or 1.');
        }

        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream([
                'poi_id' => $poiId,
                'status' => $status,
            ]))
            ->send($this->buildUrl(
                '/wxa/setnearbypoishowstatus',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()])
            );

        return $this->checkResponse($response);
    }
}