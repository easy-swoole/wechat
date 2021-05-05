<?php

namespace EasySwoole\WeChat\MiniProgram\Broadcast;


use EasySwoole\WeChat\Kernel\ServiceProviders;
use EasySwoole\WeChat\MiniProgram\BaseClient;

/**
 * Class Client
 * @package EasySwoole\WeChat\MiniProgram\Broadcast
 * @author: XueSi
 * @email: <1592328848@qq.com>
 * doc link: https://developers.weixin.qq.com/miniprogram/dev/framework/liveplayer/commodity-api.html
 * desc 小程序直播-直播间、商品管理、成员管理、长期订阅相关接口
 *
 */
class Client extends BaseClient
{
    /****************** 商品管理接口 ****************/
    # doc link: https://developers.weixin.qq.com/miniprogram/dev/framework/liveplayer/commodity-api.html
    /**
     * Add broadcast goods.
     * 商品添加并提审
     *
     * @param array $goodsInfo
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function create(array $goodsInfo)
    {
        $params = [
            'goodsInfo' => $goodsInfo,
        ];

        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/wxaapi/broadcast/goods/add',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()])
            );

        $this->checkResponse($response, $parseData);

        return $parseData;
    }

    /**
     * Reset audit.
     * 撤回审核
     *
     * @param int $auditId
     * @param int $goodsId
     * @return bool
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function resetAudit(int $auditId, int $goodsId)
    {
        $params = [
            'auditId' => $auditId,
            'goodsId' => $goodsId,
        ];

        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/wxaapi/broadcast/goods/resetaudit',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()])
            );

        return $this->checkResponse($response);
    }

    /**
     * Resubmit audit goods.
     * 重新提交审核
     *
     * @param int $goodsId
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function resubmitAudit(int $goodsId)
    {
        $params = [
            'goodsId' => $goodsId,
        ];

        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/wxaapi/broadcast/goods/audit',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()])
            );

        $this->checkResponse($response, $parseData);

        return $parseData;
    }


    /**
     * Delete broadcast goods.
     * 删除商品
     *
     * @param int $goodsId
     * @return bool
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function delete(int $goodsId)
    {
        $params = [
            'goodsId' => $goodsId,
        ];

        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/wxaapi/broadcast/goods/delete',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()])
            );

        return $this->checkResponse($response);
    }

    /**
     * Update goods info.
     * 更新商品
     *
     * @param array $goodsInfo
     * @return bool
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function update(array $goodsInfo)
    {
        $params = [
            'goodsInfo' => $goodsInfo,
        ];

        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/wxaapi/broadcast/goods/update',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()])
            );

        return $this->checkResponse($response);
    }

    /**
     * Get goods information and review status.
     * 获取商品状态
     *
     * @param array $goodsIdArray
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function getGoodsWarehouse(array $goodsIdArray)
    {
        $params = [
            'goods_ids' => $goodsIdArray,
        ];

        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/wxa/business/getgoodswarehouse',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()])
            );

        $this->checkResponse($response, $parseData);

        return $parseData;
    }


    /**
     * Get goods list based on status
     * 获取商品列表
     *
     * @param array $params
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function getApproved(array $params)
    {
        $params['access_token'] = $this->app[ServiceProviders::AccessToken]->getToken();

        $response = $this->getClient()
            ->setMethod('GET')
            ->send($this->buildUrl(
                '/wxaapi/broadcast/goods/getapproved',
                $params)
            );

        $this->checkResponse($response, $parseData);

        return $parseData;
    }

    /**************** 直播间接口 ******************/
    # doc link: https://developers.weixin.qq.com/miniprogram/dev/framework/liveplayer/studio-api.html
    /**
     * Create a live room.
     * 创建直播间
     *
     * @param array $params
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function createLiveRoom(array $params)
    {
        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/wxaapi/broadcast/room/create',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()])
            );

        $this->checkResponse($response, $parseData);

        return $parseData;
    }

    /**
     * Get Room List.
     * 获取直播间列表
     *
     * @param int $start
     * @param int $limit
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function getRooms(int $start = 0, int $limit = 10)
    {
        $params = [
            'start' => $start,
            'limit' => $limit,
        ];

        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/wxa/business/getliveinfo',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()])
            );

        $this->checkResponse($response, $parseData);

        return $parseData;
    }

    /**
     * Get Playback List.
     * 获取直播间回放
     *
     * @param int $roomId
     * @param int $start
     * @param int $limit
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

        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/wxa/business/getliveinfo',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()])
            );

        $this->checkResponse($response, $parseData);

        return $parseData;
    }

    /**
     * Add goods to the designated live room.
     * 直播间导入商品
     *
     * @param array $params
     * @return bool
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function addGoods(array $params)
    {
        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/wxaapi/broadcast/room/addgoods',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()])
            );

        return $this->checkResponse($response);
    }

    /**
     * Delete a live room.
     * 删除直播间
     *
     * @param array $params
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function deleteLiveRoom(array $params)
    {
        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/wxaapi/broadcast/room/deleteroom',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()])
            );

        return $this->checkResponse($response);
    }

    /**
     * Update a live room.
     * 编辑直播间
     *
     * @param array $params
     * @return bool
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function updateLiveRoom(array $params)
    {
        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/wxaapi/broadcast/room/editroom',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()])
            );

        return $this->checkResponse($response);
    }

    /**
     * Gets the live room push stream url.
     * 获取直播间推流地址
     *
     * @param array $params
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function getPushUrl(array $params)
    {
        $params['access_token'] = $this->app[ServiceProviders::AccessToken]->getToken();

        $response = $this->getClient()
            ->setMethod('GET')
            ->send($this->buildUrl(
                '/wxaapi/broadcast/room/getpushurl',
                $params)
            );

        $this->checkResponse($response, $parseData);

        return $parseData;
    }

    /**
     * Gets the live room share qrcode.
     * 获取直播间分享二维码
     *
     * @param array $params
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function getShareQrcode(array $params)
    {
        $params['access_token'] = $this->app[ServiceProviders::AccessToken]->getToken();

        $response = $this->getClient()
            ->setMethod('GET')
            ->send($this->buildUrl(
                '/wxaapi/broadcast/room/getsharedcode',
                $params)
            );

        $this->checkResponse($response, $parseData);

        return $parseData;
    }

    /**
     * Add a live room assistant.
     * 添加管理直播间小助手
     *
     * @param array $params
     * @return bool
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function addAssistant(array $params)
    {
        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/wxaapi/broadcast/room/addassistant',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()])
            );

        return $this->checkResponse($response);
    }

    /**
     * Update a live room assistant.
     * 修改管理直播间小助手
     *
     * @param array $params
     * @return bool
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function updateAssistant(array $params)
    {
        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/wxaapi/broadcast/room/modifyassistant',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()])
            );

        return $this->checkResponse($response);
    }

    /**
     * Delete a live room assistant.
     * 删除直播间小助手
     *
     * @param array $params
     * @return bool
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function deleteAssistant(array $params)
    {
        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/wxaapi/broadcast/room/removeassistant',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()])
            );

        return $this->checkResponse($response);
    }

    /**
     * Gets the assistant list.
     * 查询管理直播间小助手
     *
     * @param array $params
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function getAssistantList(array $params)
    {
        $params['access_token'] = $this->app[ServiceProviders::AccessToken]->getToken();

        $response = $this->getClient()
            ->setMethod('GET')
            ->send($this->buildUrl('/wxaapi/broadcast/room/getassistantlist',
                $params)
            );

        $this->checkResponse($response, $parseData);

        return $parseData;
    }

    /**
     * Add the sub anchor.
     * 添加主播副号
     *
     * @param array $params
     * @return bool
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function addSubAnchor(array $params)
    {
        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/wxaapi/broadcast/room/addsubanchor',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()])
            );

        return $this->checkResponse($response);
    }

    /**
     * Update the sub anchor.
     * 修改主播副号
     *
     * @param array $params
     * @return bool
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function updateSubAnchor(array $params)
    {
        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/wxaapi/broadcast/room/modifysubanchor',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()])
            );

        return $this->checkResponse($response);
    }

    /**
     * Delete the sub anchor.
     * 删除主播副号
     *
     * @param array $params
     * @return bool
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function deleteSubAnchor(array $params)
    {
        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/wxaapi/broadcast/room/deletesubanchor',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()])
            );

        return $this->checkResponse($response);
    }

    /**
     * Gets the sub anchor info.
     * 获取主播副号
     *
     * @param array $params
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     * @date: 2021/4/6 22:59
     * @author: XueSi
     * @email: <1592328848@qq.com>
     */
    public function getSubAnchor(array $params)
    {
        $params['access_token'] = $this->app[ServiceProviders::AccessToken]->getToken();

        $response = $this->getClient()
            ->setMethod('GET')
            ->send($this->buildUrl(
                '/wxaapi/broadcast/room/getsubanchor',
                $params)
            );

        $this->checkResponse($response, $parseData);

        return $parseData;
    }

