<?php


namespace EasySwoole\WeChat\MiniProgram;


use EasySwoole\WeChat\Bean\MiniProgram\AddOrder;
use EasySwoole\WeChat\Bean\MiniProgram\BindAccount;
use EasySwoole\WeChat\Exception\MiniProgramError;
use EasySwoole\WeChat\Utility\NetWork;

class LogisticsProgram extends MinProgramBase
{
    /**
     * 绑定、解绑物流账号
     * @param BindAccount $bindAccount
     * @return bool
     * @throws MiniProgramError
     * @throws \EasySwoole\WeChat\Exception\RequestError
     */
    function bindAccount(BindAccount $bindAccount)
    {
        $token = $this->getMiniProgram()->accessToken()->getToken();
        $url = ApiUrl::generateURL(ApiUrl::BIND_ACCOUNT,[
            'ACCESS_TOKEN'  => $token
        ]);

        $response = NetWork::postForJson($url,$bindAccount->toArray());

        $ex = MiniProgramError::hasException($response);

        if ($ex) {
            throw $ex;
        }

        return true;
    }

    /**
     * 获取所有绑定的物流账号
     * @return array
     * @throws MiniProgramError
     * @throws \EasySwoole\WeChat\Exception\RequestError
     */
    function getAllAccount()
    {
        $token = $this->getMiniProgram()->accessToken()->getToken();
        $url = ApiUrl::generateURL(ApiUrl::GET_ALL_ACCOUNT,[
            'ACCESS_TOKEN'  => $token
        ]);

        $responseArray = NetWork::getForJson($url);

        $ex = MiniProgramError::hasException($responseArray);

        if ($ex) {
            throw $ex;
        }

        return $responseArray;
    }

    /**
     * 获取电子面单余额。仅在使用加盟类快递公司时，才可以调用。
     * @param string $deliveryId
     * @param string $bizId
     * @return array
     * @throws MiniProgramError
     * @throws \EasySwoole\WeChat\Exception\RequestError
     */
    function getQuota(string $deliveryId ,string $bizId)
    {
        $token = $this->getMiniProgram()->accessToken()->getToken();

        $url = ApiUrl::generateURL(ApiUrl::GET_QUOTA,[
            'ACCESS_TOKEN'  => $token
        ]);
        $data = [
            'delivery_id'   => $deliveryId,
            'biz_id'        => $bizId
        ];
        $responseArray = NetWork::postForJson($url,$data);

        $ex = MiniProgramError::hasException($responseArray);

        if ($ex) {
            throw $ex;
        }

        return $responseArray;

    }

    /**
     * 生成运单
     * @param AddOrder $addOrder
     * @return array
     * @throws MiniProgramError
     * @throws \EasySwoole\WeChat\Exception\RequestError
     */
    function addOrder(AddOrder $addOrder)
    {
        $token = $this->getMiniProgram()->accessToken()->getToken();
        $url = ApiUrl::generateURL(ApiUrl::ADD_ORDER,[
            'ACCESS_TOKEN'  => $token
        ]);

        $responseArray = NetWork::postForJson($url,$addOrder->toArray());

        $ex = MiniProgramError::hasException($responseArray);

        if ($ex) {
            throw $ex;
        }

        return $responseArray;

    }

    /**
     * 取消运单
     * @param string $orderId
     * @param string $openid
     * @param string $deliveryId
     * @param string $waybillId
     * @return bool
     * @throws MiniProgramError
     * @throws \EasySwoole\WeChat\Exception\RequestError
     */
    function cancelOrder(string $orderId ,string $openid ,string $deliveryId ,string $waybillId)
    {
        $token = $this->getMiniProgram()->accessToken()->getToken();
        $url = ApiUrl::generateURL(ApiUrl::CANCEL_ORDER,[
            'ACCESS_TOKEN'  =>$token
        ]);
        $data = [
            'order_id'      => $orderId,
            'openid'        => $openid,
            'delivery_id'   => $deliveryId,
            'waybill_id'    => $waybillId
        ];

        $response = NetWork::postForJson($url,$data);

        $ex = MiniProgramError::hasException($response);

        if ($ex) {
            throw $ex;
        }

        return true;

    }

