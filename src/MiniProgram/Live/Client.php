<?php

namespace EasySwoole\WeChat\MiniProgram\Live;

use EasySwoole\WeChat\MiniProgram\BaseClient;
use EasySwoole\WeChat\Kernel\ServiceProviders;

/**
 * Class Client
 * @author master@kyour.cn
 * @package EasySwoole\WeChat\MiniProgram\Live
 * doc link https://developers.weixin.qq.com/miniprogram/dev/framework/liveplayer/studio-api.html#2
 * desc 【小程序直播】直播间管理接口
 */
class Client extends BaseClient
{
    /**
     * Get Room List.
     * 获取直播房间列表
     * doc link: https://developers.weixin.qq.com/miniprogram/dev/framework/liveplayer/studio-api.html#2
     *
     * @param int $start
     * @param int $limit
     *
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function getRooms(int $start = 0, int $limit = 10)
    {
        $params = [
            'start' => $start,
            'limit' => $limit,
        ];

        return $this->query($params);
    }

    /**
     * Get Playback List.
     * 获取直播间回放
     * doc link: https://developers.weixin.qq.com/miniprogram/dev/framework/liveplayer/studio-api.html#3
     *
     * @param int $roomId
     * @param int $start
     * @param int $limit
     *
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function getPlaybacks(int $roomId, int $start = 0, int $limit = 10)
    {
        $params = [
            'action' => 'get_replay',
            'room_id' => $roomId,
            'start' => $start,
            'limit' => $limit,
        ];

        return $this->query($params);
    }

    /**
    * @return mixed
    * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
    */
    private function query(array $param)
    {
        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($param))
            ->send($this->buildUrl(
                '/wxa/business/getliveinfo',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()])
            );

        $this->checkResponse($response, $parseData);

        return $parseData;
    }
}