    /**
     * Turn official index on/off.
     * 开启/关闭直播间官方收录
     *
     * @param array $params
     * @return bool
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     * @date: 2021/4/6 23:00
     * @author: XueSi
     * @email: <1592328848@qq.com>
     */
    public function updateFeedPublic(array $params)
    {
        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/wxaapi/broadcast/room/updatefeedpublic',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()])
            );

        return $this->checkResponse($response);
    }

    /**
     * Turn playback status on/off.
     * 开启/关闭回放功能
     *
     * @param array $params
     * @return bool
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function updateReplay(array $params)
    {
        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/wxaapi/broadcast/room/updatereplay',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()])
            );

        return $this->checkResponse($response);
    }

    /**
     * Turn customer service status on/off.
     * 开启/关闭客服功能
     *
     * @param array $params
     * @return bool
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function updateKf(array $params)
    {
        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/wxaapi/broadcast/room/updatekf',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()])
            );

        return $this->checkResponse($response);
    }

    /**
     * Turn global comments status on/off.
     * 开启/关闭直播间全局禁言
     *
     * @param array $params
     * @return bool
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function updateComment(array $params)
    {
        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/wxaapi/broadcast/room/updatecomment',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()])
            );

        return $this->checkResponse($response);
    }

    /**
     * Change the status of goods on/off shelves in room.
     * 上下架商品
     *
     * @param array $params
     * @return bool
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function updateGoodsInRoom(array $params)
    {
        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/wxaapi/broadcast/goods/onsale',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()])
            );

        return $this->checkResponse($response);
    }

    /**
     * Delete goods in room.
     * 删除商品
     *
     * @param array $params
     * @return bool
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function deleteGoodsInRoom(array $params)
    {
        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/wxaapi/broadcast/goods/deleteInRoom',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()])
            );

        return $this->checkResponse($response);
    }

    /**
     * Push goods in room.
     * 推送商品
     *
     * @param array $params
     * @return bool
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function pushGoods(array $params)
    {
        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/wxaapi/broadcast/goods/push',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()])
            );

        return $this->checkResponse($response);
    }

    /**
     * Change goods sort in room.
     * 直播间商品排序
     *
     * @param array $params
     * @return bool
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function sortGoods(array $params)
    {
        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/wxaapi/broadcast/goods/sort',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()])
            );

        return $this->checkResponse($response);
    }

    /**
     * Download goods explanation video.
     * 下载商品讲解视频
     *
     * @param array $params
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function downloadGoodsExplanationVideo(array $params)
    {
        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/wxaapi/broadcast/goods/getVideo',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()])
            );

        $this->checkResponse($response, $parseData);

        return $parseData;
    }

    /************* 成员管理接口 ***********************/
    /**
     * Add member role.
     * 设置成员角色
     *
     * @param array $params
     * @return bool
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function addRole(array $params)
    {
        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/wxaapi/broadcast/role/addrole',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()])
            );

        return $this->checkResponse($response);
    }

    /**
     * Delete member role.
     * 解除成员角色
     *
     * @param array $params
     * @return bool
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function deleteRole(array $params)
    {
        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/wxaapi/broadcast/role/deleterole',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()])
            );

        return $this->checkResponse($response);
    }

    /**
     * Gets the role list.
     * 查询成员列表
     *
     * @param array $params
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function getRoleList(array $params)
    {
        $params['access_token'] = $this->app[ServiceProviders::AccessToken]->getToken();

        $response = $this->getClient()
            ->setMethod('GET')
            ->send($this->buildUrl(
                '/wxaapi/broadcast/role/getrolelist',
                $params)
            );

        $this->checkResponse($response, $parseData);

        return $parseData;
    }

    /*********** 长期订阅相关接口 ************/
    /**
     * Gets long-term subscribers.
     * 调用此接口获取长期订阅用户列表
     *
     *
     * @param array $params
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function getFollowers(array $params)
    {
        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/wxa/business/get_wxa_followers',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()])
            );

        $this->checkResponse($response, $parseData);

        return $parseData;
    }

    /**
     * Sending live broadcast start event to long-term subscribers.
     * 向长期订阅用户群发直播间开始事件
     *
     * @param array $params
     * @return mixed
     * @throws \EasySwoole\WeChat\Kernel\Exceptions\HttpException
     */
    public function pushMessage(array $params)
    {
        $response = $this->getClient()
            ->setMethod('POST')
            ->setBody($this->jsonDataToStream($params))
            ->send($this->buildUrl(
                '/wxa/business/push_message',
                ['access_token' => $this->app[ServiceProviders::AccessToken]->getToken()])
            );

        $this->checkResponse($response, $parseData);

        return $parseData;
    }
}