    /**
     * 获取支持的快递公司列表
     * @return array
     * @throws MiniProgramError
     * @throws \EasySwoole\WeChat\Exception\RequestError
     */
    function getAllDelivery()
    {
        $token = $this->getMiniProgram()->accessToken()->getToken();
        $url = ApiUrl::generateURL(ApiUrl::GET_ALL_DELIVERY,[
            'ACCESS_TOKEN'  => $token
        ]);

        $responseArray = NetWork::getForJson($url);

        $ex = MiniProgramError::hasException($responseArray);

        if ($ex) {
            throw $ex;
        }

        return $responseArray;
    }

    /**
     * 获取运单数据
     * @param string $orderId
     * @param string $openid
     * @param string $deliveryId
     * @param string $waybillId
     * @return array
     * @throws MiniProgramError
     * @throws \EasySwoole\WeChat\Exception\RequestError
     */
    function getOrder(string $orderId ,string $openid ,string $deliveryId ,string $waybillId)
    {
        $token = $this->getMiniProgram()->accessToken()->getToken();
        $url = ApiUrl::generateURL(ApiUrl::GET_ORDER,[
            'ACCESS_TOKEN'  => $token
        ]);
        $data = [
            'order_id'      => $orderId,
            'openid'        => $openid,
            'delivery_id'   => $deliveryId,
            'waybill_id'    => $waybillId

        ];

        $responseArray = NetWork::postForJson($url,$data);

        $ex = MiniProgramError::hasException($responseArray);

        if ($ex) {
            throw $ex;
        }

        return $responseArray;
    }

    /**
     * 查询运单轨迹
     * @param string $orderId
     * @param string $openid
     * @param string $deliveryId
     * @param string $waybillId
     * @return array
     * @throws MiniProgramError
     * @throws \EasySwoole\WeChat\Exception\RequestError
     */
    function getPath(string $orderId ,string $openid ,string $deliveryId ,string $waybillId)
    {
        $token = $this->getMiniProgram()->accessToken()->getToken();
        $url = ApiUrl::generateURL(ApiUrl::GET_PATH,[
            'ACCESS_TOKEN'  => $token
        ]);
        $data = [
            'order_id'      => $orderId,
            'openid'        => $openid,
            'delivery_id'   => $deliveryId,
            'waybill_id'    => $waybillId

        ];

        $responseArray = NetWork::postForJson($url,$data);

        $ex = MiniProgramError::hasException($responseArray);

        if ($ex) {
            throw $ex;
        }

        return $responseArray;
    }

    /**
     * 获取打印员。若需要使用微信打单 PC 软件，才需要调用。
     * @return array
     * @throws MiniProgramError
     * @throws \EasySwoole\WeChat\Exception\RequestError
     */
    function getPrinter()
    {
        $token = $this->getMiniProgram()->accessToken()->getToken();
        $url = ApiUrl::generateURL(ApiUrl::GET_PRINTER,[
            'ACCESS_TOKEN'  => $token
        ]);

        $responseArray = NetWork::getForJson($url);

        $ex = MiniProgramError::hasException($responseArray);

        if ($ex) {
            throw $ex;
        }

        return $responseArray;

    }

    /**
     * 配置面单打印员,若需要使用微信打单 PC 软件，才需要调用。
     * @param string $openid
     * @param string $updateType
     * @param string $tagidList
     * @return bool
     * @throws MiniProgramError
     * @throws \EasySwoole\WeChat\Exception\RequestError
     */
    function updatePrinter(string $openid ,string $updateType ,string $tagidList)
    {
        $token = $this->getMiniProgram()->accessToken()->getToken();
        $url = ApiUrl::generateURL(ApiUrl::UPDATE_PRINTER,[
            'ACCESS_TOKEN'  => $token
        ]);

        $data = [
            'openid'        => $openid,
            'update_type'   => $updateType,
            'tagid_list'    => $tagidList
        ];

        $response = NetWork::postForJson($url,$data);

        $ex = MiniProgramError::hasException($response);

        if ($ex) {
            throw $ex;
        }

        return true;

    }

}